<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
  
class Excel extends CI_Controller {
	
    function __Construct(){
		parent::__Construct();
        //$this->load->model('excel_model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->helper('download');
        $this->load->library('PHPReport');     
		$this->load->database();
    }
 
    public function index(){
    //  $data = $this->excel_model->getdata();
	  $data = $this->db->get('student')->result_array();
      $template = 'Myexcel.xlsx';
      //set absolute path to directory with template files
      $templateDir = base_url(). "assest/";
	  //echo $templateDir; 
	  //die;
      //set config for report
      $config = array(
        'template' => $template,
        'templateDir' => $templateDir
      );
 
 
      //load template
      $R = new PHPReport($config);
		print_r($R); die;
      $R->load(array(
              'id' => 'student',
              'repeat' => TRUE,
              'data' => $data  
          )
      );
       
      // define output directoy 
      $output_file_dir = "./tmp/";
      
 
      $output_file_excel = $output_file_dir  . "Myexcel.xlsx";
      //download excel sheet with data in /tmp folder
      $result = $R->render('excel', $output_file_excel);
     }
}