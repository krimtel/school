<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_ctrl extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','download'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model(array('Admin_model','Result_model'));
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
	
	function db_check(){
		date_default_timezone_set('Asia/Kolkata');
		$this->load->helper(array('url','file','download'));
		$this->load->library('zip');
		
		$date = date('d_m_Y_h_i_s');
		
		$this->load->dbutil();
		$db_formate = array('format'=>'zip','file_name'=>'rahul.sql','foreign_key_checks'=>false);
		$backup = $this->dbutil->backup($db_formate);
		$this->load->helper('file');
		$path = 'backup/mybackup_'.$date.'.zip'; 
		write_file($path, $backup);
		force_download($path, $backup);
	}

	function is_class_teacher(){
		$u_id = $this->session->userdata('user_id');
		$school_id = $this->session->userdata('school_id');
		$result = $this->Admin_model->get_teacher_id($u_id);
		$t_id = $result[0]['t_id'];
		 
		$this->db->select('*');
		$result = $this->db->get_where('class_teachers',array('teacher_id'=>$t_id,'school_id'=>$school_id,'status'=>1))->result_array();
		if(count($result)>0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function entry_11_12(){
		$data['u_id'] = $this->session->userdata('user_id');
		$data['school_id'] = $this->session->userdata('school_id');
		$this->db->select('*');
		$t_id = $this->db->get_Where('users',array('uid'=>$data['u_id'],'status'=>1))->result_array();
		$t_id = $t_id[0]['t_id'];
		
		$this->db->select('*');
		$this->db->where_in('class_id',array('14,15'));
		$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'teacher_id'=>$t_id,'status'=>1))->result_array();
		if(count($result)>0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function entry_1_10(){
		$data['u_id'] = $this->session->userdata('user_id');
		$data['school_id'] = $this->session->userdata('school_id');
		$this->db->select('*');
		$t_id = $this->db->get_Where('users',array('uid'=>$data['u_id'],'status'=>1))->result_array();
		$t_id = $t_id[0]['t_id'];
		
		$this->db->select('*');
		$this->db->where_not_in('class_id',array('14,15'));
		$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'teacher_id'=>$t_id,'status'=>1))->result_array();
		if(count($result)>0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	function teacher_medium(){
		$data['u_id'] = $this->session->userdata('user_id');
		$data['school_id'] = $this->session->userdata('school_id');
		$this->db->select('*');
		$t_id = $this->db->get_Where('users',array('uid'=>$data['u_id'],'status'=>1))->result_array();
		$t_id = $t_id[0]['t_id'];
		
		$this->db->select('*');
		$this->db->limit('1');
		$result = $this->db->get_where('subject_allocation',array('teacher_id'=>$t_id,'status'=>1))->result_array();
		$teacher_medium = $result[0]['medium'];
		return $teacher_medium; 
	}

	function index(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Dashboard';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar',$data,true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['dashboard_stuff'] = $this->Admin_model->dashboard_stuff();
		$data['page'] = $this->load->view('pages/dashboard',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function session(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Session Create';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['sessions'] = $this->Admin_model->session_list();
		$data['page'] = $this->load->view('pages/master/session_create',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function student_add(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['medium'] = $this->teacher_medium();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add student';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		 
		$data['classes'] = $this->Admin_model->class_list();
		$data['page'] = $this->load->view('pages/master/add_student',$data,true);
		$this->load->view('pages/index',$data);
	}

	function profile(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['medium'] = $this->teacher_medium();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add student';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		 
		$data['classes'] = $this->Admin_model->class_list();
		$data['page'] = $this->load->view('pages/master/profile',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	
	function class_add(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add Class';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->class_list();
		$data['page'] = $this->load->view('pages/master/add_class',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function subject(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add Subject';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['subjects'] = $this->Admin_model->subjects();
		$data['page'] = $this->load->view('pages/master/add_subject',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function section(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add Subject';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		$data['page'] = $this->load->view('pages/master/add_section',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function add_teacher(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add Teacher';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['teachers'] = $this->Admin_model->teachers();
		$data['page'] = $this->load->view('pages/master/add_teacher',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function student_attendance(){
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
		$data['title'] = $this->session->userdata('school') .' | Student Attendance Entry';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->class_teacher();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/transaction/student_attendance_entry',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function marks_entry(){
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
		 
		if($this->session->userdata('utype') == 'Teacher'){
			$data['entry_11_12'] = $this->entry_11_12();
			$data['classes'] = $this->Admin_model->teacher_classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
		 
		$data['e_types'] = $this->Admin_model->e_type();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/transaction/marks_entry',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function subject_allocation_entry(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Subject Allocation Entry';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['teachers'] = $this->Admin_model->teachers();
		$data['classes'] = $this->Admin_model->classes();
		$data['page'] = $this->load->view('pages/transaction/subject_allocation_entry',$data,true);
		$this->load->view('pages/index',$data);
	}

	function mark_preview_high_class(){
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
		//$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->class_teacher();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
		$classes = array();
		foreach($data['classes'] as $class){
			if($class['c_id'] > 13){
				$classes[] = $class;
			}
		}
		$data['classes'] = $classes;
		$data['sessions'] = $this->Admin_model->sessions();
		$data['current_session'] = $this->Admin_model->current_session();
		$data['page'] = $this->load->view('pages/production/marks_preview_high_class',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	public function marks_preview(){
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
		
		$classes = array();
		foreach($data['classes'] as $class){
			if($class['c_id'] < 14){
				$classes[] = $class;
			}
		}
		$data['classes'] = $classes;
		$data['sessions'] = $this->Admin_model->sessions();
		$data['current_session'] = $this->Admin_model->current_session();
		$data['page'] = $this->load->view('pages/production/marks_preview',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function students_report(){
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
		$data['title'] = $this->session->userdata('school') .' | Students Report';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		if($this->session->userdata('utype') == 'Teacher'){
			//$data['classes'] = $this->Admin_model->teacher_classes();
			$data['classes'] = $this->Admin_model->class_teacher();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
// 		$classes = array();
// 		foreach($data['classes'] as $class){
// 			if($class['c_id'] < 14){
// 				$classes[] = $class;
// 			}
// 		}
// 		$data['classes'] = $classes;
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/report/students_report',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function upload_photo(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Upload Photo';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar',$data,true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/upload_photo','',true);
		$this->load->view('pages/index',$data);
	}


	public function download_to_excel(){
		$data['medium'] = $this->input->post('medium');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['power'] = $this->power();
		//$this->load->library('PHPReport');
		$this->load->library("PHPExcel");
		$phpExcel = new PHPExcel();
		$prestasi = $phpExcel->setActiveSheetIndex(0);
		//merger
		// 		$phpExcel->getActiveSheet()->mergeCells('A1:C1');
		//manage row hight
		$phpExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		//style alignment
		$styleArray = array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				),
		);
		// 		$phpExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// 		$phpExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArray);
		//border
		$styleArray1 = array(
				'borders' => array(
						'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						)
				)
		);
		//background
		$styleArray12 = array(
				'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'fff',
						),
				),
		);
		//freeepane
		$phpExcel->getActiveSheet()->freezePane('A3');
		//coloum width
		$phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.1);
		$phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$phpExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$prestasi->setCellValue('A1', 'student record');
		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray1);
		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray12);
		$prestasi->setCellValue('A2', 'S.No.');
		$prestasi->setCellValue('B2', 'Admission No');
		$prestasi->setCellValue('C2', 'Session');
		$prestasi->setCellValue('D2', 'Roll No');
		$prestasi->setCellValue('E2', 'Class');
		$prestasi->setCellValue('F2', 'Section');
		$prestasi->setCellValue('G2', 'Student name');
		$prestasi->setCellValue('H2', 'Father Name');
		$prestasi->setCellValue('I2', 'Mother Name');
		$prestasi->setCellValue('J2', 'DOB');
		$prestasi->setCellValue('K2', 'Gender');
		$prestasi->setCellValue('L2', 'Caste');
		$prestasi->setCellValue('M2', 'Contact No.');
		$prestasi->setCellValue('N2', 'Aadhar');
		$prestasi->setCellValue('O2', 'Address');
		$prestasi->setCellValue('P2', 'Medium');
		$prestasi->setCellValue('Q2', 'Subject Group');
		$prestasi->setCellValue('R2', 'Fit');
		$prestasi->setCellValue('S2', 'Elective');
		$prestasi->setCellValue('T2', 'House');
		$prestasi->setCellValue('U2', 'Hostler');
		$prestasi->setCellValue('V2', 'blood_group');
		$prestasi->setCellValue('W2', 'admission_date');
		$prestasi->setCellValue('X2', 'Tc');
	
		$this->db->select("s.*,DATE_FORMAT(s.admission_date, '%d-%m-%Y') admission_date,DATE_FORMAT(s.dob, '%d-%m-%Y') dob,c.name as classname,sec.name as secname");
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		$this->db->order_by('roll_no','asc');
		$data['query'] =  $this->db->get_where('student s',array('s.school_id'=>$data['school_id'],'s.class_id'=>$data['class'],'medium'=>$data['medium'],'s.section'=>$data['section'],'s.status'=>1))->result_array();
		
		$no=0;
		$rowexcel = 2;
		foreach($data['query'] as $row)
		{
			$no++;
			$rowexcel++;
			$phpExcel->getActiveSheet()->getStyle('A'.$rowexcel.':C'.$rowexcel)->applyFromArray($styleArray);
			$phpExcel->getActiveSheet()->getStyle('A'.$rowexcel.':C'.$rowexcel)->applyFromArray($styleArray1);
			$prestasi->setCellValue('A'.$rowexcel, $no);
			$prestasi->setCellValue('B'.$rowexcel, $row["admission_no"]);
			$prestasi->setCellValue('C'.$rowexcel, $row["session"]);
			$prestasi->setCellValue('D'.$rowexcel, $row["roll_no"]);
			$prestasi->setCellValue('E'.$rowexcel, $row["classname"]);
			$prestasi->setCellValue('F'.$rowexcel, $row["secname"]);
			$prestasi->setCellValue('G'.$rowexcel, $row["name"]);
			$prestasi->setCellValue('H'.$rowexcel, $row["father_name"]);
			$prestasi->setCellValue('I'.$rowexcel, $row["mother_name"]);
			$prestasi->setCellValue('J'.$rowexcel, $row["dob"]);
			$prestasi->setCellValue('K'.$rowexcel, $row["gender"]);
			$prestasi->setCellValue('L'.$rowexcel, $row["cast"]);
			$prestasi->setCellValue('M'.$rowexcel, $row["contact_no"]);
			$prestasi->setCellValue('N'.$rowexcel, $row["aadhar"]);
			$prestasi->setCellValue('O'.$rowexcel, $row["address"]);
			$prestasi->setCellValue('P'.$rowexcel, $row["medium"]);
			$prestasi->setCellValue('Q'.$rowexcel, $row["subject_group"]);
			$prestasi->setCellValue('R'.$rowexcel, $row["fit"]);
			$prestasi->setCellValue('S'.$rowexcel, $row["elective"]);
			$prestasi->setCellValue('T'.$rowexcel, $row["house"]);
			$prestasi->setCellValue('U'.$rowexcel, $row["hostler"]);
			$prestasi->setCellValue('V'.$rowexcel, $row["blood_group"]);
			$prestasi->setCellValue('W'.$rowexcel, $row["admission_date"]);
			$prestasi->setCellValue('X'.$rowexcel, $row["tc"]);
		}
		//$prestasi->setTitle('Customer Report');
	
		$date =date('U');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
		$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
		//ob_end_clean();
		if(!is_dir('./backup')){
			mkdir('./backup');
		}
		
		$filename = "backup/StudentRecord_".$data['class']."_".$data['section']."_".$date.".xlsx";
		$objWriter->save($filename);
		$result = array(
				'file_name' => $filename,
				'file_path' =>$filename
		);
		 $this->load->helper('download');
		force_download('./backup/'.$filename, NULL);
		echo json_encode(array('data'=>$result));
		//echo json_encode($result);
	}
	
	
	
	function new_window(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['s_id'] = $this->input->post('sid');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$date = date('d-m-Y');
		
		if($this->input->post('type') != ''){
		    $data['type'] = $this->input->post('type');
		    if($data['class_id'] == 12){
		        $result = $this->Result_model->student_final_result_ninth($data);
		        ///////////////////////////////new changes//////////////////////
		        $fnl_array = array();
		        $fnl_array['student'][] = $result['student'][0];
		        $marks = array();
		        $back = array();
		        $aggrigate = 0;
		        
		        foreach($result['marks'] as $mm){
		        	if($mm['sub_name'] == 'FIT'){
		        		$temp = $mm;
		        			$temp['annualsub_total'] = $mm['annual_mark'] + $mm['practical'];
		        			//$aggrigate = $aggrigate + $temp['annualsub_total'];
		        		if(ceil($temp['annualsub_total']) < 33){
		        			//$temp['annualsub_total'] = $temp['annualsub_total'].'*';
		        			//$back[] = $mm['sub_name'];
		        		}
		        		else{
		        			if($temp['extra'] > 0){
		        				$temp['stars'] = $temp['stars'];
		        			}
		        			else{
		        				$temp['stars'] = '';
		        			}
		        		}
		        		$marks[] = $temp;
		        	}
		        	else{
			        	$temp = $mm;
			        	$aggrigate = $aggrigate + $temp['annualsub_total'];
			        	if(ceil($mm['annualsub_total']) < 33){
			        		$temp['annualsub_total'] = $temp['annualsub_total'].'*';
			        		$back[] = $mm['sub_name'];
			        	}
			        	else{
			        		if($temp['extra'] > 0){
			        			$temp['stars'] = $temp['stars'];
			        		}
			        		else{
			        			$temp['stars'] = '';
			        		}
			        	}
			        	$marks[] = $temp; 
		        	}
		        }
		        
		        $fnl_array['marks'] = $marks;
		        $fnl_array['co_marks'] = $result['co_marks'];
		        $fnl_array['back'] = $back;
		        $fnl_array['aggrigate'] = round($aggrigate,2);
		        
		        if($result){
		            echo json_encode(array('data'=>$fnl_array,'status'=>200,'date'=>$date));
		        }
		        else{
		            echo json_encode(array('status'=>500));
		        }
		    }
		    else{
		      $result = $this->Result_model->student_deatil($data);
		      $result_final = $this->Result_model->student_deatil_final($data);
		      //////////////////////////////////new changes///////////////////////////////////////////////
		      $final_array = array();
		      $final_array['student'] = $result['student'];
		      foreach($result['marks'] as $mm){
		      	foreach($result_final['marks'] as $fm){
		      		$temp = array();
		      		if($mm['sub_id'] == $fm['sub_id']){
		      			$temp['sub_id'] = $mm['sub_id'];
		      			$temp['name'] = $mm['name'];
		      			if($mm['pre_mark'] != 'A'){
		      				$temp['pre_mark'] = round((($mm['pre_mark']/ 50) * 10),2);
		      			}
		      			else{
		      				$temp['pre_mark'] = 'Abst';
		      			}
		      			
		      			if($mm['mid_mark'] != 'A'){
		      				$temp['mid_mark'] = $mm['mid_mark']; 
		      			}
		      			else{
		      				$temp['mid_mark'] = 'Abst';
		      			}
		      			
		      			$temp['notebook_mark'] = $mm['notebook_mark'];
		      			$temp['subj_enrich'] = $mm['subj_enrich'];
		      			
		      			if($fm['pre_mark'] != 'A'){
		      				$temp['post_mark'] = round((($fm['pre_mark']/50) * 10),2);
		      			}
		      			else{
		      				$temp['post_mark'] = 'Abst';
		      			}
		      			
		      			if($fm['mid_mark'] != 'A'){
		      				$temp['final_mark'] = $fm['mid_mark'];
		      			}
		      			else{
		      				$temp['final_mark'] = 'Abst';
		      			}
		      			
		      			$temp['final_notebook_mark'] = $fm['notebook_mark'];
		      			$temp['final_subj_enrich'] = $fm['subj_enrich'];
		      			$temp['term_1_total'] = round(($temp['pre_mark'] + $mm['notebook_mark'] + $mm['subj_enrich'] + $temp['mid_mark']),2);
		      			$temp['term_2_total'] = round(($temp['post_mark'] + $fm['notebook_mark'] + $fm['subj_enrich'] + $temp['final_mark']),2);
		      			
		      			if(($temp['term_1_total'] + $temp['term_2_total']) < 66){
		      				$t = array();
		      				$t['sub_id'] = $mm['sub_id'];
		      				$t['name'] = $mm['name'];
		      				$final_array['back'][] = $t;
			      				$temp['term_1_total'] = $temp['term_1_total'].'*';
		      					$temp['term_2_total'] = $temp['term_2_total'].'*';
		      			}
		      			$grade = ceil($temp['term_1_total']);
		      			if($grade > 90){
		      				$temp['term_1_grade'] = 'A1';
		      			}
		      			else if($grade > 80){
		      				$temp['term_1_grade'] = 'A2';
		      			}
		      			else if($grade > 70){
		      				$temp['term_1_grade'] = 'B1';
		      			}
		      			else if($grade > 60){
		      				$temp['term_1_grade'] = 'B2';
		      			}
		      			else if($grade > 50){
		      				$temp['term_1_grade'] = 'C1';
		      			}
		      			else if($grade > 40){
		      				$temp['term_1_grade'] = 'C2';
		      			}
		      			else if($grade > 32){
		      				$temp['term_1_grade'] = 'D';
		      			}
		      			else if($grade > 0){
		      				$temp['term_1_grade'] = 'E';
		      			}
		      			else{
		      				$temp['term_1_grade'] = '-';
		      			}
		      			
		      			$grade = ceil($temp['term_2_total']);
		      			if($grade > 90){
		      				$temp['term_2_grade'] = 'A1';
		      			}
		      			else if($grade > 80){
		      				$temp['term_2_grade'] = 'A2';
		      			}
		      			else if($grade > 70){
		      				$temp['term_2_grade'] = 'B1';
		      			}
		      			else if($grade > 60){
		      				$temp['term_2_grade'] = 'B2';
		      			}
		      			else if($grade > 50){
		      				$temp['term_2_grade'] = 'C1';
		      			}
		      			else if($grade > 40){
		      				$temp['term_2_grade'] = 'C2';
		      			}
		      			else if($grade > 32){
		      				$temp['term_2_grade'] = 'D';
		      			}
		      			else if($grade > 0){
		      				$temp['term_2_grade'] = 'E';
		      			}
		      			else{
		      				$temp['term_2_grade'] = '-';
		      			}
		      			$final_array['marks'][] = $temp;
		      		}
		      	}
		      }
		      
		      foreach($result['co_marks'] as $mm){
		      	foreach($result_final['co_marks'] as $fm){
		      		$temp = array();
		      		if($mm['sub_id'] == $fm['sub_id']){
		      			$temp['sub_id'] = $mm['sub_id'];
		      			$temp['name'] = $mm['name'];
		      			$temp['term_1_mark'] = $mm['mark'];
		      			$temp['term_2_mark'] = $fm['mark'];
		      			$final_array['co_marks'][] = $temp;
		      		}
		      	}
		      }
		      
		      ////////////////////////////////////////////////////////////////////////////////////////////////////////
		      if($result){
		         //echo json_encode(array('data'=>$result,'data1'=>$result_final,'status'=>200,'date'=>$date));
		      	echo json_encode(array('data'=>$final_array,'status'=>200,'date'=>$date));
		      }
		      else{
		          echo json_encode(array('status'=>500));
		      }
		    }
		}
		else{
		    $result = $this->Result_model->student_deatil($data);
		    if($result){
		        echo json_encode(array('data'=>$result,'status'=>200,'date'=>$date));
		    }
		    else{
		        echo json_encode(array('status'=>500));
		    }
		}
	}
	
	function compart_new_window(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['s_id'] = $this->input->post('sid');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$date = date('d-m-Y');
	
			$data['type'] = $this->input->post('type');
			if($data['class_id'] == 12){
				$result = $this->Result_model->student_final_result_ninth($data);
				///////////////////////////////new changes//////////////////////
				$fnl_array = array();
				$fnl_array['student'][] = $result['student'][0];
				$marks = array();
				$back = array();
				$aggrigate = 0;
	
				foreach($result['marks'] as $mm){
					if($mm['sub_name'] == 'FIT'){
						$temp = $mm;
						$temp['annualsub_total'] = $mm['annual_mark'] + $mm['practical'];
						if(ceil($temp['annualsub_total']) < 33){
						}
						else{
							if($temp['extra'] > 0){
								$temp['stars'] = $temp['stars'];
							}
							else{
								$temp['stars'] = '';
							}
						}
						$marks[] = $temp;
					}
					else{
						$temp = $mm;
						$aggrigate = $aggrigate + $temp['annualsub_total'];
						if(ceil($mm['annualsub_total']) < 33){
							$temp['annualsub_total'] = $temp['annualsub_total'].'*';
							$back[] = $mm['sub_name'];
						}
						else{
							if($temp['extra'] > 0){
								$temp['stars'] = $temp['stars'];
							}
							else{
								$temp['stars'] = '';
							}
						}
						$marks[] = $temp;
					}
				}
	
				$fnl_array['marks'] = $marks;
				$fnl_array['co_marks'] = $result['co_marks'];
				$fnl_array['back'] = $back;
				$fnl_array['aggrigate'] = round($aggrigate,2);
	
				$this->db->select('*');
				$data1['result'] = $this->db->get_where('class_ix_compartment',array(
						'session'=>1,
						'class'=>$data['class_id'],
						'section'=>$data['section_id'],
						'medium'=>$data['medium'],
						'student_id'=>$data['s_id'],
						'school'=>$this->session->userdata('school_id')
				))->result_array();
				
				$com = array();
				$detain = 0;
				foreach($data1['result'] as $compart){
					$temp = array();
					$temp['s_name'] = $compart['s_name'];
					$temp['mm'] = $compart['mm'];
					$temp['obtain'] = $compart['n_marks'];
					if($compart['n_marks'] >= (($compart['mm']*30)/100)){
						$temp['result'] = 'PASS';
					}
					else{
						$temp['result'] = 'FAIL';
						$detain = 1;
					}
					 
					$com[] = $temp;
				}
				if($result){
					echo json_encode(array('data'=>$fnl_array,'compart'=>$com,'r_status'=>$detain,'status'=>200,'date'=>$date));
				}
				else{
					echo json_encode(array('status'=>500));
				}
			}
			else{
				$result = $this->Result_model->student_deatil($data);
				$result_final = $this->Result_model->student_deatil_final($data);
				//////////////////////////////////new changes///////////////////////////////////////////////
				$final_array = array();
				$final_array['student'] = $result['student'];
				foreach($result['marks'] as $mm){
					foreach($result_final['marks'] as $fm){
						$temp = array();
						if($mm['sub_id'] == $fm['sub_id']){
							$temp['sub_id'] = $mm['sub_id'];
							$temp['name'] = $mm['name'];
							if($mm['pre_mark'] != 'A'){
								$temp['pre_mark'] = round((($mm['pre_mark']/ 50) * 10),2);
							}
							else{
								$temp['pre_mark'] = 'Abst';
							}
							 
							if($mm['mid_mark'] != 'A'){
								$temp['mid_mark'] = $mm['mid_mark'];
							}
							else{
								$temp['mid_mark'] = 'Abst';
							}
							 
							$temp['notebook_mark'] = $mm['notebook_mark'];
							$temp['subj_enrich'] = $mm['subj_enrich'];
							 
							if($fm['pre_mark'] != 'A'){
								$temp['post_mark'] = round((($fm['pre_mark']/50) * 10),2);
							}
							else{
								$temp['post_mark'] = 'Abst';
							}
							 
							if($fm['mid_mark'] != 'A'){
								$temp['final_mark'] = $fm['mid_mark'];
							}
							else{
								$temp['final_mark'] = 'Abst';
							}
							 
							$temp['final_notebook_mark'] = $fm['notebook_mark'];
							$temp['final_subj_enrich'] = $fm['subj_enrich'];
							$temp['term_1_total'] = round(($temp['pre_mark'] + $mm['notebook_mark'] + $mm['subj_enrich'] + $temp['mid_mark']),2);
							$temp['term_2_total'] = round(($temp['post_mark'] + $fm['notebook_mark'] + $fm['subj_enrich'] + $temp['final_mark']),2);
							 
							if(($temp['term_1_total'] + $temp['term_2_total']) < 66){
								$t = array();
								$t['sub_id'] = $mm['sub_id'];
								$t['name'] = $mm['name'];
								$final_array['back'][] = $t;
								$temp['term_1_total'] = $temp['term_1_total'].'*';
								$temp['term_2_total'] = $temp['term_2_total'].'*';
							}
							$grade = ceil($temp['term_1_total']);
							if($grade > 90){
								$temp['term_1_grade'] = 'A1';
							}
							else if($grade > 80){
								$temp['term_1_grade'] = 'A2';
							}
							else if($grade > 70){
								$temp['term_1_grade'] = 'B1';
							}
							else if($grade > 60){
								$temp['term_1_grade'] = 'B2';
							}
							else if($grade > 50){
								$temp['term_1_grade'] = 'C1';
							}
							else if($grade > 40){
								$temp['term_1_grade'] = 'C2';
							}
							else if($grade > 32){
								$temp['term_1_grade'] = 'D';
							}
							else if($grade > 0){
								$temp['term_1_grade'] = 'E';
							}
							else{
								$temp['term_1_grade'] = '-';
							}
							 
							$grade = ceil($temp['term_2_total']);
							if($grade > 90){
								$temp['term_2_grade'] = 'A1';
							}
							else if($grade > 80){
								$temp['term_2_grade'] = 'A2';
							}
							else if($grade > 70){
								$temp['term_2_grade'] = 'B1';
							}
							else if($grade > 60){
								$temp['term_2_grade'] = 'B2';
							}
							else if($grade > 50){
								$temp['term_2_grade'] = 'C1';
							}
							else if($grade > 40){
								$temp['term_2_grade'] = 'C2';
							}
							else if($grade > 32){
								$temp['term_2_grade'] = 'D';
							}
							else if($grade > 0){
								$temp['term_2_grade'] = 'E';
							}
							else{
								$temp['term_2_grade'] = '-';
							}
							$final_array['marks'][] = $temp;
						}
					}
				}
			
				foreach($result['co_marks'] as $mm){
					foreach($result_final['co_marks'] as $fm){
						$temp = array();
						if($mm['sub_id'] == $fm['sub_id']){
							$temp['sub_id'] = $mm['sub_id'];
							$temp['name'] = $mm['name'];
							$temp['term_1_mark'] = $mm['mark'];
							$temp['term_2_mark'] = $fm['mark'];
							$final_array['co_marks'][] = $temp;
						}
					}
				}
				
				$this->db->select('*');
				$data1['result'] = $this->db->get_where('class_ix_compartment',array(
						'session'=>1,
						'class'=>$data['class_id'],
						'section'=>$data['section_id'],
						'medium'=>$data['medium'],
						'student_id'=>$data['s_id'],
						'school'=>$this->session->userdata('school_id')
				))->result_array();
				
				$com = array();
				$detain = 0;
				foreach($data1['result'] as $compart){
					$temp = array();
					$temp['s_name'] = $compart['s_name'];
					$temp['mm'] = $compart['mm'];
					$temp['obtain'] = $compart['n_marks'];
					if($compart['n_marks'] >= (($compart['mm']*30)/100)){
						$temp['result'] = 'PASS';
					}
					else{
						$temp['result'] = 'FAIL';
						$detain = 1;
					}
				
					$com[] = $temp;
				}
				////////////////////////////////////////////////////////////////////////////////////////////////////////
				if($result){
					echo json_encode(array('data'=>$final_array,'compart'=>$com,'r_status'=>$detain,'status'=>200,'date'=>$date));
				}
				else{
					echo json_encode(array('status'=>500));
				}
			}
	}
	
	

	function new_window_high_class() {
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['s_id'] = $this->input->post('sid');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['sgroup'] = $this->input->post('s_group');
		$data['elective'] = $this->input->post('elective');
		$date = date('d-m-Y');
		$data['medium'] = $this->input->post('medium');
		if($this->input->post('type') != ''){
		    $data['type'] = $this->input->post('type');
		}
		
		$result = $this->Result_model->student_deatil_high_class($data);
		if($result) {
			echo json_encode(array('data'=>$result,'status'=>200,'date'=>$date));
		}
		else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function new_window_high_class_final() { 
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['s_id'] = $this->input->post('sid');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['sgroup'] = $this->input->post('s_group');
		$data['elective'] = $this->input->post('elective');
		$date = date('d-m-Y');
		$data['medium'] = $this->input->post('medium');
		if($this->input->post('type') != ''){
			$data['type'] = $this->input->post('type');
		}
	
		$result = $this->Result_model->student_deatil_high_class_final($data);
		//////////////////////////////////////////////////////////////////////
		
		$fnl_array = array();
		$back = array();
		$fnl_array['student'][] = $result[0]['student'][0];
		$marks = array();
		$outoff = 0; 
		foreach($result as $r){
			foreach($r['final_marks'] as $mm){
				$temp = $mm;
				if($mm['grand_total'] < 33){
					$temp['grand_total'] = $temp['grand_total'].'*';
					$back[]['subject_name'] = $mm['subject_name'];
				}
				$marks[] = $temp;	
				$outoff = $outoff + $mm['final_thory_marks_max'];
			}
		}
		$fnl_array['back'] = $back;
		$fnl_array['outoff'] = $outoff;
		$fnl_array['final_marks'] = $marks;
		$fnl_array['total_obtail'] = $result[0]['total_obtail'];
		$fnl_array['percent'] = $result[0]['percent'];
		$fnl_array['co_marks'] = $result[0]['co_marks'];
		$result = array();
		$result[] = $fnl_array;
		if($result) {
			echo json_encode(array('data'=>$result,'status'=>200,'date'=>$date));
		}
		else {
			echo json_encode(array('status'=>500));
		}
	}
	
	
	function new_window_compart_high_class_final() {
		//$this->benchmark->mark('cat');
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['s_id'] = $this->input->post('sid');
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['sgroup'] = $this->input->post('s_group');
		$data['elective'] = $this->input->post('elective');
		$date = date('d-m-Y');
		$data['medium'] = $this->input->post('medium');
		if($this->input->post('type') != ''){
			$data['type'] = $this->input->post('type');
		}
		
		$result = $this->Result_model->student_deatil_high_class_final($data);
		//////////////////////////////////////////////////////////////////////
	
		$fnl_array = array();
		$back = array();
		$fnl_array['student'][] = $result[0]['student'][0];
		$marks = array();
		$outoff = 0;
		foreach($result as $r){
			foreach($r['final_marks'] as $mm){
				$temp = $mm;
				if($mm['grand_total'] < 33){
					$temp['grand_total'] = $temp['grand_total'].'*';
					$back[]['subject_name'] = $mm['subject_name'];
				}
				$marks[] = $temp;
				$outoff = $outoff + $mm['final_thory_marks_max'];
			}
		}
		$fnl_array['back'] = $back;
		$fnl_array['outoff'] = $outoff;
		$fnl_array['final_marks'] = $marks;
		$fnl_array['total_obtail'] = $result[0]['total_obtail'];
		$fnl_array['percent'] = $result[0]['percent'];
		$fnl_array['co_marks'] = $result[0]['co_marks'];
		$result = array();
		$result[] = $fnl_array;

		$this->db->select('*');
		$data1['result'] = $this->db->get_where('class_ix_compartment',array(
				'session'=>1,
				'class'=>$data['class_id'],
				'section'=>$data['section_id'],
				'medium'=>$data['medium'],
				'student_id'=>$data['s_id'],
				'school'=>$this->session->userdata('school_id')
		))->result_array();
		
		$com = array();
		$detain = 0;
		foreach($data1['result'] as $compart){
			$temp = array();
			$temp['s_name'] = $compart['s_name'];
			$temp['mm'] = $compart['mm'];
			$temp['obtain'] = $compart['n_marks'];
			if((int)$compart['n_marks'] >= (int)(($compart['mm']*33)/100)){
				$temp['result'] = 'PASS';
			}
			else{
				$temp['result'] = 'FAIL';
				$detain = 1;
			}
		
			$com[] = $temp;
		}
// 		$this->benchmark->mark('bird');
// 		echo $this->benchmark->elapsed_time('cat', 'bird');
// 		echo $this->benchmark->memory_usage(); die;
		if($result) {
			echo json_encode(array('data'=>$result,'compart'=>$com,'r_status'=>$detain,'status'=>200,'date'=>$date));
		}
		else {
			echo json_encode(array('status'=>500));
		}
	}
	
	function new_window_high_class_final_loop() {
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['class_id'] = $this->input->post('class_id');
		$data['section_id'] = $this->input->post('section');
		$data['sgroup'] = $this->input->post('s_group');
		$data['elective'] = $this->input->post('elective');
		$date = date('d-m-Y');
		$data['medium'] = $this->input->post('medium');
		if($this->input->post('type') != ''){
			$data['type'] = $this->input->post('type');
		}
		
		if($data['section_id'] == 1 && $data['sgroup'] == 'Maths'){
			$result1 = $this->Result_model->student_deatil_high_class_final_loop($data);
			$data['sgroup'] = 'Boilogy';
			$result2 = $this->Result_model->student_deatil_high_class_final_loop($data);
			$loop_array = array_merge($result1,$result2);
			
			$sort_list = $loop_array;
			$toppers = array();
			foreach ($sort_list as $key => $row){
				if($row['percent'] >= 33){
					$toppers[$key] = $row['total_obtail'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
			array_multisort($toppers, SORT_DESC, $sort_list);
			
			$final_sorted_array = array();
			$rank = 0;
			
			foreach ($loop_array as $la){
				foreach($sort_list as $sl){
					if($sl['student'][0]['s_id'] == $la['student'][0]['s_id']){
						if(isset($la['get_extra'])){
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
						else{
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
						//}
						$final_sorted_array[] = $la;
					}
				}
			}
			$result = $final_sorted_array;
		}
		else if($data['section_id'] == 1 && $data['sgroup'] == 'Boilogy'){
			$result1 = $this->Result_model->student_deatil_high_class_final_loop($data);
			$data['sgroup'] = 'Maths';
			$result2 = $this->Result_model->student_deatil_high_class_final_loop($data);
			$loop_array = array_merge($result1,$result2);
				
			$sort_list = $loop_array;
			$toppers = array();
			foreach ($sort_list as $key => $row){
				if($row['percent'] >= 33){
					$toppers[$key] = $row['total_obtail'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
			array_multisort($toppers, SORT_DESC, $sort_list);
				
			$final_sorted_array = array();
			$rank = 0;
				
			foreach ($loop_array as $la){
				foreach($sort_list as $sl){
					if($sl['student'][0]['s_id'] == $la['student'][0]['s_id']){
						if(isset($la['get_extra'])){
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
						else{
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
						//}
						$final_sorted_array[] = $la;
					}
				}
			}
			$result = $final_sorted_array;
		}
		else{
			$result = $this->Result_model->student_deatil_high_class_final_loop($data);
		}

		////////////////////////////////////new cganges//////////////////////////////
		$fnl_array = array();
		foreach($result as $r){
			$temp = array();
			$temp['student'][] = $r['student'][0];
			foreach($r['final_marks'] as $mm){
				$t1 = $mm;
				if(ceil($mm['grand_total']) < 33){
					$t1['grand_total'] = $t1['grand_total'].'*';
					//$t2[]['subject_name'] = $mm['subject_name'];
					$temp['back'][] = $mm['subject_name'];
				}
				$temp['final_marks'][] = $t1;
			}
			$temp['co_marks'] = $r['co_marks'];
			$temp['total_obtail'] = $r['total_obtail'];
			$temp['percent'] = round($r['percent'],2);
			$temp['outoff'] = $r['outoff'];
			$temp['rank'] = $r['rank'];
			$fnl_array[] = $temp;
		}
		//print_r($fnl_array); die;
		
		$pass_list = array();
		foreach ($fnl_array as $f){
			if(!isset($f['back'])){
				$pass_list[] = $f;
			}
		}
		
		$topper_list = $pass_list;
		$toppers = array();
		foreach ($topper_list as $key => $row){
			if(count($row['percent'])){
				$toppers[$key] = $row['percent'];
			}
			else{
				$toppers[$key] = 0;
			}
		}
		
		array_multisort($toppers, SORT_DESC, $topper_list);
		
		$result = array();
		foreach ($fnl_array as $ff){
			$temp = array();
			$f = 1;
			$pre_marks = 0;
			$c = 0;
			foreach($topper_list as $key => $value){
				if($ff['student'][0]['s_id'] == $value['student'][0]['s_id']){
					$temp = $ff;
					if($pre_marks < $value['percent']){
						$pre_marks = $value['percent'];
						$c = $key + 1;
						$temp['rank'] = $c;
					}
					else{
						$temp['rank'] = $c;
					}
					$f = 0;
					break;
				}
			}
			if($f){
				$temp = $ff;
				$temp['rank'] = '_';
			}
			$result[] = $temp; 
		}
		
		/////////////////////////////////////////////////////////////////////////////
		foreach($result as $f){
			if(isset($f['back'])){
			if(count($f['back']) < 3){
			if(isset($f['back'])){
				foreach($f['back'] as $b){
					if($b == 'Maths'){
						$sname = $b;
						$b = 1;
						$mrk = 	100;
					}
					else if($b == 'Physics'){
						$sname = $b;
						$b = 3;
						$mrk = 	70;
					}
					else if($b == 'Chemistry'){
						$sname = $b;
						$b = 4;
						$mrk = 	70;
					}
					else if($b == 'English'){
						$sname = $b;
						$b = 5;
						$mrk = 	80;
					}
					else if($b == 'Bio'){
						$sname = $b;
						$b = 2;
						$mrk = 	70;
					}
					else if($b == 'Account'){
						$sname = $b;
						$b = 6;
						$mrk = 	90;
					}
					else if($b == 'B.st'){
						$sname = $b;
						$b = 7;
						$mrk = 	90;
					}
					else if($b == 'Economincs'){
						$sname = $b;
						$b = 8;
						$mrk = 	80;
					}
					
					else if($b == 'CS'){
						$sname = $b;
						$b = 9;
						$mrk = 	70;
					}
					else if($b == 'PE'){
						$sname = $b;
						$b = 10;
						$mrk = 	70;
					}
					else if($b == 'Maths(opt)'){
						$sname = $b;
						$b = 12;
						$mrk = 	100;
					}
					else if($b == 'Hindi'){
						$sname = $b;
						$b = 11;
						$mrk = 	90;
					}
					$temp = array();
					$temp['student_id'] = $f['student'][0]['s_id'];
					$temp['subject'] = $b;
					$temp['mm'] = $mrk;
					$temp['s_name'] = $sname;
					$temp['n_marks'] = 0;
					$temp['class'] = $f['student'][0]['class_id'];
					$temp['section'] = $f['student'][0]['section'];
					$temp['session'] = $this->Admin_model->current_session();
					$temp['medium'] = $f['student'][0]['medium'];
					$temp['school'] = $f['student'][0]['school_id'];
					$temp['created_at'] = date('d-m-y h:i:s');
					$temp['created_by'] = $this->session->userdata('user_id');
					
					$this->db->select('*');
					$result1 = $this->db->get_where('class_ix_compartment',array(
							'student_id' => $f['student'][0]['s_id'],
							'subject' => $b,
							'class' => $f['student'][0]['class_id'],
							'section' => $f['student'][0]['section'],
							'medium' => $f['student'][0]['medium'],
							'school' => $f['student'][0]['school_id'],
							's_name' => $sname
					))->result_array();
					if(count($result1) > 0){
						
					}
					else{
						$this->db->insert('class_ix_compartment',$temp);
					}
				}
			}
		}
		}
		}
		if($result) {
			echo json_encode(array('data'=>$result,'status'=>200,'date'=>$date));
		}
		else {
			echo json_encode(array('status'=>500));
		}
	}

	function new_w(){
		$this->load->view('pages/production/mid_result');
	}

	function marksheet_generation(){
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
		$data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			//$data['classes'] = $this->Admin_model->teacher_classes();
			if($this->session->userdata('utype') == 'Teacher'){
				$data['classes'] = $this->Admin_model->class_teacher();
			}else{
				$data['classes'] = $this->Admin_model->classes();
			}
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/production/marksheet_generation',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	function compart_marksheet_generation(){
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
		$data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			//$data['classes'] = $this->Admin_model->teacher_classes();
			if($this->session->userdata('utype') == 'Teacher'){
				$data['classes'] = $this->Admin_model->class_teacher();
			}else{
				$data['classes'] = $this->Admin_model->classes();
			}
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/production/compart_marksheet_generation',$data,true);
		$this->load->view('pages/index',$data);
	}

	function add_user_role(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add User';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['teachers'] = $this->Admin_model->teachers();
		$data['users'] = $this->Admin_model->users();
		$data['page'] = $this->load->view('pages/master/add_user_role',$data,true);
		$this->load->view('pages/index',$data);
	}

	public function class_wise_subject_allocation(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Class Wise Subject Allocation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		$data['subjects'] = $this->Admin_model->subjects();
		$data['class_subjects'] = $this->Admin_model->class_subject();
		$data['page'] = $this->load->view('pages/master/class_wise_subject_allocation',$data,true);
		$this->load->view('pages/index',$data);
	}

	function uname_edit(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['u_id'] = $this->input->post('id');
		$data['uname'] = $this->input->post('name');

		$this->db->where('uid',$data['u_id']);
		$this->db->update('users',array('uname'=>$data['uname']));
		echo json_encode(array('status'=>200));
	}

	function upass_edit(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['u_id'] = $this->input->post('id');
		$data['password'] = $this->input->post('pass');

		$this->db->where('uid',$data['u_id']);
		$this->db->update('users',array('password'=>$data['password']));
		echo json_encode(array('status'=>200));
	}

	function user_permission(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['u_id'] = $this->input->post('id');
		$data['type'] = $this->input->post('type');
		$data['val'] = $this->input->post('val');

		$result = $this->db->get_where('users',array('t_id'=>$data['u_id']))->result_array();
		$data['u_id'] = $result[0]['uid'];
		$result = $this->db->get_where('user_permission',array('user_id'=>$data['u_id']))->result_array();

		if($data['type'] == 's_entry'){
			$x = explode(',',$result[0]['permission']);
			$temp = array();
			if($data['val'] == 0){
				$temp = $x;
				$temp = array_diff($temp, array('1'));
			} else {
				$temp = $x;
				array_push($temp, "1");
			}
		}
		else{
			$x = explode(',',$result[0]['permission']);
			$x = explode(',',$result[0]['permission']);
			$temp = array();
			if($data['val'] == 0){
				$temp = $x;
				$temp = array_diff($temp, array('2'));
			} else {
				$temp = $x;
				array_push($temp, "2");
			}
		}
		$text = implode(',',$temp);
		$this->db->where('user_id',$data['u_id']);
		$this->db->update('user_permission',array('permission'=>$text));
		echo json_encode(array('status'=>200));
	}

	function user_delete(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['user_id'] = $this->input->post('uid');

		$this->db->where('user_id',$data['user_id']);
		$this->db->delete('user_permission');
		
		echo json_encode(array('status'=>200));
	}

	function user_detail(){
		$data['t_id'] = $this->input->post('t_id');
		$user_detail = array();
		$this->db->select('*');
		$x = $this->db->get_where('users',array('t_id'=>$data['t_id'],'status'=>1))->result_array();

		$this->db->select('*');
		$result = $this->db->get_where('user_permission',array('user_id'=>$x[0]['uid']))->result_array();

		if(count($result)>0){
			$user_detail['permission'] = $result[0]['permission'];
			$this->db->select('*');
			$user = $this->db->get_where('users',array('t_id'=>$data['t_id'],'status'=>1))->result_array();
				
			$user_detail['userid'] = $user[0]['uname'];
			$user_detail['password'] = $user[0]['password'];
			echo json_encode(array('data'=>$user_detail,'status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}

	function add_exam_type(){
		$data['power'] = $this->power();
		
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Add Exam Type';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['e_types'] = $this->Admin_model->e_type();
		$data['page'] = $this->load->view('pages/master/add_exam_type',$data,true);
		$this->load->view('pages/index',$data);
	}


	function student_update(){
		$data['column'] = $this->input->post('column');
		if($data['column'] == 'dob' || $data['column'] == 'admission_date'){
			$data['value'] = date('Y-d-m',strtotime(str_replace('-', '/', $this->input->post('value'))));
     		//print_r($data['value']); die;
		}
		else{
			$data['value'] = $this->input->post('value');
		}
		$data['s_id'] = $this->input->post('s_id');
		$this->db->where('s_id',$data['s_id']);
		$this->db->update('student',array($data['column']=>$data['value']));
		echo json_encode(array('status'=>200));
	}

	function teachers_abstract(){
		$data['power'] = $this->power();
                $data['school_id'] = $this->session->userdata('school_id');
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
			$data['medium'] = $this->teacher_medium();
			
			$u_id = $this->session->userdata('user_id');
			$result = $this->Admin_model->get_teacher_id($u_id);
			$t_id = $result[0]['t_id'];
			$data['teachers'] = $this->Admin_model->teachers();
			$temp = array();
			foreach($data['teachers'] as $teacher){
				if($teacher['t_id'] == $t_id){
					$temp[] = $teacher;
					break;
				}
			}
			$data['teachers'] = $temp;
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
			$data['teachers'] = $this->Admin_model->teachers();
		}
		$data['title'] = $this->session->userdata('school') .' | Teachers Abstract';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
		$data['page'] = $this->load->view('pages/report/teachers_abstract_new',$data,true);
		$this->load->view('pages/index',$data);
	}

	function stu_del_permission_check(){
		$power = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['class'] = $this->input->post('class_id');
		$data['section'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$u_id = $this->session->userdata('user_id');
		$school_id = $this->session->userdata('school_id');

		if($power == 5){
			echo json_encode(array('status'=>200));
		}
		else{
			$result = $this->Admin_model->get_teacher_id($u_id);
				
			if(count($result)>0){
				$t_id = $result[0]['t_id'];
			}
			$this->db->select('*');
			$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$data['class'],'section'=>$data['section'],'medium'=>$data['medium'],'status'=>1,'teacher_id'=>$t_id))->result_array();
				
			if(count($result)>0){
				echo json_encode(array('status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'You dont have permission to delte the record.','status'=>500));
			}
		}
	}

	function class_teacher(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Dashboard';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar',$data,true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		$data['teachers'] = $this->Admin_model->teachers();
		$data['page'] = $this->load->view('pages/master/class_teacher',$data,true);
		$this->load->view('pages/index',$data);
	}

	function attendence_entry(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Attendances';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar',$data,true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['sessions'] = $this->Admin_model->session_list();
		$data['current_Session'] = $this->Admin_model->current_session();
		$data['session_days'] = $this->Admin_model->session_days();
		$data['page'] = $this->load->view('pages/transaction/attendance_entry',$data,true);
		$this->load->view('pages/index',$data);
	}

	function log_report(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Log Report';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar',$data,true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['users'] = $this->Admin_model->users_list();
		$data['page'] = $this->load->view('pages/report/log_report',$data,true);
		$this->load->view('pages/index',$data);
	}

	function marks_entry_high_class(){
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
			
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes_high_class();
		}else{
			$data['classes'] = $this->Admin_model->classes();
                        $classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
			
		$data['e_types'] = $this->Admin_model->e_type();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/transaction/marks_entry_high_class',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	
	function compart_marks_entry_high_class(){
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
			
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes_high_class();
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
			
		$data['e_types'] = $this->Admin_model->e_type();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/transaction/compart_marks_entry_high_class',$data,true);
		$this->load->view('pages/index',$data);
	}

	function high_class_marksheet_generation(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/production/marksheet_generation_high_class',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	
	function compart_high_class_marksheet_generation(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] > 13){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/production/compart_marksheet_generation_high_class',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	function marks_entry_check(){
		$data['power'] = $this->power();
		if($this->session->userdata('utype') == 'Teacher') {
			$data['class_teacher'] = $this->is_class_teacher();
			$data['entry_11_12'] = $this->entry_11_12();
			$data['entry_1_10'] = $this->entry_1_10();
		}
		else{
			$data['class_teacher'] = 1;
			$data['entry_11_12'] = 1;
			$data['entry_1_10'] = 1;
		}
		$data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['classes'] = $this->Admin_model->classes();
		if($this->session->userdata('utype') == 'Teacher'){
			$data['classes'] = $this->Admin_model->teacher_classes();
		}else{
			$data['classes'] = $this->Admin_model->classes();
		}
		$data['sessions'] = $this->Admin_model->sessions();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/production/marks_entry_check',$data,true);
		$this->load->view('pages/index',$data);
	}
	
	function marks_entry_check_high_class(){
	    $data['power'] = $this->power();
	    if($this->session->userdata('utype') == 'Teacher') {
	        $data['class_teacher'] = $this->is_class_teacher();
	        $data['entry_11_12'] = $this->entry_11_12();
	        $data['entry_1_10'] = $this->entry_1_10();
	    }
	    else{
	        $data['class_teacher'] = 1;
	        $data['entry_11_12'] = 1;
	        $data['entry_1_10'] = 1;
	    }
	    $data['title'] = $this->session->userdata('school') .' | Marksheet Generation';
	    $data['header'] = $this->load->view('pages/common/header',$data,true);
	    $data['topbar'] = $this->load->view('pages/common/topbar','',true);
	    $data['aside'] = $this->load->view('pages/common/aside','',true);
	    $data['footer'] = $this->load->view('pages/common/footer','',true);
	    $data['classes'] = $this->Admin_model->classes();
	    if($this->session->userdata('utype') == 'Teacher'){
	        $data['classes'] = $this->Admin_model->teacher_classes();
	    }else{
	        $data['classes'] = $this->Admin_model->classes();
	    }
	    $data['sessions'] = $this->Admin_model->sessions();
	    $data['electives'] = $this->Admin_model->elective_subjects();
	    $data['page'] = $this->load->view('pages/production/marks_entry_check_high_class',$data,true);
	    $this->load->view('pages/index',$data);
	}
	
	
	
	public function compart_marks_entry(){
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
			
		if($this->session->userdata('utype') == 'Teacher'){
			$data['entry_11_12'] = $this->entry_11_12();
			$data['classes'] = $this->Admin_model->teacher_classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}else{
			$data['classes'] = $this->Admin_model->classes();
			$classes = array();
			foreach($data['classes'] as $class){
				if($class['c_id'] < 14){
					$classes[] = $class;
				}
			}
			$data['classes'] = $classes;
		}
			
		$data['e_types'] = $this->Admin_model->e_type();
		$data['electives'] = $this->Admin_model->elective_subjects();
		$data['page'] = $this->load->view('pages/transaction/compart_marks_entry',$data,true);
		$this->load->view('pages/index',$data);
	}
}