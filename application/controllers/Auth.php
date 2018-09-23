<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form','url','download'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Auth_model');
    }
    
    
    function index(){
    	 if($this->is_login()){
    	 	 //if logedin code here
			
			if($this->session->userdata('school') == 'Shakuntala'){
				redirect('shakuntala/dashboard');
			}
			else{
				redirect('sharda/dashboard');
			}
    	 }
    	 else{
    	 	//if not logged in code here
    	 	if($this->uri->segment(1) == 'shakuntala'){
    	 		$data['title'] = 'Shakuntala Vidyalaya | Login';
    	 	}
    	 	else{
    	 		$data['title'] = 'Sharda Vidyalaya | Login';
    	 	}
    	 	$data['header'] = $this->load->view('pages/common/header',$data,true);
    	 	$data['footer'] = $this->load->view('pages/common/footer','',true);
    	 	$this->load->view('pages/login',$data);
    	 }
    }
    
    function login(){
	    	$data['uname'] = $this->input->post('uname');
	    	$data['password'] = $this->input->post('password');
	    	$result = $this->Auth_model->login($data);
	    	if(count($result)>0){
					$userdata = array(
		    			'user_id'=>$result[0]['uid'],
		    			'name' => $result[0]['name'],
		    			'uname' => $result[0]['uname'],
		    			'school_id' => $result[0]['sid'],
		    			'school' => $result[0]['s_name'],
		    			'utype' => $result[0]['u_type'],
		    			'phone' => $result[0]['contact_no'],
		    			'photo' => $result[0]['image'],
		    		);
					
		    	$this->session->set_userdata($userdata);
		    	echo json_encode(array('data'=>$result,'msg'=>'logedin','type'=>$result[0]['u_type'],'status'=>200));
	    	}
	    	else{
	    		echo json_encode(array('data'=>$result,'msg'=>'Somethink went wrong contact to useradmin.','status'=>500));
	    	}
    }
    
    function is_login(){
    	if($this->session->has_userdata('user_id')){
    		return true; 
    	}
    	else{
    		return false;
    	}
    }
    
    function logout(){
    	$this->session->sess_destroy();
    	if($this->uri->segment(1) == 'shakuntala'){
    		redirect('shakuntala/login');
    	}
    	else{
    		redirect('sharda/login');
    	}
    }
   
    function backup(){
    	$this->load->dbutil();
//     	$backup = $this->dbutil->backup();
//     	$this->load->helper('file');
//     	write_file('./backup/mybackup.zip', $backup);
    	
    	//$this->load->helper('download');
    	//force_download('mybackup.gz', $backup);
    	
    	$prefs = array(
    			'tables'        => array('class', 'medium'),   // Array of tables to backup.
    			'ignore'        => array(),                     // List of tables to omit from the backup
    			'format'        => 'txt',                       // gzip, zip, txt
    			'filename'      => 'mybackup.sql',              // File name - NEEDED ONLY WITH ZIP FILES
    			'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
    			'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
    			'newline'       => "\n"                         // Newline character used in backup file
    	);
    	
    	$this->dbutil->backup($prefs);
    }
}