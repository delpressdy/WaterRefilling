<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class reports extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Count report
	public function count_stock_report()
	{
		$this->db->select("a.product_name,a.product_id,a.cartoon_quantity,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',(select sum(product_purchase_details.quantity) from product_purchase_details where product_id= `a`.`product_id`) as 'totalBuyQnty'");
		$this->db->from('product_information a');
		$this->db->join('invoice_details b','b.product_id = a.product_id');
		$this->db->where(array('a.status'=>1,'b.status'=>1));
		$this->db->group_by('a.product_id');
		$query = $this->db->get();		
		return $query->num_rows();

	}
		//Out of stock
	public function out_of_stock(){

		$this->db->select('a.*, (sum(b.Purchase) - sum(b.sell)) as stock');
		$this->db->from('product_information a');
		$this->db->join('view_l_stock_history b','b.product_id = a.product_id','left',true);
		$this->db->group_by('a.product_id');
		$this->db->having('stock < 10', null, false);
		$this->db->order_by('a.product_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

		public function stock_csv_file()
	{
		$this->db->select("a.product_id,
				a.product_name,
				a.product_model,
				 a.price,
				c.manufacturer_price
				");
		$this->db->from('product_information a');
	
		$this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
		$query = $this->db->get();
		$stok_report = $query->result_array();
		
         $i = 1;
		foreach($stok_report as $k=>$v){$i++;
				$stockin = $this->db->select('sum(quantity) as totalSalesQnty')->from('invoice_details')->where('product_id',$stok_report[$k]['product_id'])->get()->row();
				$stockout = $this->db->select('sum(quantity) as totalPurchaseQnty')->from('product_purchase_details')->where('product_id',$stok_report[$k]['product_id'])->get()->row();
				
			 $stok_report[$k]['totalPurchaseQnty'] = $stockout->totalPurchaseQnty;	
			  $stok_report[$k]['totalSalesQnty'] = $stockin->totalSalesQnty;
			 $stok_report[$k]['stok_quantity_cartoon'] = ($stockout->totalPurchaseQnty-$stockin->totalSalesQnty);
			  $stok_report[$k]['purchase_total']=$stok_report[$k]['stok_quantity_cartoon']*$stok_report[$k]['manufacturer_price'];
			   
			      $stok_report[$k]['total_sale_price']=$stok_report[$k]['stok_quantity_cartoon']*$stok_report[$k]['price'];
			    
             


			}
			return $stok_report;
		
	}	

		public function count_stock_report_bydate()
	{	
		$this->db->select("a.*,
				a.product_name,
				a.product_id,
				a.product_model,
				c.manufacturer_price
				");
		$this->db->from('product_information a');
	
		$this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;
	}


	// Date Expire Medicine list
	public function out_of_date(){
         //$date=date('Y-n-j');
		$date=date('Y-m-d');
		$this->db->select('a.expeire_date as exp_date,a.*,b.*,c.*');
		$this->db->from('product_purchase_details a');
		$this->db->join('product_information c','c.product_id=a.product_id');
		$this->db->join('view_m_total_batch_stock b','b.batch_id=a.batch_id');
		$this->db->where('b.stock >',0);
		$this->db->where('a.expeire_date <=', $date);
		$this->db->group_by('b.batch_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Out of stock count
	public function out_of_stock_count(){

		$this->db->select('a.*,(sum(b.Purchase) - sum(b.sell)) as view_l_stock_history');
		$this->db->from('product_information a');
		$this->db->join('view_l_stock_history b','a.product_id = b.product_id','left');
		$this->db->having('view_l_stock_history < 10');
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.product_id','desc');
		$query = $this->db->get();

		return $query->num_rows();
	}
	// out of date count
	public function out_of_date_count(){

		  $date=date('Y-m-d');
		$this->db->select('a.*,b.*');
		$this->db->from('product_purchase_details a');
		$this->db->join('view_m_total_batch_stock b','b.batch_id=a.batch_id');
		$this->db->where('b.stock >',0);
		$this->db->where('a.expeire_date <=', $date);
		$this->db->group_by('b.batch_id');
		$query = $this->db->get();

		return $query->num_rows();
	}
	//Retrieve Single Item Stock Stock Report
	public function stock_report($limit,$page)
	{
		//$today = date('d-m-Y');
		$this->db->select("a.product_name,a.product_id,a.cartoon_quantity,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',(select sum(product_purchase_details.quantity) from product_purchase_details where product_id= `a`.`product_id`) as 'totalBuyQnty'");
		$this->db->from('product_information a');
		$this->db->join('invoice_details b','b.product_id = a.product_id');
		$this->db->where(array('a.status'=>1,'b.status'=>1));
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.product_id','desc');
		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve Single Item Stock Stock Report
	public function stock_report_single_item($product_id){
		$this->db->select("a.product_name,a.cartoon_quantity,a.price,a.product_model,sum(b.quantity) as 'totalSalesQnty',sum(c.quantity) as 'totalBuyQnty'");
		$this->db->from('product_information a');
		$this->db->join('invoice_details b','b.product_id = a.product_id');
		$this->db->join('product_purchase_details c','c.product_id = a.product_id');
		$this->db->where(array('a.product_id'=>$product_id,'a.status'=>1,'b.status'=>1));
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.product_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Stock Report by date
public function stock_report_bydate($product_id,$date,$limit,$page)
	{	
		$this->db->select("a.*,
				a.product_name,
				a.product_id,
				a.product_model,
				c.manufacturer_price
				");
		$this->db->from('product_information a');
	
		$this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
		if(empty($product_id))
		{
			$this->db->where(array('a.status'=>1));
		}
		else
		{
			//Single product information 
			$this->db->where(array('a.status'=>1,'a.product_id'=>$product_id));	
		}
		

		$this->db->limit($limit, $page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	public function totalnumberof_product(){

		$this->db->select("a.*,
				a.product_name,
				a.product_id,
				a.product_model,
				c.manufacturer_price
				");
		$this->db->from('product_information a');
	
		$this->db->join('manufacturer_product c','c.product_id = a.product_id','left');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();	
		}
		return false;

	}


	public function getCheckList($postData=null){

         $response = array();

         ## Read value
         $draw = $postData['draw'];
         $start = $postData['start'];
         $rowperpage = $postData['length']; // Rows display per page
         $columnIndex = $postData['order'][0]['column']; // Column index
         $columnName = $postData['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
         $searchValue = $postData['search']['value']; // Search value

         ## Search 
         $searchQuery = "";
         if($searchValue != ''){
            $searchQuery = " (a.product_name like '%".$searchValue."%' or a.product_model like '%".$searchValue."%' or a.price like'%".$searchValue."%' or c.manufacturer_price like'%".$searchValue."%' or m.manufacturer_name like'%".$searchValue."%') ";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('product_information a');
         $this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
         $this->db->join('manufacturer_information m','m.manufacturer_id = c.manufacturer_id','left');
          if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('product_information a');
         $this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
         $this->db->join('manufacturer_information m','m.manufacturer_id = c.manufacturer_id','left');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select("a.*,
				a.product_name,
				a.product_id,
				a.product_model,
				c.manufacturer_price,
				m.manufacturer_name
				");
         $this->db->from('product_information a');
         $this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
         $this->db->join('manufacturer_information m','m.manufacturer_id = c.manufacturer_id','left');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
        // echo $this->db->last_query();
         $data = array();
         $sl =1;
         foreach($records as $record ){
          $stockin = $this->db->select('sum(quantity) as totalSalesQnty')->from('invoice_details')->where('product_id',$record->product_id)->get()->row();
		 $stockout = $this->db->select('sum(quantity) as totalPurchaseQnty')->from('product_purchase_details')->where('product_id',$record->product_id)->get()->row();
			
               
            $data[] = array( 
            	'sl'            =>   $sl,
                'product_name' 	=> 	$record->product_name,
                'manufacturer_name'=> $record->manufacturer_name,
				'product_model' => 	$record->product_model,
				'sales_price'   =>  $record->price,
				'purchase_p'	=>	$record->manufacturer_price,
				'totalPurchaseQnty'=>$stockout->totalPurchaseQnty,
				'totalSalesQnty'=>	$stockin->totalSalesQnty,
				'stok_quantity'	=>	$stockout->totalPurchaseQnty-$stockin->totalSalesQnty,
				'total_sale_price'=> ($stockout->totalPurchaseQnty-$stockin->totalSalesQnty)*$record->price,
				'purchase_total' =>  ($stockout->totalPurchaseQnty-$stockin->totalSalesQnty)*$record->manufacturer_price,
            ); 
            $sl++;
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }
	//Stock report manufacturer by date
	public function stock_report_manufacturer_bydate($product_id=null,$manufacturer_id=null,$date=null,$perpage=null,$page=null){

		$this->db->select("*");
		$this->db->from('product_information ');
		//$this->db->group_by('product_id');
		//$this->db->order_by('a.product_id','asc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
// manufacturer stock report id wise
	public function stock_report_manufacturer_byid($manufacturer_id=null,$date=null,$perpage=null,$page=null){

		$this->db->select("*");
		$this->db->from('product_information a');
		$this->db->join('manufacturer_product c','c.product_id = a.product_id','left');
    	$this->db->where('c.manufacturer_id',$manufacturer_id);
		//$this->db->where('b.vdate <=' ,$date);
		//$this->db->group_by('a.product_id');
		//$this->db->order_by('a.product_id','asc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Counter of unique product histor which has been affected
	public function product_counter_by_manufacturer($manufacturer_id)
	{		
		$this->db->select('DISTINCT(a.product_id)');  
	    $this->db->from('product_information a');
	    $this->db->join('manufacturer_product b','b.product_id=a.product_id');
			if(!empty($manufacturer_id))
			{$this->db->where('b.manufacturer_id =',$manufacturer_id);  }
	    $query=$this->db->get(); 
	    return $query->num_rows();
	}

	//Stock report manufacturer by date
	public function stock_report_product_bydate($product_id=null,$manufacturer_id=null,$from_date=null,$to_date=null,$per_page=null,$page=null){

		$this->db->select("
				a.product_name,
				a.product_id,
				a.price,
				a.product_model,
				sum(b.sell) as 'totalSalesQnty',
				sum(b.Purchase) as 'totalPurchaseQnty',
				b.vdate as date
				");
		$this->db->from('product_information a');
		$this->db->join('view_l_stock_history b','b.product_id = a.product_id');
		

		if (empty($manufacturer_id)) {
			$this->db->where(array('a.status'=>1));
		}else{
			$this->db->where(
				array(
					'a.status'=>1,
				
					'a.product_id'	=>	$product_id
					)
				);
			$this->db->where('b.vdate >=', $from_date);
			$this->db->where('b.vdate <=', $to_date);
		}
		$this->db->group_by('b.product_id');
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Stock report manufacturer by date
	public function stock_report_product_bydate_count($product_id,$manufacturer_id,$from_date,$to_date){

		$this->db->select("
				a.product_name,
				a.product_id,
				 price,
				a.product_model,
				sum(b.sell) as 'totalSalesQnty',
				sum(b.Purchase) as 'totalPurchaseQnty',
				b.vdate as date
				");
		$this->db->from('product_information a');
		$this->db->join('view_l_stock_history b','b.product_id = a.product_id');
	
		$this->db->order_by('b.vdate', 'ASC');

		if (empty($manufacturer_id)) {
			$this->db->where(array('a.status'=>1));
		}else{
			$this->db->where(
				array(
					'a.status'=>1,
			
					'a.product_id'	=>	$product_id
					)
				);
			$this->db->where('b.vdate >=', $from_date);
			$this->db->where('b.vdate <=', $to_date);
		}
		$this->db->group_by('b.vdate');
		$query = $this->db->get();
		return $query->num_rows();
	}


	//Counter of unique product histor which has been affected
	public function product_counter($product_id)
	{		
		$this->db->select('DISTINCT(product_id)');  
	    $this->db->from('product_information');
			if(!empty($product_id))
			{$this->db->where('product_id =',$product_id);  }
	    $query=$this->db->get(); 
	    return $query->num_rows();
	}

	//Retrieve todays_total_sales_report
	public function todays_total_sales_report()
	{
		$today = date('Y-m-d');
		$this->db->select('sum(total_amount) as total_sale');
		$this->db->from('invoice');
		$this->db->where('date',$today);
		$this->db->group_by('date');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;


	}
	// total purchase info
		public function todays_total_purchase()
	{
		$today = date('Y-m-d');
		$this->db->select('sum(grand_total_amount) as total_purchase');
		$this->db->from('product_purchase');
		$this->db->where('purchase_date',$today);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}		

	// todays sales product
	public function todays_sale_product(){
		$today = date('Y-m-d');
		$this->db->select("c.product_name,c.price");
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->join('product_information c','c.product_id = b.product_id');
		$this->db->order_by('a.date','desc');
		$this->db->where('a.date',$today);
		$this->db->limit('3');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	//Retrieve todays_sales_report
	public function todays_sales_report($per_page,$page)
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('a.date',$today);
		$this->db->limit($per_page,$page);
		$this->db->order_by('a.invoice_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	

	//Retrieve todays_sales_report_count
	public function todays_sales_report_count()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('a.date',$today);
		$this->db->order_by('a.invoice_id','desc');
		$query = $this->db->get();	
		return $query->num_rows();
	}	

	//Retrieve todays_purchase_report
	public function todays_purchase_report($per_page=null,$page=null)
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.manufacturer_id,b.manufacturer_name");
		$this->db->from('product_purchase a');
		$this->db->join('manufacturer_information b','b.manufacturer_id = a.manufacturer_id');
		$this->db->where('a.purchase_date',$today);
		$this->db->order_by('a.purchase_id','desc');
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//Retrieve todays_purchase_report count
	public function todays_purchase_report_count()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.manufacturer_id,b.manufacturer_name");
		$this->db->from('product_purchase a');
		$this->db->join('manufacturer_information b','b.manufacturer_id = a.manufacturer_id');
		$this->db->where('a.purchase_date',$today);
		$this->db->order_by('a.purchase_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();	
		return $query->num_rows();
	}

	//Total profit report
	public function total_profit_report($perpage,$page){

		$this->db->select("a.date,a.invoice,b.invoice_id,
			CAST(sum(total_price) AS DECIMAL(16,2)) as total_sale");
		$this->db->select('CAST(sum(`quantity`*`manufacturer_rate`) AS DECIMAL(16,2)) as total_manufacturer_rate', FALSE);
		$this->db->select("CAST(SUM(total_price) - SUM(`quantity`*`manufacturer_rate`) AS DECIMAL(16,2)) AS total_profit");
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->group_by('b.invoice_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Total profit report
	public function total_profit_report_count(){

		$this->db->select("a.date,a.invoice,b.invoice_id,sum(total_price) as total_sale");
		$this->db->select('sum(`quantity`*`manufacturer_rate`) as total_manufacturer_rate', FALSE);
		$this->db->select("(SUM(total_price) - SUM(`quantity`*`manufacturer_rate`)) AS total_profit");
		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');
		$this->db->group_by('b.invoice_id');
		$this->db->order_by('a.invoice','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}

	//Retrieve Monthly Sales Report
// 	public function monthly_sales_report()
// 	{
// 		$query1 = $this->db->query("
// 			SELECT 
// 				date,
// 				EXTRACT(MONTH FROM STR_TO_DATE(date,'%Y-%m-%d')) as month, 
// 				COUNT(invoice_id) as total
// 			FROM 
// 				invoice
// 			WHERE 
// 				EXTRACT(YEAR FROM STR_TO_DATE(date,'%Y-%m-%d'))  >= EXTRACT(YEAR FROM NOW())
// 			GROUP BY 
// 				EXTRACT(YEAR_MONTH FROM STR_TO_DATE(date,'%Y-%m-%d'))
// 			ORDER BY
// 				month ASC
// 		")->result();

// 		$query2 = $this->db->query("
// 			SELECT 
// 				purchase_date,
// 				EXTRACT(MONTH FROM STR_TO_DATE(purchase_date,'%Y-%m-%d')) as month, 
// 				COUNT(purchase_id) as total_month
// 			FROM 
// 				product_purchase
// 			WHERE 
// 				EXTRACT(YEAR FROM STR_TO_DATE(purchase_date,'%Y-%m-%d'))  >= EXTRACT(YEAR FROM NOW())
// 			GROUP BY 
// 				EXTRACT(YEAR_MONTH FROM STR_TO_DATE(purchase_date,'%Y-%m-%d'))
// 			ORDER BY
// 				month ASC
// 		")->result();
// //print_r($query1);exit;
// 		return [$query1,$query2];
// 	}



	//Retrieve all Report
	public function retrieve_dateWise_SalesReports($start_date,$end_date)
	{
		$dateRange = "a.date BETWEEN '$start_date%' AND '$end_date%'";
		
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.date','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve all Report
	public function retrieve_dateWise_PurchaseReports($start_date,$end_date)
	{
		$dateRange = "a.purchase_date BETWEEN '$start_date%' AND '$end_date%'";
		
		$this->db->select("a.*,b.manufacturer_id,b.manufacturer_name");
		$this->db->from('product_purchase a');
		$this->db->join('manufacturer_information b','b.manufacturer_id = a.manufacturer_id');
		$this->db->where($dateRange, NULL, FALSE); 	
		$this->db->order_by('a.purchase_date','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//Retrieve date wise profit report
	public function retrieve_dateWise_profit_report($start_date,$end_date,$per_page,$page)
	{
		$this->db->select("a.date,a.invoice,b.invoice_id,
			CAST(sum(total_price) AS DECIMAL(16,2)) as total_sale");
		$this->db->select('CAST(sum(`quantity`*`manufacturer_rate`) AS DECIMAL(16,2)) as total_manufacturer_rate', FALSE);
		$this->db->select("CAST(SUM(total_price) - SUM(`quantity`*`manufacturer_rate`) AS DECIMAL(16,2)) AS total_profit");

		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');

		// $this->db->where($dateRange, NULL, FALSE); 
		$this->db->where('a.date >=', $start_date); 
		$this->db->where('a.date <=', $end_date); 

		$this->db->group_by('b.invoice_id');
		$this->db->order_by('a.invoice','desc');
		$this->db->limit($per_page,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//Retrieve date wise profit report
	public function retrieve_dateWise_profit_report_count($start_date,$end_date)
	{
		// $dateRange = "a.date BETWEEN '$start_date%' AND '$end_date%'";


		$this->db->select("a.date,a.invoice,b.invoice_id,sum(total_price) as total_sale");
		$this->db->select('sum(`quantity`*`manufacturer_rate`) as total_manufacturer_rate', FALSE);
		$this->db->select("(SUM(total_price) - SUM(`quantity`*`manufacturer_rate`)) AS total_profit");

		$this->db->from('invoice a');
		$this->db->join('invoice_details b','b.invoice_id = a.invoice_id');

		// $this->db->where($dateRange, NULL, FALSE); 
		$this->db->where('a.date >=', $start_date); 
		$this->db->where('a.date <=', $end_date); 

		$this->db->group_by('b.invoice_id');
		$this->db->order_by('a.invoice','desc');
		$query = $this->db->get();
		return $query->num_rows();
	}
	//Product wise sales report
	public function product_wise_report()
	{
		$today = date('Y-m-d');
		$this->db->select("a.*,b.customer_id,b.customer_name");
		$this->db->from('invoice a');
		$this->db->join('customer_information b','b.customer_id = a.customer_id');
		$this->db->where('a.date',$today);
		$this->db->order_by('a.invoice_id','desc');
		$this->db->limit('500');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	//RETRIEVE DATE WISE SINGE PRODUCT REPORT
	public function retrieve_product_sales_report($perpage,$page)
	{
		$this->db->select("a.*,b.product_name,b.product_model,c.date,c.total_amount,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->order_by('c.date','desc');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}	
	//RETRIEVE DATE WISE SINGE PRODUCT REPORT
	public function retrieve_product_sales_report_count()
	{
		$this->db->select("a.*,b.product_name,b.product_model,c.date,c.total_amount,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->order_by('c.date','desc');
		$query = $this->db->get();	
		return $query->num_rows();
	}
	//RETRIEVE DATE WISE SEARCH SINGLE PRODUCT REPORT
	public function retrieve_product_search_sales_report( $start_date,$end_date )
	{
		$dateRange = "c.date BETWEEN '$start_date%' AND '$end_date%'";
		$this->db->select("a.*,b.product_name,b.product_model,c.date,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 
		$this->db->order_by('c.date','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
		
		//$this->db->group_by('b.product_model');
	}	
	//RETRIEVE DATE WISE SEARCH SINGLE PRODUCT REPORT
	public function retrieve_product_search_sales_report_count( $start_date,$end_date )
	{
		$dateRange = "c.date BETWEEN '$start_date%' AND '$end_date%'";
		$this->db->select("a.*,b.product_name,b.product_model,c.date,d.customer_name");
		$this->db->from('invoice_details a');
		$this->db->join('product_information b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->join('customer_information d','d.customer_id = c.customer_id');
		$this->db->where($dateRange, NULL, FALSE); 
		$this->db->order_by('c.date','desc');
		$query = $this->db->get();	
		return $query->num_rows();
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
	//

	// stock report batch wise 

public function stock_report_batch_bydate($perpage,$page){

		
		$this->db->select("b.*,
				sum(b.sell) as 'totalSalesQnty',
				sum(b.Purchase) as 'totalPurchaseQnty',
				b.batch_id
				");
		$this->db->from('view_k_stock_batch_qty b');
		$this->db->group_by('b.batch_id');
		$this->db->group_by('b.product_id');
		$this->db->limit($perpage,$page);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	// count batch stock
	 public function stock_report_batch_count(){

		$this->db->select("b.*,
				sum(b.sell) as 'totalSalesQnty',
				sum(b.Purchase) as 'totalPurchaseQnty',
				b.batch_id
				");
		$this->db->from('view_k_stock_batch_qty b');
		$this->db->group_by('b.batch_id');
		 $query = $this->db->get();		
		return $query->num_rows();
	 }

	 public function stock_report_batch_productname($product_id){

		$this->db->select("
				a.product_name,
				a.product_id,
				a.price,
				a.product_model,
				sum(b.sell) as 'totalSalesQnty',
				sum(b.Purchase) as 'totalPurchaseQnty',
				c.expeire_date,
				b.batch_id
				");
		$this->db->from('product_information a');
		$this->db->join('product_purchase_details c','c.product_id = a.product_id');
		$this->db->join('view_k_stock_batch_qty b','b.batch_id = c.batch_id');
		$this->db->where('a.product_id',$product_id);
		$this->db->group_by('b.batch_id');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//profit report manufacturer wise purchse
	 public function profit_report_manufacturer($manufacturer_id,$from_date,$to_date){
		$this->db->select("
				AVG(a.rate) as avg_r,
				sum(a.quantity) as quantity
				");
		$this->db->from('product_purchase_details a');
		$this->db->join('manufacturer_product b','b.product_id = a.product_id');
		$this->db->join('product_purchase c','c.purchase_id = a.purchase_id');
		$this->db->where('b.manufacturer_id',$manufacturer_id);
		$this->db->where('c.purchase_date >=', $from_date); 
		$this->db->where('c.purchase_date <=', $to_date); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//profit report manufacturer wise purchse
	 public function profit_report_manufacturer_sale($manufacturer_id,$from_date,$to_date){
		$this->db->select("
				AVG(a.rate) as avg_r,
				sum(a.quantity) as quantity
				");
		$this->db->from('invoice_details a');
		$this->db->join('manufacturer_product b','b.product_id = a.product_id');
		$this->db->join('invoice c','c.invoice_id = a.invoice_id');
		$this->db->where('b.manufacturer_id',$manufacturer_id);
		$this->db->where('c.date >=', $from_date); 
		$this->db->where('c.date <=', $to_date); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//profit report manufacturer wise purchse
	 public function profit_report_productwise($product_id,$from_date,$to_date){
		$this->db->select("
				AVG(a.rate) as avg_r,
				sum(a.quantity) as quantity
				");
		$this->db->from('product_purchase_details a');
		$this->db->join('product_purchase c','c.purchase_id = a.purchase_id');
		$this->db->where('a.product_id',$product_id);
		$this->db->where('c.purchase_date >=', $from_date); 
		$this->db->where('c.purchase_date <=', $to_date); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	//profit report product wise purchse
	 public function profit_report_product_salesss($product_id,$from_date,$to_date){
		$this->db->select("
				AVG(a.rate) as avg_r,
				sum(a.quantity) as quantity
				");
		$this->db->from('invoice_details a');
		$this->db->join('invoice c','a.invoice_id = c.invoice_id');
		$this->db->where('a.product_id',$product_id);
		$this->db->where('c.date >=', $from_date); 
		$this->db->where('c.date <=', $to_date); 
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
		// chart information invoice data
public function inv_jan(){
  $month=1;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	public function inv_feb(){
  $month=2;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	public function inv_mar(){
  $month=3;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
 public function inv_apr(){
  $month=4;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
 public function inv_may(){
  $month=5;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_jun(){
  $month=6;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_jul(){
  $month=7;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_aug(){
  $month=8;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_sep(){
  $month=9;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_oct(){
  $month=10;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_nov(){
  $month=11;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function inv_dec(){
  $month=12;
  $year=date('Y');
  $this->db->select('COUNT(invoice_id) as invoice_id');
  $this->db->from('invoice');
  $this->db->where(array('MONTH(date)='=>$month,'YEAR(date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
//purchase chart data
	public function pur_jan(){
  $month=1;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	public function pur_feb(){
  $month=2;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	public function pur_mar(){
  $month=3;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
 public function pur_apr(){
  $month=4;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
 public function pur_may(){
  $month=5;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_jun(){
  $month=6;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_jul(){
  $month=7;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_aug(){
  $month=8;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_sep(){
  $month=9;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_oct(){
  $month=10;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_nov(){
  $month=11;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}
	 public function pur_dec(){
  $month=12;
  $year=date('Y');
  $this->db->select('COUNT(purchase_id) as purchase_id');
  $this->db->from('product_purchase');
  $this->db->where(array('MONTH(purchase_date)='=>$month,'YEAR(purchase_date)='=>$year));
  $query = $this->db->get()->result_array();
  return $query;

	}

}