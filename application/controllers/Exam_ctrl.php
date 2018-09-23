<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_ctrl extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
    }
    
    function add_exam_type(){
    	$data['e_name'] = $this->input->post('e_name');
    	$data['max'] = $this->input->post('e_max');
    	$data['min'] = $this->input->post('e_min');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d h:i:s');
    	$data['ip'] = $this->input->ip_address();
    	
    	$this->db->insert('exam_type',$data);
    	$x = $this->db->insert_id();
    	
    	$this->db->select('*');
    	$result = $this->db->get_where('exam_type',array('e_id'=>$x))->result_array();
   	
    	echo json_encode(array('data'=>$result,'status'=>200));
    }
    
    function exam_delete(){
    	$data['e_id'] = $this->input->post('e_id');
    	
    	$this->db->where('e_id',$data['e_id']);
    	$this->db->update('exam_type',array('status'=>0));
    	
    	echo json_encode(array('status'=>200));
    }
    
    function exam_update(){
    	$e_id = $this->input->post('e_id');
    	$data['e_name'] = $this->input->post('e_name');
    	$data['max'] = $this->input->post('e_max');
    	$data['min'] = $this->input->post('e_min');
    	
    	$this->db->where('e_id',$e_id);
    	$this->db->update('exam_type',$data);
    	
    	echo json_encode(array('status'=>200));
    }
    
    function add_student_marks_csv(){
    	$config['upload_path'] = './csv/';
    	$config['allowed_types'] = 'csv';
    	$config['max_size'] = '10000';
    		
    	$this->upload->initialize($config);
    		
    	if (!$this->upload->do_upload()) {
    		$data['error'] = $this->upload->display_errors();
    		print_r($data['error']); die;
    	} else {
    		$file_data = $this->upload->data();
    		$file_path =  './csv/'.$file_data['file_name'];
    		if ($this->csvimport->get_array($file_path)) {
    			$csv_array = $this->csvimport->get_array($file_path);
    			$str = '';
    			
    			$bunch = array();
    			$this->db->trans_begin();
    			foreach($csv_array as $a){
    				$temp = array();
    				$temp['medium'] = $a['Medium'];
    				$temp['mm'] = $a['MM'];
    				$temp['n_marks'] = $a['Number'];
    				if($a['Class'] == 'I'){
    					$temp['class'] = 4;
    				}
    				else if($a['Class'] == 'II'){
    					$temp['class'] = 5;
    				}
    				else if($a['Class'] == 'III'){
    					$temp['class'] = 6;
    				}
    				else if($a['Class'] == 'IV'){
    					$temp['class'] = 7;
    				}
    				else if($a['Class'] == 'V'){
    					$temp['class'] = 8;
    				}
    				else if($a['Class'] == 'VI'){
    					$temp['class'] = 9;
    				}
    				else if($a['Class'] == 'VII'){
    					$temp['class'] = 10;
    				}
    				else if($a['Class'] == 'VIII'){
    					$temp['class'] = 11;
    				}
    				else if($a['Class'] == 'IX'){
    					$temp['class'] = 12;
    				}
    				else if($a['Class'] == 'X'){
    					$temp['class'] = 13;
    				}
    				else if($a['Class'] == 'XI'){
    					$temp['class'] = 14;
    				}
    				else if($a['Class'] == 'XII'){
    					$temp['class'] = 15;
    				}
    				else if($a['Class'] == 'LKG'){
    					$temp['class'] = 2;
    				}
    				else if($a['Class'] == 'UKG'){
    					$temp['class'] = 3;
    				}
    				else if($a['Class'] == 'NURSERY'){
    					$temp['class'] = 1;
    				}
    
    				if($a['Section'] == 'A'){
    					$temp['section'] = 1;
    				}
    				else if($a['Section'] == 'B'){
    					$temp['section'] = 2;
    				}
    				else if($a['Section'] == 'C'){
    					$temp['section'] = 3;
    				}
    				else if($a['Section'] == 'D'){
    					$temp['section'] = 4;
    				}
    				else if($a['Section'] == 'E'){
    					$temp['section'] = 5;
    				}
    				else if($a['Section'] == 'F'){
    					$temp['section'] = 6;
    				}
    				else if($a['Section'] == 'G'){
    					$temp['section'] = 7;
    				}
    				else if($a['Section'] == 'H'){
    					$temp['section'] = 8;
    				}
    				else if($a['Section'] == 'I'){
    					$temp['section'] = 9;
    				}
    				else if($a['Section'] == 'J'){
    					$temp['section'] = 10;
    				}
    				else if($a['Section'] == 'K'){
    					$temp['section'] = 11;
    				}
    				else if($a['Section'] == 'L'){
    					$temp['section'] = 12;
    				}
    				else if($a['Section'] == 'M'){
    					$temp['section'] = 13;
    				}
    				
    				
    				if($a['Subject'] == 'Maths'){
    					$temp['subject'] = 1;
    					$temp['s_name'] = 'Maths';
    				}
    				else if($a['Subject'] == 'Physics'){
    					$temp['subject'] = 3;
    					$temp['s_name'] = 'Physics';
    				}
    				else if($a['Subject'] == 'Chemistry'){
    					$temp['subject'] = 4;
    					$temp['s_name'] = 'Chemistry';
    				}
    				else if($a['Subject'] == 'English'){
    					$temp['subject'] = 5;
    					$temp['s_name'] = 'English';
    				}
    				else if($a['Subject'] == 'Bio'){
    					$temp['subject'] = 2;
    					$temp['s_name'] = 'Bio';
    				}
    				else if($a['Subject'] == 'Account'){
    					$temp['subject'] = 6;
    					$temp['s_name'] = 'Account';
    				}
    				else if($a['Subject'] == 'B.st'){
    					$temp['subject'] = 7;
    					$temp['s_name'] = 'B.st';
    				}
    				else if($a['Subject'] == 'Economincs'){
    					$temp['subject'] = 8;
    					$temp['s_name'] = 'Economincs';
    				}
    				else if($a['Subject'] == 'CS'){
    					$temp['subject'] = 9;
    					$temp['s_name'] = 'CS';
    				}
    				else if($a['Subject'] == 'PE'){
    					$temp['subject'] = 10;
    					$temp['s_name'] = 'PE';
    				}
    				else if($a['Subject'] == 'Maths(opt)'){
    					$temp['subject'] = 12;
    					$temp['s_name'] = 'Maths(opt)';
    				}
    				else if($a['Subject'] == 'Hindi'){
    					$temp['subject'] = 11;
    					$temp['s_name'] = 'Hindi';
    				}
    				
    			print_r($temp); die;
    				
    			if ($this->db->trans_status() === FALSE){
    				$this->db->trans_rollback();
    				echo json_encode(array('status'=>500));
    			}
    			else{
    				$this->db->trans_commit();
    				echo json_encode(array('status'=>200));
    			}
    		}
    	}
    }
    }
}