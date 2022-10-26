<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Creport extends CI_Controller {
	
	function __construct() {
     	parent::__construct();
      	$CI =& get_instance();
      	$CI->load->model('Web_settings');
    }
	public function index()
    {
       $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lreport');
       
        $content = $CI->lreport->stock_report_single_item();
        
        $this->template->full_admin_html_view($content); 
    }


public function CheckList(){
        // GET data
        $this->load->model('Reports');
        $postData = $this->input->post();
        $data = $this->Reports->getCheckList($postData);
        echo json_encode($data);
    } 

        public function exportCSV(){ 
   // file name 
    $this->load->model('Reports');
    $usersData = $this->Reports->stock_csv_file();
   $filename = 'stock_'.date('Ymd').'.csv'; 
   header("Content-Description: File Transfer"); 
   header("Content-Disposition: attachment; filename=$filename"); 
   header("Content-Type: application/csv; ");
   
   // get data 
   $usersData = $this->Reports->stock_csv_file();

   // file creation 
   $file = fopen('php://output', 'w');
 
   $header = array('Product Id','Product Name','Product Model','Sell Price','Purchase Price','Total In Qty','Total Out Qty','Stock','Stock Purhcase Amount','Stock Sale Amount'); 
   fputcsv($file, $header);
   foreach ($usersData as $line){ 
     fputcsv($file,$line); 
   }
   fclose($file); 
   exit; 
  }

	
	public function out_of_stock(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');

		$content = $CI->lreport->out_of_stock();
        
		$this->template->full_admin_html_view($content);
	}
	// Date Expire Medicine list
	public function out_of_date(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');

		$content = $CI->lreport->out_of_date();
        
		$this->template->full_admin_html_view($content);
	}

	//Stock report supplir report
	public function stock_report_manufacturer_wise(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');	
		$CI->load->model('Reports');
		$today = date('Y-m-d');

		$product_id = $this->input->post('product_id')?$this->input->post('product_id'):"";	
		$manufacturer_id = $this->input->post('manufacturer_id')?$this->input->post('manufacturer_id'):"";

		$date=$this->input->post('stock_date')?$this->input->post('stock_date'):$today;
		//print_r($date);exit;

		#
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_manufacturer_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_manufacturer($manufacturer_id);	
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lreport->stock_report_manufacturer_wise($product_id,$manufacturer_id,$date,$links,$config["per_page"],$page);


		$this->template->full_admin_html_view($content);
	}
// manufacturer stock report manufacturer id wise
	public function stock_report_manufacturer_id_wise(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');	
		$CI->load->model('Reports');
		$manufacturer_id = $this->input->post('manufacturer_id');

		$date=$this->input->post('stock_date');
		//print_r($date);exit;

		#
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_manufacturer_id_wise/');
        $config["total_rows"] = $this->Reports->product_counter_by_manufacturer($manufacturer_id);	
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lreport->stock_report_manufacturer_id_wise($manufacturer_id,$date,$links,$config["per_page"],$page);
		$this->template->full_admin_html_view($content);
	}
	//Stock report supplir report
	public function stock_report_product_wise(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');	
		$CI->load->model('Reports');
		$today = date('Y-m-d');

		$product_id = $this->input->post('product_id')?$this->input->post('product_id'):"";	
		$manufacturer_id = $this->input->post('manufacturer_id')?$this->input->post('manufacturer_id'):"";
		$from_date=$this->input->post('from_date');	
		$to_date=$this->input->post('to_date')?$this->input->post('to_date'):$today;
		
		
		#
        #pagination starts
        #
        $config["base_url"] = base_url('Creport/stock_report_product_wise/');
        $config["total_rows"] = $this->Reports->stock_report_product_bydate_count($product_id,$manufacturer_id,$from_date,$to_date);	
       
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lreport->stock_report_product_wise($product_id,$manufacturer_id,$from_date,$to_date,$links,$config["per_page"],$page);
        
		$this->template->full_admin_html_view($content);
	}

	//Get product by manufacturer
	public function get_product_by_manufacturer(){
		$manufacturer_id = $this->input->post('manufacturer_id');

		$product_info_by_manufacturer = $this->db->select('a.*,b.*')
											->from('product_information a')
											->join('manufacturer_product b','a.product_id=b.product_id')
											->where('b.manufacturer_id',$manufacturer_id)
											->get()
											->result();

		if ($product_info_by_manufacturer) {
			echo "<select class=\"form-control\" id=\"manufacturer_id\" name=\"manufacturer_id\">
	                <option value=\"\">".display('select_one')."</option>";
			foreach ($product_info_by_manufacturer as $product) {
				echo "<option value='".$product->product_id."'>".$product->product_name.'-('.$product->product_model.')'." </option>";
			}
			echo " </select>";
		}

	}


	#===============Report paggination=============#
	public function pagination($per_page,$page)
	{
		$CI =& get_instance();
		$CI->load->model('Reports');
		$product_id=$this->input->post('product_id');	
		
		$config = array();
		$config["base_url"] = base_url().$page;
		$config["total_rows"] = $this->Reports->product_counter($product_id);
		$config["per_page"] = $per_page;
		$config["uri_segment"] = 4;	
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";



		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$limit = $config["per_page"];
	    return $links = $this->pagination->create_links();	
	}
	// stock report batch id wise
	public function stock_report_batch_wise(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');	
		$CI->load->model('Reports');
        $config["base_url"] = base_url('Creport/stock_report_batch_wise/');
        $config["total_rows"] = $this->Reports->stock_report_batch_count();	
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5; 
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content =$this->lreport->stock_report_batch_wise($links,$config["per_page"],$page);


		$this->template->full_admin_html_view($content);
	}

	// batch stock reoport by Medicine name
	public function product_stock_batchwise_by_name(){
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->library('lreport');
        $product_id=$this->input->post('product_id');
		$content = $CI->lreport->stock_report_batch_productname($product_id);
		$this->template->full_admin_html_view($content);
		

	} 
    
	
}