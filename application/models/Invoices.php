<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoices extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		$this->load->library('lcustomer');
		$this->load->library('session');
		$this->load->model('Customers');
		$this->auth->check_admin_auth();
	}
	//Count invoice
	public function count_invoice()
	{
		return $this->db->count_all("invoice");
	}
	//invoice List
	public function invoice_list($perpage,$page)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	
	// invoice search by invoice id
		public function invoice_list_invoice_id($invoice_no)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
	
		$this->db->where('invoice',$invoice_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	// date to date invoice list
	public function invoice_list_date_to_date($from_date,$to_date,$perpage,$page)
	{
		$dateRange = "a.date BETWEEN '$from_date%' AND '$to_date%'";
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//invoice List
	public function invoice_list_count()
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}

	//invoice Search Item
	public function search_inovoice_item($customer_id)
	{
		$this->db->select('a.*,b.customer_name');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('b.customer_id',$customer_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//POS invoice entry
public function pos_invoice_setup($product_id){
		$product_information = $this->db->select('a.*,b.*,c.*')
						->from('product_information a')
						->join('manufacturer_product b','b.product_id=b.product_id')
						->join('product_purchase_details c','a.product_id=c.product_id')
						->where('a.product_id',$product_id)
						->get()
						->row();

		if ($product_information != null) {

			$this->db->select('SUM(a.quantity) as total_purchase');
			$this->db->from('product_purchase_details a');
			$this->db->where('a.product_id',$product_id);
			$total_purchase = $this->db->get()->row();

			$this->db->select('SUM(b.quantity) as total_sale');
			$this->db->from('invoice_details b');
			$this->db->where('b.product_id',$product_id);
			$total_sale = $this->db->get()->row();

			$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

			$data2 = (object)array(
				'total_product' 	=> $available_quantity,
				'manufacturer_price' => $product_information->manufacturer_price, 
				'price' 			=> $product_information->price, 
				'batch_id'          => $product_information->batch_id,
				'expeire_date'      => $product_information->expeire_date,
				'manufacturer_id' 	=> $product_information->manufacturer_id, 
				'product_id' 		=> $product_information->product_id, 
				'discount' 		    => $product_information->product_id,
				'product_name' 		=> $product_information->product_name, 
				'product_model' 	=> $product_information->product_model,
				'unit' 				=> $product_information->unit,
				'tax' 				=> $product_information->tax,
				);

			return $data2;
		}else{
			return false;
		}
	}
	//POS customer setup
	public function pos_customer_setup(){
		$query= $this->db->select('*')
						->from('customer_information')
						->like('customer_name','Walking Customer','after')
						->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Count invoice
	public function invoice_entry()
	{
		$tablecolumn = $this->db->list_fields('tax_collection');
        $num_column = count($tablecolumn)-4;
		$invoice_id = $this->generator(10);
		$invoice_id = strtoupper($invoice_id);
		$quantity = $this->input->post('product_quantity');
		$available_quantity = $this->input->post('available_quantity');
		$cartoon = $this->input->post('cartoon');
        $transection_id=$this->auth->generator(15);
        $createby=$this->session->userdata('user_id');
        $createdate=date('Y-m-d H:i:s');
        // bank info
        $bank_id = $this->input->post('bank_id');
        if(!empty($bank_id)){
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
    
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;
   }

		$result = array();
		foreach($available_quantity as $k => $v)
		{
		    if($v < $quantity[$k])
		    {
		       $this->session->set_userdata(array('error_message'=>display('you_can_not_buy_greater_than_available_qnty')));
		       redirect('Cinvoice');
		    }
		}

		
		$product_id = $this->input->post('product_id');
		if ($product_id == null) {
			$this->session->set_userdata(array('error_message'=>display('please_select_product')));
			redirect('Cinvoice/pos_invoice');
		}

		if (($this->input->post('customer_name_others') == null) && ($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null )) {
			$this->session->set_userdata(array('error_message'=>display('please_select_customer')));
			redirect(base_url().'Cinvoice');
		}

		
		if(($this->input->post('customer_id') == null ) && ($this->input->post('customer_name') == null ))
		{
			$customer_id=$this->auth->generator(15);
			 $c_acc=$this->input->post('customer_name_others').'-'.$customer_id;
            $createby=$this->session->userdata('user_id');
            $createdate=date('Y-m-d H:i:s');
		  	//Customer  basic information adding.
			$data=array(
				'customer_id' 		=> 	$customer_id,
				'customer_name' 	=> 	$this->input->post('customer_name_others'),
				'customer_address' 	=>	$this->input->post('customer_name_others_address'),
				'customer_mobile' 	=> "",
				'customer_email' 	=> "",
				'status' 			=> 2
				);
			// acc coa for customer
		  $customer_coa = [
             'HeadCode'         => $headcode,
             'HeadName'         => $c_acc,
             'PHeadName'        => 'Customer Receivable',
             'HeadLevel'        => '4',
             'IsActive'         => '1',
             'IsTransaction'    => '1',
             'IsGL'             => '0',
             'HeadType'         => 'A',
             'IsBudget'         => '0',
             'IsDepreciation'   => '0',
             'DepreciationRate' => '0',
             'CreateBy'         => $createby,
             'CreateDate'       => $createdate,
        ];
			
			$this->db->insert('customer_information',$data);
			 $this->db->insert('acc_coa',$customer_coa);
			$this->db->select('*');
			$this->db->from('customer_information');
			$query = $this->db->get();
			foreach ($query->result() as $row) {
				$json_customer[] = array('label'=>$row->customer_name,'value'=>$row->customer_id);
			}
			$cache_file ='./my-assets/js/admin_js/json/customer.json';
			$customerList = json_encode($json_customer);
			file_put_contents($cache_file,$customerList);
			


			
		  	//Previous balance adding -> Sending to customer model to adjust the data.
			$this->Customers->previous_balance_add(0,$customer_id);
		}
		else{
			$customer_id=$this->input->post('customer_id');
			
			if(empty($customer_id)){
				$this->session->set_userdata(array('error_message'=>'Please Select Customer'));
			redirect(base_url('Cinvoice'));
			}
		}

	
		//Full or partial Payment record.
	

		//Data inserting into invoice table
		$datainv=array(
			'invoice_id'		=>	$invoice_id,
			'customer_id'		=>	$customer_id,
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'total_tax'			=>	$this->input->post('total_tax'),
			'invoice'			=>	$this->number_generator(),
			'invoice_details'   =>  $this->input->post('inva_details'),
			'total_discount' 	=> 	$this->input->post('total_discount'),
			'invoice_discount' 	=> 	$this->input->post('invdcount'),
			'prevous_due'       =>  $this->input->post('previous'),
            'sales_by'          =>  $this->session->userdata('user_id'),
			'status'			=>	1,
			'payment_type'      =>  $this->input->post('paytype'),
			'bank_id'           =>  (!empty($this->input->post('bank_id'))?$this->input->post('bank_id'):null),
		);
		$this->db->insert('invoice',$datainv);
		 for($j=0;$j<$num_column;$j++){
                $taxfield = 'tax'.$j;
                $taxvalue = 'total_tax'.$j;
              $taxdata[$taxfield]=$this->input->post($taxvalue);
            }
            $taxdata['customer_id'] = $customer_id;
            $taxdata['date']        = (!empty($this->input->post('invoice_date'))?$this->input->post('invoice_date'):date('Y-m-d'));
            $taxdata['relation_id'] = $invoice_id;
            $this->db->insert('tax_collection',$taxdata);
		
		// Insert to customer_ledger Table 
		$data4 = array(
			'transaction_id'	=>	$transection_id,
			'customer_id'		=>	$customer_id,
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('paid_amount'),
			'description'		=>	'Cash Paid By Customer',
			'status'			=>	1,
			'd_c'			    =>	'c'
		);
		$this->db->insert('customer_ledger',$data4);
			$paid_amount=$this->input->post('paid_amount');

			$this->db->set('status', '1');
			$this->db->where('customer_id', $customer_id);
			$this->db->update('customer_information');

          

			//Insert to customer_ledger Table 
			$data2 = array(
				'transaction_id'	=>	$transection_id,
				'customer_id'		=>	$customer_id,
				'receipt_no'		=>	$this->auth->generator(10),
				'date'				=>	$this->input->post('invoice_date'),
				'amount'			=>	$this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
				'payment_type'		=>	1,
				'description'		=>	'Medicine Received By Customer',
				'status'			=>	1,
				'd_c'			    =>	'd'

			);
			$this->db->insert('customer_ledger',$data2);
			  //$transection_id=$this->auth->generator(15);
			//Account table info
			$datat = array(
				'transaction_id'	    =>	$transection_id,
				'relation_id'		    =>	$customer_id,
				'transection_type'	    =>	2,
				'date_of_transection'	=>	$this->input->post('invoice_date'),
				'transection_category'  =>	2,
				'amount'			    =>	$this->input->post('paid_amount'),
				'transection_mood'	    =>	1,
				'description'		    =>	'Medicine Cost'
				
			);
		
			 $this->db->insert('transection',$datat);
		
	 $prinfo  = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id',$product_id)->group_by('product_id')->get()->result(); 
    $purchase_ave = [];
    $i=0;
    foreach ($prinfo as $avg) {
      $purchase_ave [] =  $avg->product_rate*$quantity[$i];
      $i++;
    }
   $sumval = array_sum($purchase_ave);

   $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
    $headn = $cusifo->customer_name.'-'.$customer_id;
    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
    $customer_headcode = $coainfo->HeadCode;
// Cash in Hand debit
      $cc = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Invoice No'.$invoice_id,
      'Debit'          =>  $this->input->post('paid_amount'),
      'Credit'         =>  0,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $createby,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
     // bank ledger
 $bankc = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Invoice No '.$invoice_id,
      'Debit'          =>  $this->input->post('paid_amount'),
      'Credit'         =>  0,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $createby,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
 $banksummary = array(
			'date'			=>	$createdate,
			'ac_type'		=>	'Debit(+)',
			'bank_id'		=>	$this->input->post('bank_id'),
			'description'	=>	'product sale',
			'deposite_id'	=>	$invoice_id,
			'dr'			=>	$this->input->post('paid_amount'),
			'cr'			=>	null,
			'ammount'		=>	$this->input->post('paid_amount'),
			'status'		=>	1
		
		);
       ///Inventory credit
       $inv_credit = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory credit For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $sumval,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$inv_credit);
       
    //Customer debit for Product Value
    $cosdr = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $customer_headcode,
      'Narration'      =>  'Customer debit For Invoice No'.$invoice_id,
      'Debit'          =>  $this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
      'Credit'         =>  0,
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$cosdr);
       //Product Sale income on acc transaction
    $pro_sale_income = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  304,
      'Narration'      =>  'Customer debit For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$pro_sale_income);

       ///Customer credit for Paid Amount 
       $cuscredit = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $customer_headcode,
      'Narration'      =>  'Customer credit for Paid Amount For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $this->input->post('paid_amount'),
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       if(!empty($this->input->post('paid_amount'))){
       		$this->db->insert('acc_transaction',$cuscredit);
       	if($this->input->post('paytype') == 2){
       	$this->db->insert('acc_transaction',$bankc);
       	$this->db->insert('bank_summary',$banksummary);	
       	}
       		if($this->input->post('paytype') == 1){
       	$this->db->insert('acc_transaction',$cc);
       	}
       
  }

		
		$customerinfo = $this->db->select('*')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
		$rate = $this->input->post('product_rate');
		$p_id = $this->input->post('product_id');
		$total_amount   = $this->input->post('total_price');
		$discount_rate  = $this->input->post('discount');
		$tax_amount 	= $this->input->post('tax');
		$batch_id 	    = $this->input->post('batch_id');

		for ($i=0, $n=count($quantity); $i < $n; $i++) {
			$cartoon_quantity = $cartoon[$i];
			$product_quantity = $quantity[$i];
			$product_rate = $rate[$i];
			$product_id = $p_id[$i];
			$total_price = $total_amount[$i];
			$manufacturer_rate=$this->manufacturer_rate($product_id);
			$discount = $discount_rate[$i];
			$tax = $tax_amount[$i];
			$batch= $batch_id[$i];
			
			$data1 = array(
				'invoice_details_id'	=>	$this->generator(15),
				'invoice_id'			=>	$invoice_id,
				'product_id'			=>	$product_id,
				'batch_id'              =>  $batch,
				'quantity'				=>	$product_quantity,
				'rate'					=>	$product_rate,
				'discount'           	=>	$discount,
				'tax'           		=>	$tax,
				'paid_amount'           =>	$this->input->post('paid_amount'),
				'due_amount'           	=>	$this->input->post('due_amount'),
				'manufacturer_rate'     =>	$manufacturer_rate[0]['manufacturer_price'],
				'total_price'           =>	$total_price,
				'status'				=>	1
			);
			
			
			if(!empty($quantity))
			{
				$this->db->insert('invoice_details',$data1);
			}
		}
	
		 $message = 'Mr/Mrs.'.$customerinfo->customer_name.',
        '.'You have purchase  '.$this->input->post('grand_total_price').' '. $currency_details[0]['currency'].' You have paid .'.$this->input->post('paid_amount').' '. $currency_details[0]['currency'];
       
        $this->send_sms($customerinfo->customer_mobile,$message);
		return $invoice_id;
	}

     public function send_sms($phone=null,$msg=null){
        $config_data = $this->db->select('*')->from('sms_settings')->get()->row();
        if($config_data->isinvoice == 0){
            return true;
        }else{
        $recipients=$phone;
         $url      = $config_data->url;//"http://sms.bdtask.com/smsapi"; 
         $senderid =$config_data->sender_id;//"8801847169884";
         $apikey= $config_data->api_key;//"C20029865c42c504afc711.77492546";
         $message=$msg;
 //echo "$url?api_key=$apikey&type=text&contacts=$recipients&senderid=$senderid&msg=$message";
         $urltopost = $config_data->url;//"http://sms.bdtask.com/smsapi";
        $datatopost = array (
        "api_key"  => $apikey,
        "type"     => 'text',
        "senderid" => $senderid,
        "msg"      => $message,
        "contacts" => $recipients
);

$ch = curl_init ($urltopost);
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
//print_r($result);
 if ($result === false)
{
echo sprintf('<span>%s</span>CURL error:', curl_error($ch));
return;
}
        curl_close($ch);
        return $result;
    }
    }
	//Get manufacturer rate of a product
	public function manufacturer_rate($product_id)
	{
		$this->db->select('manufacturer_price');
		$this->db->from('manufacturer_product');
		$this->db->where(array('product_id' => $product_id)); 
		$query = $this->db->get();
		return $query->result_array();
	
	}
	//Retrieve invoice Edit Data
public function retrieve_invoice_editdata($invoice_id)
	{
		$this->db->select('
			a.*,
			c.*,
			a.total_tax,
			b.customer_name,
			c.batch_id,
			c.tax as t_p_tax,
			c.product_id,
			d.product_name,
			d.product_model,
			d.tax,
			d.unit
			');
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//invoice wise prouduct list
	
	//update_invoice
	public function update_invoice()
	{
		$tablecolumn = $this->db->list_fields('tax_collection');
        $num_column = count($tablecolumn)-4;
		$invoice_id = $this->input->post('invoice_id');
		$product_id = $this->input->post('product_id');
		$customer_id  = $this->input->post('customer_id');
        $createby=$this->session->userdata('user_id');
        $quantity = $this->input->post('product_quantity');
        $createdate=date('Y-m-d H:i:s');
         $bank_id = $this->input->post('bank_id');
       $bankname = $this->db->select('bank_name')->from('bank_add')->where('bank_id',$bank_id)->get()->row()->bank_name;
       $bankcoaid = $this->db->select('HeadCode')->from('acc_coa')->where('HeadName',$bankname)->get()->row()->HeadCode;

		$ab=$this->db->select('transaction_id')->from('customer_ledger')->where('invoice_no',$invoice_id)->get()->result();

		

		foreach ($ab as $ab) {
			$tran=$ab->transaction_id;
			$this->db->where('transaction_id',$tran);
		$this->db->delete('transection');
		}
	
		
		$this->db->where('VNo',$invoice_id);
		$this->db->delete('acc_transaction');

		$this->db->where('transaction_id',$tran);
		$this->db->delete('customer_ledger');
		//bank summary
        $this->db->where('deposite_id',$invoice_id);
		$this->db->delete('bank_summary');
        
		// tax colection
		$this->db->where('relation_id',$invoice_id);
		$this->db->delete('tax_collection');
		 $tran = $this->auth->generator(15);		
		$datarcpt = array(
			'transaction_id'	=>	$tran,
			'customer_id'		=>	$this->input->post('customer_id'),
			'receipt_no'		=>	$this->auth->generator(10),
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('paid_amount'),
			'payment_type'		=>	1,
			'description'		=>	'Cash Paid By Customer',
			'status'			=>	1,
			'd_c'			    =>	'c'
		);

	
		$data=array(
		    'invoice_id'        =>  $invoice_id,
			'customer_id'		=>	$this->input->post('customer_id'),
			'date'				=>	$this->input->post('invoice_date'),
			'total_amount'		=>	$this->input->post('grand_total_price'),
			'total_tax'			=>	$this->input->post('total_tax'),
			'invoice_details'   =>  $this->input->post('inva_details'),
			'total_discount' 	=> 	$this->input->post('total_discount'),
			'invoice_discount' 	=> 	$this->input->post('invdcount'),
			'prevous_due'       =>  $this->input->post('previous'),
            'sales_by'          =>  $this->session->userdata('user_id'),
			'status'			=>	1,
			'payment_type'      =>  $this->input->post('paytype'),
			'bank_id'           =>  (!empty($this->input->post('bank_id'))?$this->input->post('bank_id'):null),
		);

		$data2 = array(
			'transaction_id'	=>	$tran,
			'customer_id'		=>	$this->input->post('customer_id'),
			'invoice_no'		=>	$invoice_id,
			'date'				=>	$this->input->post('invoice_date'),
			'amount'			=>	$this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
			'payment_type'		=>	1,
			'description'		=>	'Medicine Received By Customer',
			'status'			=>	1,
			'd_c'			    =>	'd'

		);
		   $pro_sale_income = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  304,
      'Narration'      =>  'Customer debit For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$pro_sale_income);

		$data3 = array(
			'transaction_id'	    =>  $tran,
			'relation_id'		    =>	$this->input->post('customer_id'),
			'transection_type'	    =>	2,
			'date_of_transection'   =>	$this->input->post('invoice_date'),
			'transection_category'  => 2,
			'amount'			    =>	$this->input->post('paid_amount'),
			'transection_mood'	    =>	1,
			'description'		    =>	'Medicine Cost'
			
		);
		
		if($invoice_id!='')
		{
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('invoice',$data); 
			for($j=0;$j<$num_column;$j++){
                $taxfield = 'tax'.$j;
                $taxvalue = 'total_tax'.$j;
              $taxdata[$taxfield]=$this->input->post($taxvalue);
            }
            $taxdata['customer_id'] = $customer_id;
            $taxdata['date']        = (!empty($this->input->post('invoice_date'))?$this->input->post('invoice_date'):date('Y-m-d'));
            $taxdata['relation_id'] = $invoice_id;
            $this->db->insert('tax_collection',$taxdata);
			
			//Update Another table
			$this->db->insert('customer_ledger',$data2); 
			$this->db->insert('customer_ledger',$datarcpt);
			$this->db->insert('transection',$data3);
		}

				
	 $prinfo  = $this->db->select('product_id,Avg(rate) as product_rate')->from('product_purchase_details')->where_in('product_id',$product_id)->group_by('product_id')->get()->result(); 
    $purchase_ave = [];
    $i=0;
    foreach ($prinfo as $avg) {
      $purchase_ave [] =  $avg->product_rate*$quantity[$i];
      $i++;
    }
   $sumval = array_sum($purchase_ave);

   $cusifo = $this->db->select('*')->from('customer_information')->where('customer_id',$customer_id)->get()->row();
    $headn = $cusifo->customer_name.'-'.$customer_id;
    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
    $customer_headcode = $coainfo->HeadCode;
// Cash in Hand debit
      $cc = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand For Invoice No'.$invoice_id,
      'Debit'          =>  $this->input->post('paid_amount'),
      'Credit'         =>  0,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $createby,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
 //bank transaction ledger    
 $bankc = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $bankcoaid,
      'Narration'      =>  'Paid amount for Invoice No '.$invoice_id,
      'Debit'          =>  $this->input->post('paid_amount'),
      'Credit'         =>  0,
      'IsPosted'       =>  1,
      'CreateBy'       =>  $createby,
      'CreateDate'     =>  $createdate,
      'IsAppove'       =>  1
    ); 
  $banksummary = array(
			'date'			=>	$createdate,
			'ac_type'		=>	'Debit(+)',
			'bank_id'		=>	$this->input->post('bank_id'),
			'description'	=>	'product sale',
			'deposite_id'	=>	$invoice_id,
			'dr'			=>	$this->input->post('paid_amount'),
			'cr'			=>	null,
			'ammount'		=>	$this->input->post('paid_amount'),
			'status'		=>	1
		
		);

       ///Inventory credit
       $inv_credit = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  10107,
      'Narration'      =>  'Inventory credit For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $sumval,//purchase price asbe
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$inv_credit);
       
    //Customer debit for Product Value
    $cosdr = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $customer_headcode,
      'Narration'      =>  'Customer debit For Invoice No'.$invoice_id,
      'Debit'          =>  $this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
      'Credit'         =>  0,
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$cosdr);
       //Product Sale income on acc transaction
    $pro_sale_income = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  304,
      'Narration'      =>  'Customer debit For Invoice No'.$invoice_id,
      'Debit'          =>  $this->input->post('n_total')-(!empty($this->input->post('previous'))?$this->input->post('previous'):0),
      'Credit'         =>  0,
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       $this->db->insert('acc_transaction',$pro_sale_income);

       ///Customer credit for Paid Amount 
       $cuscredit = array(
      'VNo'            =>  $invoice_id,
      'Vtype'          =>  'INVOICE',
      'VDate'          =>  $createdate,
      'COAID'          =>  $customer_headcode,
      'Narration'      =>  'Customer credit for Paid Amount For Invoice No'.$invoice_id,
      'Debit'          =>  0,
      'Credit'         =>  $this->input->post('paid_amount'),
      'IsPosted'       => 1,
      'CreateBy'       => $createby,
      'CreateDate'     => $createdate,
      'IsAppove'       => 1
    ); 
       if(!empty($this->input->post('paid_amount'))){
       $this->db->insert('acc_transaction',$cuscredit);
       	if($this->input->post('paytype') == 2){
       	$this->db->insert('acc_transaction',$bankc);
       	$this->db->insert('bank_summary',$banksummary);	
       	}
       		if($this->input->post('paytype') == 1){
       	$this->db->insert('acc_transaction',$cc);
       	}
  }


        $invoice_d_id 	= $this->input->post('invoice_details_id');
        $cartoon 		= $this->input->post('cartoon');
        $quantity 		= $this->input->post('product_quantity');
		$rate 			= $this->input->post('product_rate');
		$p_id 			= $this->input->post('product_id');
		$total_amount 	= $this->input->post('total_price');
		$discount_rate 	= $this->input->post('discount');
		$batch_id 	    = $this->input->post('batch_id');
		$tax_amount 	= $this->input->post('tax');

        $this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 
	
		for ($i=0, $n=count($p_id); $i < $n; $i++) {
			$cartoon_quantity = $cartoon[$i];
			$product_quantity = $quantity[$i];
			$product_rate 	  = $rate[$i];
			$product_id 	  = $p_id[$i];
			$total_price 	  = $total_amount[$i];
			$manufacturer_rate 	  = $this->manufacturer_rate($product_id);
			$discount 		  = $discount_rate[$i];
			$batch 			  = $batch_id[$i];
			$tax 			  = $tax_amount[$i];
			
			$data1 = array(
				'invoice_details_id'=>$this->generator(15),
				'invoice_id'	=>	$invoice_id,
				'product_id'	=>	$product_id,
				'batch_id'      =>  $batch,
				'quantity'		=>	$product_quantity,
				'rate'			=>	$product_rate,
				'discount'		=>	$discount,
				'total_price'	=>	$total_price,
				'tax'   		=>	$tax,
				'paid_amount'   =>	$this->input->post('paid_amount'),
				'due_amount'    =>	$this->input->post('due_amount'),
			);
			$this->db->insert('invoice_details',$data1);

	 	
		}
	
		return $invoice_id;
	}
	//Retrieve invoice_html_data
	public function retrieve_invoice_html_data($invoice_id)
	{
		$this->db->select('a.total_tax,
						a.*,
						b.*,
						c.*,
						d.product_id,
						d.product_name,
						d.product_details,
						d.product_model');
		$this->db->from('invoice a');
		$this->db->join('invoice_details c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->join('product_information d','d.product_id = c.product_id');
		$this->db->where('a.invoice_id',$invoice_id);
		//$this->db->where('c.quantity >',0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete invoice Item
	public function retrieve_product_data($product_id)
	{
		$this->db->select('manufacturer_price,price,manufacturer_id,tax');
		$this->db->from('product_information a');
		$this->db->join('manufacturer_product b','a.product_id=b.product.id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}
	//Retrieve company Edit Data
	public function retrieve_company()
	{
		$this->db->select('*');
		$this->db->from('company_information');
		$this->db->limit('1');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// Delete invoice Item
	public function delete_invoice($invoice_id)
	{	
		//Delete Invoice table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice'); 
		//Delete invoice_details table
		$this->db->where('invoice_id',$invoice_id);
		$this->db->delete('invoice_details'); 
		return true;
	}
	public function invoice_search_list($cat_id,$company_id)
	{
		$this->db->select('a.*,b.sub_category_name,c.category_name');
		$this->db->from('invoices a');
		$this->db->join('invoice_sub_category b','b.sub_category_id = a.sub_category_id');
		$this->db->join('invoice_category c','c.category_id = b.category_id');
		$this->db->where('a.sister_company_id',$company_id);
		$this->db->where('c.category_id',$cat_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL PURCHASE PRODUCT
	public function get_total_purchase_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_purchase');
		$this->db->from('product_purchase_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// GET TOTAL SALES PRODUCT
	public function get_total_sales_item($product_id)
	{
		$this->db->select('SUM(quantity) as total_sale');
		$this->db->from('invoice_details');
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Get total product
	public function get_total_product($product_id,$manufacturer_id){
		$this->db->select('SUM(a.quantity) as total_purchase,b.*');
		$this->db->from('product_purchase_details a');
		$this->db->join('manufacturer_product b','a.product_id=b.product_id');
		$this->db->where('a.product_id',$product_id);
		$this->db->where('b.manufacturer_id',$manufacturer_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('a.*,b.*');
		$this->db->from('product_information a');
        $this->db->join('manufacturer_product b','a.product_id=b.product_id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$this->db->where('b.manufacturer_id',$manufacturer_id);
		$product_information = $this->db->get()->row();

		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Web_settings');
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		
		$data2 = array(
			'total_product'  => $available_quantity, 
			'manufacturer_price' => $product_information->manufacturer_price, 
			'price' 	     => $product_information->price, 
			'manufacturer_id' 	 => $product_information->manufacturer_id,
			'unit' 	 		 => $product_information->unit,
			'tax' 	 		 => $product_information->tax,
			'discount_type'  => $currency_details[0]['discount_type'],
			);

		return $data2;
	}
// product information retrieve by product id
	public function get_total_product_invoic($product_id){
		$this->db->select('SUM(a.quantity) as total_purchase');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.product_id',$product_id);
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.product_id',$product_id);
		$total_sale = $this->db->get()->row();

		$this->db->select('a.*,b.*');
		$this->db->from('product_information a');
        $this->db->join('manufacturer_product b','a.product_id=b.product_id');
		$this->db->where(array('a.product_id' => $product_id,'a.status' => 1)); 
		$product_information = $this->db->get()->row();

		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);

		$CI =& get_instance();
		$CI->load->model('Web_settings');
		$CI->load->model('Products');
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $content = $CI->Products->batch_search_item($product_id);


        $html = "";
        if (empty($content)) {
        	$html .="No Product Found !";
	    }else{
	    	// Select option created for product
	        $html .="<select name=\"batch_id[]\"   class=\"batch_id_1 form-control\" id=\"batch_id_1\" required=\"required\">";
	        	$html .= "<option>".display('select_one')."</option>";
	        	foreach ($content as $product) {
	    			$html .="<option value=".$product['batch_id'].">".$product['batch_id']."</option>";
	        	}	
	        $html .="</select>";
	    }
	      $tablecolumn = $this->db->list_fields('tax_collection');
               $num_column = count($tablecolumn)-4;
  $taxfield='';
  $taxvar = [];
   for($i=0;$i<$num_column;$i++){
    $taxfield = 'tax'.$i;
    $data2[$taxfield] = $product_information->$taxfield;
    $taxvar[$i]       = $product_information->$taxfield;
    $data2['taxdta']  = $taxvar;
    //
   }

		
			$data2['total_product']      = $available_quantity; 
			$data2['manufacturer_price'] = $product_information->manufacturer_price; 
			$data2['price'] 	         = $product_information->price; 
			$data2['manufacturer_id'] 	 = $product_information->manufacturer_id;
			$data2['unit'] 	 		     = $product_information->unit;
			$data2['tax'] 	 		     = $product_information->tax;
			$data2['batch'] 	 	     = $html;
			$data2['discount_type']      = $currency_details[0]['discount_type'];
			$data2['txnmber']            = $num_column;
			

		return $data2;
	}
	//This function is used to Generate Key
	public function generator($lenth)
	{
		$number=array("1","2","3","4","5","6","7","8","9");
	
		for($i=0; $i<$lenth; $i++)
		{
			$rand_value=rand(0,8);
			$rand_number=$number["$rand_value"];
		
			if(empty($con))
			{ 
			$con=$rand_number;
			}
			else
			{
			$con="$con"."$rand_number";}
		}
		return $con;
	}
	//NUMBER GENERATOR
	public function number_generator()
	{
		$this->db->select_max('invoice', 'invoice_no');
		$query = $this->db->get('invoice');	
		$result = $query->result_array();	
		$invoice_no = $result[0]['invoice_no'];
		if ($invoice_no !='') {
			$invoice_no = $invoice_no + 1;	
		}else{
			$invoice_no = 1000;
		}
		return $invoice_no;		
	}
	// stock availavel by batch id
	public function get_total_product_batch($batch_id){

		$CI =& get_instance();
		$CI->load->model('Web_settings');

		$this->db->select('SUM(a.quantity) as total_purchase,a.expeire_date');
		$this->db->from('product_purchase_details a');
		$this->db->where('a.batch_id',$batch_id);
		$this->db->group_by('a.batch_id');
		$total_purchase = $this->db->get()->row();

		$this->db->select('SUM(b.quantity) as total_sale');
		$this->db->from('invoice_details b');
		$this->db->where('b.batch_id',$batch_id);
		$total_sale = $this->db->get()->row();
		$available_quantity = ($total_purchase->total_purchase - $total_sale->total_sale);
		
		$currency_details = $CI->Web_settings->retrieve_setting_editdata();
		
		$data2 = array(
			'total_product'  => $available_quantity,
			'expire_date' => $total_purchase->expeire_date,
			);

		return $data2;
	}
	
     public function service_invoice_taxinfo($invoice_id){
       return $this->db->select('*')   
            ->from('tax_collection')
            ->where('relation_id',$invoice_id)
            ->get()
            ->result_array(); 
    }

     public function allproduct(){
        $this->db->select('*');
        $this->db->from('product_information');
        $query = $this->db->get();
        $itemlist=$query->result();
        return $itemlist;
        }

         public function searchprod($type = null,$pname= null)
    { 
        $this->db->select('*');
        $this->db->from('product_information');
        $this->db->like('product_model',$type);
        $this->db->like('product_name',$pname);
        $query = $this->db->get();
        $itemlist=$query->result();
        return $itemlist;
    }

       public function type_dropdown()
    {
        $data = $this->db->select("*")
            ->from('product_type')
            ->get()
            ->result();

        $list[''] = 'Select '.display('type_name');
        if (!empty($data)) {
            foreach($data as $value)
                $list[$value->type_name] = $value->type_name;
            return $list;
        } else {
            return false; 
        }
    }

    	public function autocompletproductdata($product_name){
		$query=$this->db->select('*')
				->from('product_information')
				->like('product_name', $product_name, 'after')
				->order_by('product_name','asc')
				->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
}