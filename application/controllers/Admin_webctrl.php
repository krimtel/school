<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_webctrl extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','download'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model(array('Admin_model','Result_model','Admin_webmodel'));
		if($this->session->userdata('user_id') == ''){
			redirect('Auth');
		}
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
	
	function index(){
		if($this->power() == 5){
			$data['power'] = $this->power();	
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
			//$data['students'] = $this->Admin_webmodel->all_student();
			$data['title'] = $this->session->userdata('school') .' | Add Teacher';
			$data['header'] = $this->load->view('pages/common/header',$data,true);
			$data['topbar'] = $this->load->view('pages/common/topbar','',true);
			$data['aside'] = $this->load->view('pages/common/aside','',true);
			$data['footer'] = $this->load->view('pages/common/footer','',true);
			$data['page'] = $this->load->view('pages/web/student_list',$data,true);
			$this->load->view('pages/index',$data);
		}
	}
	
	function bus(){
		if($this->power() == 5){
			$data['power'] = $this->power();
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
			$data['title'] = $this->session->userdata('school') .' |Bus Stoppage';
			$data['header'] = $this->load->view('pages/common/header',$data,true);
			$data['topbar'] = $this->load->view('pages/common/topbar','',true);
			$data['aside'] = $this->load->view('pages/common/aside','',true);
			$data['footer'] = $this->load->view('pages/common/footer','',true);
			$data['page'] = $this->load->view('pages/web/bus_stoppage',$data,true);
			$this->load->view('pages/index',$data);
		}
	}
	
	function stoppage_add(){
		$data['b_id'] = $this->input->post('stoppage_id');
		$data['stoppege_name'] = $this->input->post('bus_stoppage');
		$data['price'] = $this->input->post('stoppage_amount');
		$this->Admin_webmodel->add_buses_stoppages($data);
		echo json_encode(array('status'=>200));
	}
	
	function bus_list(){
		$data['stoppege_name'] = $this->input->post('sort');
		$data['direc'] = $this->input->post('direc');
		$data['buses_stoppages'] = $this->Admin_webmodel->all_buses_stoppages($data);
		if(count($data['buses_stoppages']) > 0){
			echo json_encode(array('data'=>$data['buses_stoppages'],'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function bus_delete(){
		$data['b_id'] = $this->input->post('b_id');
		$result = $this->Admin_webmodel->bus_delete($data);
		if($result){
			echo json_encode(array('status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
}