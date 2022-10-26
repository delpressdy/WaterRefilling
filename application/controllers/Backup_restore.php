<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_restore extends CI_Controller {

    private $savePath = "assets/data/backup/";
    private $fileName = "backup.sql";

 	public function __construct()
 	{
 		parent::__construct(); 
 		
		// if (! $this->session->userdata('isAdmin') )
		// 	redirect('login');
 	}
 
	public function index()
	{ 
		$data['title']  = display('backup');
		$data['module'] = "dashboard";  
		$data['page']   = "home/backup_and_restore"; 
		$data['backup'] = $this->checkBackup();  
		$data['file']   = $this->checkFileInfo();  

		$content = $this->parser->parse('synchronizer/backup_and_restore',$data,true);
		$this->template->full_admin_html_view($content);

		//echo Modules::run('template/layout', $data); 
	}

	public function process()
	{
		$input  = $this->input->post('input'); 
		if ($input==1) {
			if ($this->backup()) {
				$data['success'] = display('backup_successfully');
			} else {
				$data['error'] = display('please_try_again');
			}
		}  
		
		if ($input==2) {
			if ($this->restore()) {
				$data['success'] = display('restore_successfully');
			} else {
				$data['error'] = display('please_try_again');
			}
		}

		echo json_encode($data);
	}


   	public function checkBackup()
 	{
 		if (file_exists($this->savePath.$this->fileName)){
 			return true;
 		} else {
 			return false;
 		}
 	}

   	public function checkFileInfo()
 	{
 		if (file_exists($this->savePath.$this->fileName)){
			$info = get_file_info($this->savePath.$this->fileName);
			return ( array(
				'name' => $info['name'],
				'size' => number_format($info['size'] / 1024, 2)." KB (".$info['size']." bytes)",
				'date' => date('d-m-Y H:i', $info['date']) . ' ('.$this->timeAgo($info['date']).')'
			));

 		} else {
 			return false;
 		}
 	}
 
    public function backup()
    { 
        $this->load->helper('file');
        $this->load->dbutil();  

		$prefs = array(
		    'format'        => 'txt',         
		    'add_drop'      => TRUE,         
		    'add_insert'    => TRUE,     
		    'newline'       => "\n"   
		); 
        $backup = $this->dbutil->backup($prefs);  
        
        if (write_file($this->savePath.$this->fileName, $backup)) {
        	return true;
        } else {
        	return false;
        }
    }

    public function restore()
    {
        $isi_file     = file_get_contents($this->savePath.$this->fileName);
        $string_query = rtrim( $isi_file, "\n;" );
        $array_query  = explode(";", $string_query);
        foreach($array_query as $query)
        {  
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->query($query);
			$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        }
        if (@unlink($this->savePath.$this->fileName)) {
        	return true;
        } else {
        	return false;
        }


    }

    public function download()
    {
    	// if (file_exists($this->savePath.$this->fileName)) {

    	// 	$this->load->helper('download');

    	// 	if (force_download($this->savePath.$this->fileName, null)) {
    	// 		$this->session->set_flashdata('message', display('download_successfully'));
    	// 	} else {
    	// 		$this->session->set_flashdata('exception', display('please_try_again'));
    	// 	}
    	// } else {
    	// 	$this->session->set_flashdata('exception', display('please_try_again'));
    	// }
    	// redirect($_SERVER['HTTP_REFERER']);
//     	$this->load->helper('download');

//         $this->load->dbutil();
//         $db_format = array('format' => 'sql', 'filename' => 'backup.sql');
//         $backup = & $this->dbutil->backup($db_format);
//         $dbname = "backup" . ".sql";
//         $save = 'assets/data/backup/' . $dbname;
// //        echo '<pre>';        print_r($backup); die();
//         write_file($save, $backup);
//         force_download($dbname, $backup);


  $db_name = 'backup' .'.sql';

   $this->load->dbutil();
  $prefs = array(
    'format' => 'sql',
    'filename' => 'backup.sql');
  $b =$this->dbutil->backup($prefs);
  $save = 'assets/data/backup/' . $db_name;
  $this->load->helper('file');
  $username = $this->db->username;
  //----- Removing Security Hash FROM CREATE VIEW Queries
  $backup=str_replace("ALGORITHM=UNDEFINED DEFINER=`".$username."`@`localhost` SQL SECURITY DEFINER", " ",$b);
  //----- Commenting INSERT queries FOR VIEWS
  
  $backup=str_replace("INSERT INTO `view_a_customer_transection_summary`", "#INSERT INTO `view_a_customer_transection_summary`",$backup);
$backup=str_replace("INSERT INTO `view_b_customer_transection`", "#INSERT INTO `view_b_customer_transection`",$backup);
$backup=str_replace("INSERT INTO `view_c_manufacturer_transection`", "#INSERT INTO `view_c_manufacturer_transection`",$backup);
$backup=str_replace("INSERT INTO `view_d_person_transection`", "#INSERT INTO `view_d_person_transection`",$backup);
$backup=str_replace("INSERT INTO `view_e_product_manufacturer`", "#INSERT INTO `view_e_product_manufacturer`",$backup);
$backup=str_replace("INSERT INTO `view_f_purchase_report`", "#INSERT INTO `view_f_purchase_report`",$backup);
$backup=str_replace("INSERT INTO `view_g_sales_abreport`", "#INSERT INTO `view_g_sales_abreport`",$backup);
$backup=str_replace("INSERT INTO `view_h_product_report`", "#INSERT INTO `view_h_product_report`",$backup);
$backup=str_replace("INSERT INTO `view_i_sales_actual`", "#INSERT INTO `view_i_sales_actual`",$backup);
  $backup=str_replace("INSERT INTO `view_j_sales_report`", "#INSERT INTO `view_j_sales_report`",$backup);
  $backup=str_replace("INSERT INTO `view_k_stock_batch_qty`", "#INSERT INTO `view_k_stock_batch_qty`",$backup);
  $backup=str_replace("INSERT INTO `view_l_stock_history`", "#INSERT INTO `view_l_stock_history`",$backup);
  $backup=str_replace("INSERT INTO `view_m_total_batch_stock`", "#INSERT INTO `view_m_total_batch_stock`",$backup);

  write_file($save, $backup);

  // $myfile = fopen($backup, "w") or die("Unable to open file!");
  // while(!feof($myfile)) {
  //   $SingleLine = fgets($myfile);
  //   $SingleLine = 
  // }
  // fclose($myfile);

  $this->load->helper('download');
  force_download($db_name, str_replace("utf8mb4_unicode_ci;", " ",$backup));
    }

    public function delete()
    {
    	if (file_exists($this->savePath.$this->fileName)) {
    		if (@unlink($this->savePath.$this->fileName)) {
    			$this->session->set_flashdata('message', display('delete_successfully'));
    		} else {
    			$this->session->set_flashdata('exception', display('please_try_again'));
    		}
    	} else {
    		$this->session->set_flashdata('exception', display('please_try_again'));
    	}
    	redirect($_SERVER['HTTP_REFERER']);
    }

	public function timeAgo($time_ago) {
		$time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
		$time  = time() - $time_ago;

		switch($time) { 
			// seconds
			case $time <= 60;
			return 'Less than a minute ago';
			// minutes
			case $time >= 60 && $time < 3600;
			return (round($time/60) == 1) ? 'a minute' : round($time/60).' minutes ago';
			// hours
			case $time >= 3600 && $time < 86400;
			return (round($time/3600) == 1) ? 'a hour ago' : round($time/3600).' hours ago';
			// days
			case $time >= 86400 && $time < 604800;
			return (round($time/86400) == 1) ? 'a day ago' : round($time/86400).' days ago';
			// weeks
			case $time >= 604800 && $time < 2600640;
			return (round($time/604800) == 1) ? 'a week ago' : round($time/604800).' weeks ago';
			// months
			case $time >= 2600640 && $time < 31207680;
			return (round($time/2600640) == 1) ? 'a month ago' : round($time/2600640).' months ago';
			// years
			case $time >= 31207680;
			return (round($time/31207680) == 1) ? 'a year ago' : round($time/31207680).' years ago' ;
		}
	}

// import form
      public function import_form(){
    $data['title'] = display('db_import');
    $content = $this->parser->parse('synchronizer/import', $data, true);
    $this->template->full_admin_html_view($content); 
  }
  // import database
  public function importdata() {
    $hostname = $this->db->hostname;
    $username = $this->db->username;
    $password = $this->db->password;
    $database = $this->db->database;

     @$mysqli = new \mysqli(
            $hostname,
            $username,
            $password,
            $database
        );

        // Check for errors
        if (mysqli_connect_errno()){
            echo 'fail to connect';
            return false;
       }
        
           
            if ($_FILES['image']['name']) {
            $config['upload_path'] = './assets/dbimport/';
            $config['allowed_types'] = 'sql';
            $config['max_size'] = "*";
            $config['max_width'] = "*";
            $config['max_height'] = "*";
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Backup_restore/import_form'));
            } else {
                $file = $this->upload->data();
                $file_url = base_url() . "assets/dbimport/" . $file['file_name'];
            }
        }

$sql1="drop view if exists view_a_customer_transection_summary";
$this->db->query($sql1); 
$sql2="drop view if exists view_k_stock_batch_qty"; 
$this->db->query($sql2);
$sql3="drop view if exists view_l_stock_history"; 
$this->db->query($sql3);
$sql4="drop view if exists view_m_total_batch_stock"; 
$this->db->query($sql4);
       $tables = $this->db->list_tables();
foreach ($tables as $table)
{
    if($table != 'customer_transection_summary')
   $this->db->truncate($table);
}
    $templine = '';
    // Read in entire file
    $lines = file($file_url);
    foreach($lines as $line) {
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current templine we are creating
        $templine.=$line;

        // If it has a semicolon at the end, it's the end of the query so can process this templine
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            $this->db->query($templine);
            // Reset temp variable to empty
            $templine = '';
        }
    }
 $this->session->set_userdata(array('message' => 'Successfully Imported '));
redirect($_SERVER['HTTP_REFERER']);
    }
}
