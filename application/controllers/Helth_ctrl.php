<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helth_ctrl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation','session'));
        $this->load->database();
        $this->load->model(array('helth_model','Admin_model'));
    }
		
	function power(){
		$power = 5;		//Full Privileges ADMIN
		if($this->session->userdata('utype') == 'Teacher'){
			$u_id = $this->session->userdata('user_id');
			$result = $this->db->get_where('user_permission',array('user_id'=>$u_id))->result_array();
			$permissions =  $result[0]['permission'];
			$x = explode(',',$permissions);
			$power = 0;
			$s_entry = 0;
			$m_entry = 0;
			if(array_search("1",$x)){
				$s_entry = 1;
			}
			if(array_search("2",$x)){
				$m_entry = 2;
			}
			/*
			 0 	teacher but without any permission
			 1	teacher having only student entry permission
			 2	teacher having only marks entry permission
			 3	teacher having full permission
			 5 	Admin all perivileges
			 */
			$power = $power + $s_entry + $m_entry;
		}
		return $power;
	}	
    
    public function select_box_data(){
        $result = $this->helth_model->select_box_data();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function search_data(){
        $data['school'] = $this->session->userdata('school_id');
        $data['session'] = $this->input->post('session');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['section'] = $this->input->post('section');
        $data['sub_group'] = $this->input->post('sub_group');
        
        $result = $this->helth_model->search_data($data);
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));            
        }else{
            echo json_encode(array('status'=>500));
        }
    }
	
	function health_activity(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
			$data['medium'] = $this->teacher_medium();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Marks Preview';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->class_teacher();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
		$data['classes'] = $data['classes'];
		$data['sessions'] = $this->Admin_model->sessions();
		$data['current_session'] = $this->Admin_model->current_session();
		$data['page'] = $this->load->view('pages/helth/health_activity',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	function health_insert(){
				$data['stu_id'] = $this->input->post('stu_id');
				$data['question_1'] = $this->input->post('question_1');
				$data['question_2'] = $this->input->post('question_2');
				$data['question_3'] = $this->input->post('question_3'); 
				$data['question_4_1'] = $this->input->post('question_4_1');
				$data['question_4_2'] = $this->input->post('question_4_2');
				$data['question_5_1'] = $this->input->post('question_5_1');
				$data['question_5_2'] = $this->input->post('question_5_2');
				$data['question_6_1'] = $this->input->post('question_6_1');
				$data['question_6_2'] = $this->input->post('question_6_2');
				$data['question_7'] = $this->input->post('question_7'); 
				$data['question_8_1'] = $this->input->post('question_8_1'); 
				$data['question_8_2'] = $this->input->post('question_8_2');
				$data['question_8_3'] = $this->input->post('question_8_3'); 
				$data['question_9'] = $this->input->post('question_9');  
				$data['question_9_1'] = $this->input->post('question_9_1');
				$data['question_9_2'] = $this->input->post('question_9_2');
				$data['question_9_3'] = $this->input->post('question_9_3');
				$data['question_9_4'] = $this->input->post('question_9_4');
				$data['question_9_5'] = $this->input->post('question_9_5');
				$data['question_10_1'] = $this->input->post('question_10_1');
				$data['question_10_2'] = $this->input->post('question_10_2');
				$data['question_10_3'] = $this->input->post('question_10_3');
				$data['question_10_4'] = $this->input->post('question_10_4');
				print_r($data); die;
	}
    
}//end of class..........



