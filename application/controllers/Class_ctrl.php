<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
    
    public function class_create(){
    	$data['name'] = $this->input->post('text');
    	$data['c_id'] = $this->input->post('c_id');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d h:i:sa');
    	$data['ip'] = $this->input->ip_address();
    	 
    	$this->db->trans_begin();
    		if($data['c_id'] == ''){
    			$this->db->insert('class',$data);
    			$x = $this->db->insert_id();
    			
    			$this->db->select('*');
    			$result = $this->db->get_where('class',array('c_id'=>$x))->result_Array();
    		}
    		else{
    			$this->db->where('c_id',$data['c_id']);
    			$data1['name'] = $data['name'];
    			$this->db->update('class',$data1);
    		}
    	
    
    	if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'something went wrong.','status'=>500));
    	}
    	else{
    		$this->db->trans_commit();
    		if($data['c_id'] == ''){
    			echo json_encode(array('data'=>$result,'msg'=>'recentally add class.','status'=>200));
    		}
    		else{
    			echo json_encode(array('msg'=>'class updated.','status'=>300));
    		}
    	}
    }
    
    function class_status(){
    	$data['class_id'] = $this->input->post('cid');
    	$data1['status'] = $this->input->post('val');
    	 
    	$this->db->where('c_id',$data['class_id']);
    	$this->db->update('class',$data1);
    }
    
    function class_delete(){
    	$data['class_id'] = $this->input->post('cid');
    	 
    	$this->db->where('c_id',$data['class_id']);
    	$this->db->delete('class');
    	echo json_encode(array('msg'=>'Class Deleted Successfully.','status'=>200));
    }
    
    function Class_detail(){
    	$data['class_id'] = $this->input->post('cid');
    	
    	$result = $this->db->get_where('class',array('c_id'=>$data['class_id']))->result_array();
    	echo json_encode(array('data'=>$result,'msg'=>'Class detail.','status'=>200));
    }
    
    function section_list(){
    	$class_id = $this->input->get('c_id');
    	$u_id = $this->session->userdata('user_id');
    	//get teacher id
    	$result = $this->db->get_where('users',array('uid'=>$u_id))->result_array();
    	$teacher_id = $result[0]['t_id'];
    	//get school_id
    	$school_id = $this->session->userdata('school_id');
    	//get all section
    	$this->db->select('section as section_id');
    	$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$class_id,'teacher_id'=>$teacher_id,'status'=>1))->result_array();
    	
    	if(count($result) > 0){
    		//$sections = $result;
    		$sections = $this->db->get_where('subject_allocation',array('teacher_id'=>$teacher_id,'school_id'=>$school_id,'class_id'=>$class_id,'status'=>1))->result_array();
    	}
    	else {
	    	$this->db->select('section_id');
	    	$sections = $this->db->get_where('subject_allocation',array('teacher_id'=>$teacher_id,'school_id'=>$school_id,'class_id'=>$class_id,'status'=>1))->result_array();
    	}
    	$section_list = array();
    	foreach ($sections as $section){
    		array_push($section_list, $section['section_id']);	
    	}
    	
    	$this->db->select('id,name');
    	if($this->session->userdata('utype') != 'Admin'){
    		$this->db->where_in('id',$section_list);
    	}
    	
    	$result = $this->db->get_where('section',array('status'=>1))->result_array();
    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'msg'=>'all section list','status'=>200));
    	}
    	else{
    		echo json_encode(array('data'=>$result,'msg'=>'section not define in this class','status'=>500));
    	}
    }
    
    
    
    function section_list_class_teacher(){
    	$class_id = $this->input->get('c_id');
    	$u_id = $this->session->userdata('user_id');
    	//get teacher id
    	$result = $this->db->get_where('users',array('uid'=>$u_id))->result_array();
    	$teacher_id = $result[0]['t_id'];
    	//get school_id
    	$school_id = $this->session->userdata('school_id');
    	//get all section
    	$this->db->select('section as section_id');
    	$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$class_id,'teacher_id'=>$teacher_id,'status'=>1))->result_array();
    	
    	if(count($result) > 0){
    		$sections = $result;
    		//$sections = $this->db->get_where('subject_allocation',array('teacher_id'=>$teacher_id,'school_id'=>$school_id,'class_id'=>$class_id,'status'=>1))->result_array();
    	}
    	else {
    		$this->db->select('section_id');
    		$sections = $this->db->get_where('subject_allocation',array('teacher_id'=>$teacher_id,'school_id'=>$school_id,'class_id'=>$class_id,'status'=>1))->result_array();
    	}
    	
    	$section_list = array();
    	foreach ($sections as $section){
    		array_push($section_list, $section['section_id']);
    	}
    	 
    	$this->db->select('id,name');
    	if($this->session->userdata('utype') != 'Admin'){
    		$this->db->where_in('id',$section_list);
    	}
    	 
    	$result = $this->db->get_where('section',array('status'=>1))->result_array();
    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'msg'=>'all section list','status'=>200));
    	}
    	else{
    		echo json_encode(array('data'=>$result,'msg'=>'section not define in this class','status'=>500));
    	}
    }
    
    
    
    function class_subject(){
    	$data['c_id'] = $this->input->post('c_id');
    	$data['t_id'] = $this->input->post('t_id');
    	$data['sec_id'] = $this->input->post('sec_id');
    	$data['medium'] = $this->input->post('medium');
    	
    	$this->db->select('s.sub_id,s.name,s.subj_type');
    	$this->db->join('subject s','s.sub_id = cs.subject_id');
    	$value['result'] = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['c_id'],'cs.status'=>'1'))->result_array();

    	$this->db->select('DISTINCT(subject_id)');
    	$value['subjects'] = $this->db->get_where('subject_allocation',array('medium'=>$data['medium'],'teacher_id'=>$data['t_id'],'class_id'=>$data['c_id'],'section_id'=>$data['sec_id'][0]))->result_array();
    	
    	if(count($value['result']) > 0){
    		echo json_encode(array('data'=>$value,'msg'=>'all subjects found.','status'=>200));
    	}
    	else{
    		echo json_encode(array('msg'=>'no record found.','status'=>500));
    	}
    }
    
    function class_subject_high_class(){
    	$data['c_id'] = $this->input->post('c_id');
    	$data['t_id'] = $this->input->post('t_id');
    	$data['sec_id'] = $this->input->post('sec_id');
    	$data['medium'] = $this->input->post('medium');
    	$data['s_group'] = $this->input->post('s_group');
    	if($data['s_group'] == 'comm'){
    		$data['s_group'] = 'commer';
    	}
    	$this->db->select('s.id as sub_id,s.subject as name,s.type as subj_type');
    	$this->db->join('subjects_11_12 s','s.id = sf.sub_id');
    	$value['result'] = $this->db->get_where('subject_format_11_12 sf',array('sf.class'=>$data['c_id'],'sf.s_group'=>$data['s_group'],'sf.e_type'=>'mid','sf.status'=>'1'))->result_array();
    	
    	
    	$this->db->select('DISTINCT(subject_id)');
    	if($data['c_id']>13){
    		$this->db->where('s_group',$data['s_group']);
    	}
    	$value['subjects'] = $this->db->get_where('subject_allocation',array('medium'=>$data['medium'],'teacher_id'=>$data['t_id'],'class_id'=>$data['c_id'],'section_id'=>$data['sec_id'][0]))->result_array();
    	 
    	if(count($value['result']) > 0){
    		echo json_encode(array('data'=>$value,'msg'=>'all subjects found.','status'=>200));
    	}
    	else{
    		echo json_encode(array('msg'=>'no record found.','status'=>500));
    	}
    }
	
	function class_wise_subject_allocation(){
		$class_id = $this->input->post('c_id');
		$data['subjects'] = $this->input->post('subjects');
		if(count($data['subjects'])> 0){
			$datas = array();
			foreach($data['subjects'] as $subjs){
				$temp = array();
				$temp['class_id'] = $class_id;
				$temp['subject_id'] = $subjs;
				$temp['created_by'] = $this->session->userdata('user_id');
				$temp['created_at'] = date('Y-m-d h:i:s');
				$temp['ip'] = $this->input->ip_address();
				$temp['status'] = 1;
				$datas[] = $temp;
			}
			
			$this->db->trans_begin();
				$this->db->where('class_id',$class_id);
				$this->db->delete('class_sujects');
				
				$this->db->insert_batch('class_sujects',$datas);
				
			
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>500));
			}
			else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>200));
			}
		}
		else{
			$this->db->where('class_id',$class_id);
			$this->db->delete('class_sujects');
			echo json_encode(array('status'=>500));
		}
	}
	
