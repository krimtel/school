<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Svr_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	
	public function login(){
		$data['title'] = 'Login';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		//$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		//$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$this->load->view('pages/login',$data);
		//$this->load->view('pages/index',$data);
	}
	
	public function index(){
		$data['title'] = 'Dashboard';
		$data['header'] = $this->load->view('pages/common/header',$data,true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/dashboard','',true);
		$this->load->view('pages/index',$data);
	}
	/*master records*/
	public function session_create(){
		$data['title'] = 'Session Create';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/session_create','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function add_student(){
		$data['title'] = 'Add student';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_student','',true);
		$this->load->view('pages/index',$data);
	}

	public function add_teacher(){
		$data['title'] = 'Add Teacher';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_teacher','',true);
		$this->load->view('pages/index',$data);
	}
	public function add_subject(){
		$data['title'] = 'Add Subject';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_subject','',true);
		$this->load->view('pages/index',$data);
	}
	public function add_exam(){
		$data['title'] = 'Add Exam';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_exam','',true);
		$this->load->view('pages/index',$data);
	}
	public function add_exam_type(){
		$data['title'] = 'Add Exam Type';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_exam_type','',true);
		$this->load->view('pages/index',$data);
	}
	public function add_class(){
		$data['title'] = 'Add Class';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_class','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function add_section(){
		$data['title'] = 'Add Section';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_section','',true);
		$this->load->view('pages/index',$data);
	}
	public function add_user_role(){
		$data['title'] = 'Add User Role';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/add_user_role','',true);
		$this->load->view('pages/index',$data);
	}
	public function school_details(){
		$data['title'] = 'School Details';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/school_details','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function class_wise_subject_allocation(){
		$data['title'] = 'Class Wise Subject Allocation';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/master/class_wise_subject_allocation','',true);
		$this->load->view('pages/index',$data);
	}
	
	/*TRANSACTION RECORDS Section*/
	
	public function student_attendance_entry(){
		$data['title'] = 'Student Attendance Entry';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/transaction/student_attendance_entry','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function marks_entry(){
		$data['title'] = 'Marks Entry';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/transaction/marks_entry','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function subject_allocation_entry(){
		$data['title'] = 'Subject Allocation Entry';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/transaction/subject_allocation_entry','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function compartment_marks_entry(){
		$data['title'] = 'Compartment Marks Entry';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/transaction/compartment_marks_entry','',true);
		$this->load->view('pages/index',$data);
	}
	public function class_upgradation(){
		$data['title'] = 'Class Upgradation';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/transaction/class_upgradation','',true);
		$this->load->view('pages/index',$data);
	}
	
	/*production section*/
	public function marks_preview(){
		$data['title'] = 'Marks Preview';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/production/marks_preview','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function marksheet_generation(){
		$data['title'] = 'Marksheet Generation';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/production/marksheet_generation','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function compartment_marks_report(){
		$data['title'] = 'Compartment Marksheet Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/production/compartment_marks_report','',true);
		$this->load->view('pages/index',$data);
	}
	
	
	public function class_wise_marks_report(){
		$data['title'] = 'Class Wise Marks Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/production/class_wise_marks_report','',true);
		$this->load->view('pages/index',$data);
	}
	/*Report Section*/
	public function students_report(){
		$data['title'] = 'Students Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/report/students_report','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function teachers_report(){
		$data['title'] = 'Teachers Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/report/teachers_report','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function teachers_abstract(){
		$data['title'] = 'Teachers Abstract';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/report/teachers_abstract','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function subject_allocation_report(){
		$data['title'] = 'Subject Allocation Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/report/subject_allocation_report','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function log_report(){
		$data['title'] = 'Log Report';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/report/log_report','',true);
		$this->load->view('pages/index',$data);
	}
	
	/*utility*/
	public function upload_photo(){
		$data['title'] = 'Upload Photo';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/upload_photo','',true);
		$this->load->view('pages/index',$data);
	}
	public function import_data(){
		$data['title'] = 'Import Data';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/import_data','',true);
		$this->load->view('pages/index',$data);
	}
	public function export_data(){
		$data['title'] = 'Export Data';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/export_data','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function session_update(){
		$data['title'] = 'Session Update';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/session_update','',true);
		$this->load->view('pages/index',$data);
	}
	
	public function database_backup(){
		$data['title'] = 'Database Backup';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/database_backup','',true);
		$this->load->view('pages/index',$data);
	}
	public function change_password(){
		$data['title'] = 'Change Password';
		$data['header'] = $this->load->view('pages/common/header','',true);
		$data['topbar'] = $this->load->view('pages/common/topbar','',true);
		$data['aside'] = $this->load->view('pages/common/aside','',true);
		$data['footer'] = $this->load->view('pages/common/footer','',true);
		$data['page'] = $this->load->view('pages/utility/change_password','',true);
		$this->load->view('pages/index',$data);
	}
}