<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry_cc extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
		$this->load->model(array('Admin_model','Result_model','Student_model'));
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
    public function index(){
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
        $data['title'] = $this->session->userdata('school') .' | Marks Entry';
        $data['header'] = $this->load->view('pages/common/header',$data,true);
        $data['topbar'] = $this->load->view('pages/common/topbar','',true);
        $data['aside'] = $this->load->view('pages/common/aside','',true);
        $data['footer'] = $this->load->view('pages/common/footer','',true);        
        
		
		$this->load->model('student_model_cc','std_model');	
		$data['medium_list']=$this->std_model->medium_list();
        $data['exam_type_list']=$this->std_model->exam_type_list();
        $data['class_list']=$this->std_model->class_list();
        $data['section_list']=$this->std_model->section_list();
		
    $data['page'] = $this->load->view('pages/transaction/marks_entry_cc',$data,true);
    $this->load->view('pages/index',$data);
    }

	public function select_box(){
		$class_id=$this->input->post('class_id');
		$medium_id=$this->input->post('medium_id');
		
		$this->load->model('student_model_cc','std_model');	
		$data['subject_list']=$this->std_model->subject_list($class_id, $medium_id);
		
		$data['page'] = $this->load->view('pages/transaction/marks_entry_cc',$data,true);
		echo json_encode(array('data'=>$data['subject_list']));
		}


    public function search_list(){
    	$session_id= (int)$this->Admin_model->current_session();
		$school_id= (int)$this->session->userdata('school_id');
    	$medium=(int)$this->input->post('medium');
    	$e_type=(int)$this->input->post('e_type');
    	$class=(int)$this->input->post('class');
    	$section=(int)$this->input->post('section');
    	$subject=(int)$this->input->post('subject');
		
	    $this->db->select('*');
		$this->db->from('cc_exam_type');
		$this->db->where('exam_type_id', $e_type);
		$result=$this->db->get()->result_array();
    	$e_type_name=$result[0]['et_name'];
		
		$this->db->select('*');
		$this->db->from('cc_subject');
		$this->db->where('sub_id', $subject);
		$result=$this->db->get()->result_array();
    	$sub_type=$result[0]['sub_type'];
		
		$this->db->select('*');
		$this->db->from('class');
		$this->db->where('c_id', $class);
		$result=$this->db->get()->result_array();
    	$class_name=$result[0]['name'];
		//print_r($class_name); die;
		
		
		$max='';
		
	if(($e_type_name == 'FA1' || $e_type_name =='FA2' || $e_type_name =='FA3' || $e_type_name =='FA4') && ($sub_type=='1')){
				$max="20";
		}elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='NURSERY' || $class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V '))
		{
			$max="3";
			}
		elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
		{
			$max="5";
			
		}	
		
		elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='1')){
			$max="80";
			}
			
		elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='2') && ($class_name=='NURSERY') || ($class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V ')){
				$max="3";
			}
		
		elseif(($e_type_name=='SA1' || $e_type_name=='SA2')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
		{
			$max="5";
			
			}
			
				
    	$this->load->model('student_model_cc','std_model');
    	$result = $this->std_model->search_list($session_id, $school_id, $medium, $e_type, $class, $section, $subject);
    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'max'=>$max,'msg'=>'student records','status'=>200));
    	}else{
				echo json_encode(array('msg'=>'No record found..','status'=>500));
			}
}


	public function marks_entry(){
		//print_r($this->input->post()); die;
		$session_id= (int)$this->Admin_model->current_session(); 
		$school_id= (int)$this->session->userdata('school_id');
		$medium=(int)$this->input->post('medium');
    	$e_type=(int)$this->input->post('e_type');
    	$class=(int)$this->input->post('class');
    	$section=(int)$this->input->post('section');
    	$subject=(int)$this->input->post('subject');
 		$created_by = $this->session->userdata('user_id');
		$created_at = date('Y-m-d H:i:s');
		$marks=$this->input->post('marks');
		

		$this->db->select('*');
		$this->db->from('cc_exam_type');
		$this->db->where('exam_type_id', $subject);
		$result=$this->db->get()->result_array();
    	$max_mark=$result[0]['max_marks'];
		$con_mark=$result[0]['con_marks'];
		
		
		$this->db->select('*');
		$this->db->from('cc_mark_master');
		$this->db->where('session_id', $session_id);
		$this->db->where('school_id', $school_id);
		$this->db->where('class_id', $class);
		$this->db->where('section_id', $section);
		$this->db->where('medium', $medium);
		$this->db->where('exam_type', $e_type);
		$this->db->where('subject_id', $subject);
		$this->db->where('status', 1);
		$result=$this->db->get()->result_array();
		if($this->db->affected_rows() > 0){
				$status = 1;
				$marks_master_id=$result[0]['id'];
		}
		else{
				$status= 0;
				$marks_master_id= 0;
			}
		
		
    	$std_marks = array();
    	foreach($marks as $mark){
    		$temp=$mark;
    		$temp['con_marks']=($mark['val'] * $con_mark) / $max_mark;
    		$temp['session_id']=$session_id;
    		$temp['school_id']=$school_id;
    		$temp['medium']=$medium;
    		$temp['e_type']=$e_type;
    		$temp['class']=$class;
    		$temp['section']=$section;
    		$temp['subject']=$subject;
			$temp['student_id'] = $mark['s_id'];
			$temp['created_by']=$created_by;
			$temp['created_at']=$created_at;
			$temp['status']=$status;
			$temp['m_tbl_id']=$marks_master_id;
			
    		$std_marks[]=$temp;
    	}

		//print_r($marks_master_id); die;
		
    	//print_r($std_marks); die;
    	$this->load->model('student_model_cc','std_model');
    	$result = $this->std_model->marks_entry($std_marks);
		if($result){
			echo json_encode(array('status'=>200));	
			}else{
			echo json_encode(array('status'=>500));
				}
		
	}
}