// 	function class_subject_mark_check(){
// 		$data['class'] = $this->input->post('class');
// 		$data['section'] = $this->input->post('section');
// 		$data['medium'] = $this->input->post('medium');
// 		$data['school_id'] = $this->session->userdata('school_id');
// 		$data['e_type'] = 1;
// 		$u_id = $this->session->userdata('user_id');
		
// 		$this->db->select('s.*');
// 		$this->db->join('subject s','s.sub_id = cs.subject_id');
// 		$subjects = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['class'],'cs.status'=>1))->result_array();
		
// 		$subject_list = array();
// 		foreach($subjects as $subject){
// 			array_push($subject_list, $subject['subject_id']);
// 		}
		
// 		$this->db->select('*');
// 		$this->db->where_in('sub_id',$subject_list);
// 		$mark_masters = $this->db->get_where('mark_master',array('school_id' => $data['school_id'],'class_id' => $data['class'],'section' => $data['section'],'e_type'=>1))->result_array();
		
// 		$final_array = array();
// 		foreach($subjects as $subject){
// 			$temp = array();
// 			$f = 1;
// 			foreach($mark_masters as $mark_master){
// 				if($subject['sub_id'] == $mark_master['sub_id']){
// 					$temp['sub_id'] = $subject['sub_id'];
// 					$temp['sub_name'] = $subject['name'];
// 					$temp['entered'] = 1;
// 					$f = 0;
// 				}
// 			}
// 		}
// 	}
	
	function class_subject_mark_check(){
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['e_type'] = 1;
		$u_id = $this->session->userdata('user_id');
		
		$this->db->select('s.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subjects = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['class'],'cs.status'=>1))->result_array();
		
		$subject_list = array();
		foreach($subjects as $subject){
			array_push($subject_list, $subject['sub_id']);
		}
		
		$this->db->select('*');
		$this->db->where_in('sub_id',$subject_list);
		$mark_masters = $this->db->get_where('mark_master',array('school_id' => $data['school_id'],'class_id' => $data['class'],'section' => $data['section'],'e_type'=>1))->result_array();
		
		$final_array = array();
		foreach($subjects as $subject){
			$temp = array();
			$f = 1;
			foreach($mark_masters as $mark_master){
				if($subject['sub_id'] == $mark_master['sub_id']){
					$temp['sub_id'] = $subject['sub_id'];
					$temp['sub_name'] = $subject['name'];
					$temp['type'] = $subject['subj_type'];
					$temp['entered'] = 1;
					$f = 0;
					$final_array[] = $temp;
				}
			}
			if($f){
				$temp['sub_id'] = $subject['sub_id'];
				$temp['sub_name'] = $subject['name'];
				$temp['type'] = $subject['subj_type'];
				$temp['entered'] = 0;
				$final_array[] = $temp;
			}
		}
		if(count($final_array) > 0){
			echo json_encode(array('data'=>$final_array,'msg'=>'all subject marks entry check','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'no record found','status'=>500));
		}
	}
}