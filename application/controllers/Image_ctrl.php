<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
    
    function image_upload(){
		$data['date'] = date('Y-m-d H:i:s');
    	$data['ip'] =  $this->input->ip_address();
    	$school_id = $this->session->userdata('school_id');
    	$school = strtolower($this->session->userdata('school'));
    	
    	
    		$bulk_images = array();
    		$filesCount = count($_FILES['userFiles']['name']);
    				
    		for($i = 0; $i < $filesCount; $i++){
    			$file_name = $_FILES['userFiles']['name'][$i];
    					 
    			$file_name = preg_replace('/\s+/', '_', $file_name);
    			$_FILES['userFile']['name'] = $file_name;
    			$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
    			$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
    			$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
    			$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
    			
    			if(!is_dir('photos/students/'.$school)){
    				mkdir('photos/students/'.$school);
    			}
    			$uploadPath = 'photos/students/'.$school;
    					
    			$config['upload_path'] = $uploadPath;
    			$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPEG|PNG|JPEG';
    					
    			$this->load->library('image_lib'); 	
    			$config['overwrite'] = false;
    			$this->load->library('upload', $config);
    			$this->upload->initialize($config);
    			if(file_exists('photos/students/'.$school.'/'.$file_name)){
    				unlink('photos/students/'.$school.'/'.$file_name);
    			}
    			if($this->upload->do_upload('userFile')){
                            $x = explode('.', $file_name);
    			    $this->db->where('admission_no',$x[0]);
    			    $this->db->update('student',array('photo'=>$file_name));
    			}
    			else{
    				$error = array('error' => $this->upload->display_errors());
    				echo json_encode(array('data'=>$error,'status'=>500));
    			}
    		}
    		echo json_encode(array('msg'=>'photo uploaded','status'=>200));
    	}
}