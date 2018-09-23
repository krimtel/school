<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
		$this->load->model(array('Admin_model','Attendance_model'));
    }
    
    function add_attendance() {
    	$data['session_id'] = $this->Admin_model->current_session();
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('class');
    	$data['section_id'] = $this->input->post('section');
    	$data['term'] = $this->input->post('term');
    	$data['working_days'] = $this->input->post('working_day');
    	$data['s_record'] = $this->input->post('record');
    	$data['ip'] =  $this->input->ip_address();
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d H:i:s');
    	$result = $this->Attendance_model->add_attendance($data);
		if($result){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
    }   
	
	function attendance_check(){
		$data['session_id'] = $this->Admin_model->current_session();
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('class');
    	$data['section_id'] = $this->input->post('section');
		$data['term'] = $this->input->post('term');
		$result = $this->Attendance_model->attendance_check($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>500));
		}
		else{
			echo json_encode(array('status'=>200));
		}
	}
	
	function attendance_entry(){
		$data['session'] = $this->input->post('session');
		$data['term'] = $this->input->post('term');
		$data['days'] = $this->input->post('days');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['created_by'] = $this->session->userdata('user_id');
		$data['class_category'] = $this->input->post('class_category');
		$data['created_at'] = date('Y-m-d h:i:s');

		$result = $this->db->get_where('session_attendance',array('session'=>$data['session'],'school_id'=>$data['school_id'],'class_category'=>$data['class_category'],'term'=>$data['term'],'status'=>1))->result_Array();
		if(count($result)>0){
			$this->db->where('id',$result[0]['id']);
			$this->db->update('session_attendance',$data);
			echo json_encode(array('msg'=>'record updated','status'=>200));
		}
		else{
			$this->db->insert('session_attendance',$data);
			echo json_encode(array('msg'=>'record inserted','status'=>200));
		}
	}
	
	function session_attendance(){
		$data['term'] = $this->input->post('term');
		$data['class'] = $this->input->post('class');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['session'] = $this->Admin_model->current_session();
		
		if($data['term'] == 'Annual'){
			$data['term'] = 'Final';
		}
		
		if($data['class'] > 3 && $data['class'] < 9){
			$data['class'] = '1-5';
		}
		else if($data['class'] > 8 && $data['class'] < 13){
			$data['class'] = '6-9';
		}
		else if($data['class'] == 13){
			$data['class'] = '10th';
		}
		else if($data['class'] == 14){
			$data['class'] = '11th';
		}
		else if($data['class'] == 15){
			$data['class'] = '12th';
		}
		else{
			$data['class'] = 'primary';
		}
			
		$result = $this->db->get_where('session_attendance',array('session'=>$data['session'],'term'=>$data['term'],'class_category'=>$data['class'],'school_id'=>$data['school_id'],'status'=>1))->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function session_days(){
		$data['class_category'] = $this->input->post('c_cat');
		$data['session'] = $this->input->post('session');
		$data['term'] = $this->input->post('term');
		$data['school_id'] = $this->session->userdata('school_id');
		
		$result = $this->db->get_where('session_attendance',array('class_category'=>$data['class_category'],'session'=>$data['session'],'term'=>$data['term'],'school_id'=>$data['school_id']))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function session_detail(){
		$data['id'] = $this->input->post('id');
		$result = $this->db->get_where('session_attendance',array('id'=>$data['id'],'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'session detail.','status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function session_delete(){
		$data['id'] = $this->input->post('id');
		
		$this->db->where('id',$data['id']);
		$this->db->update('session_attendance',array('status'=>0));
		echo json_encode(array('status'=>200));
	}
}