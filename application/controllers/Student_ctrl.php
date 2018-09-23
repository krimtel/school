<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_ctrl extends CI_Controller {

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
			$permissions =  $result[0]['permissionstudent_list_marks_high_class'];
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


	function add_student() {
		$data['admission_no'] = $this->input->post('admission_no');
		$data['roll_no'] = $this->input->post('roll_no');
		$data['name'] = $this->input->post('student_name');
		$data['medium'] = $this->input->post('medium');
		$data['section'] = $this->input->post('section');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['father_name'] = $this->input->post('father_name');
		$data['mother_name'] = $this->input->post('mother_name');
		$data['dob'] = str_replace('/', '-', $this->input->post('dob'));
		$data['dob'] = date("Y-m-d", strtotime($data['dob']));

		$data['gender'] = $this->input->post('gender');
		
		$data['admission_date'] = str_replace('/', '-', $this->input->post('admission_date'));
		$data['admission_date'] = date("Y-m-d", strtotime($data['admission_date']));

		$data['cast'] = $this->input->post('caste');
		$data['blood_group'] = $this->input->post('blood');
		$data['aadhar'] = $this->input->post('aadhaar');
		$data['class_id'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['address'] = $this->input->post('address');
		$data['guardian'] = $this->input->post('guardian');
		$data['local_address'] = $this->input->post('local_address');
		$data['contact_no'] = $this->input->post('contact_no');
		$data['email_id'] = $this->input->post('email');
		$data['medical'] = $this->input->post('medical');
		$data['height'] = $this->input->post('height');
		$data['weight'] = $this->input->post('weight');
		$data['tc'] = $this->input->post('transfer');
		$data['house'] = $this->input->post('house');
		$data['hostler'] = $this->input->post('hostler');
		$data['session'] = $this->Admin_model->current_session();
		$data['ip'] =  $this->input->ip_address();
		$data['created_by'] = $this->session->userdata('user_id');
		$data['created_at'] = date('Y-m-d H:i:s');

		if($data['class_id'] == '12' || $data['class_id'] == '13'){
			$data['fit'] = $this->input->post('fit');
			if($data['fit'] == 'Yes'){
				$data['fit'] = 1;
			}
			else{
				$data['fit'] = 0;
			}
		}

		if($data['class_id'] == '14' || $data['class_id'] == '15'){
			$data['elective'] = $this->input->post('elective');
			$data['subject_group'] = $this->input->post('subject_group');
		}
		//print_r($data); die;
		$this->db->trans_begin();
		$school_id = $this->session->userdata('school_id');
		$school = strtolower($this->session->userdata('school'));
		$bulk_images = array();
		if(!empty($_FILES['userFiles']['name'])){
			$filesCount = count($_FILES['userFiles']['name']);
			for($i = 0; $i < $filesCount; $i++){
				//$file_name = $_FILES['userFiles']['name'][$i];
				$file_name = $_FILES['userFiles']['name'][$i];
					
				$ext = end((explode(".", $file_name)));
				$file_name = preg_replace('/\s+/', '_', $file_name);
				$_FILES['userFile']['name'] = $file_name.'.'.$ext;
				$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
				$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
				$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
				$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
					
				$data['photo'] = $_FILES['userFile']['name'];
				$uploadPath = 'photos/students/'.$school;
					
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'jpg|png|jpeg|JPEG|PNG|JPEG';
					
				$this->load->library('image_lib');
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
					
				if($this->upload->do_upload('userFile')){
					$set = array();
					$bulk_images[] = $set;
				}
				else{
					$error = array('error' => $this->upload->display_errors());
					print_r($error); die;
				}
			}
		}
		$this->db->insert('student',$data);
		$log_info=array(
				'eventid'=> 5, //add student event id
				'event_by'=>$this->session->userdata('user_id'),
				'school_id'=>$this->session->userdata('school_id'),
				'session_id'=>$this->Admin_model->current_session(),
				'ip'=> $this->input->ip_address(),
				'logtime'=>date('Y-m-d H:i:s')
		);
		 
		$this->db->insert('log_tab',$log_info);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('msg'=>'Something Goes Wrong.. Please try Again or Contact us.'));
		}
		else{
			$this->db->trans_commit();
			echo json_encode(array('msg'=>'Insert Successfully','status'=>200));
		}
	}

	function add_student_csv(){
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
					if($a['class'] == 'I'){
						$data['class_id'] = 4;
					}
					else if($a['class'] == 'II'){
						$data['class_id'] = 5;
					}
					else if($a['class'] == 'III'){
						$data['class_id'] = 6;
					}
					else if($a['class'] == 'IV'){
						$data['class_id'] = 7;
					}
					else if($a['class'] == 'V'){
						$data['class_id'] = 8;
					}
					else if($a['class'] == 'VI'){
						$data['class_id'] = 9;
					}
					else if($a['class'] == 'VII'){
						$data['class_id'] = 10;
					}
					else if($a['class'] == 'VIII'){
						$data['class_id'] = 11;
					}
					else if($a['class'] == 'IX'){
						$data['class_id'] = 12;
					}
					else if($a['class'] == 'X'){
						$data['class_id'] = 13;
					}
					else if($a['class'] == 'XI'){
						$data['class_id'] = 14;
					}
					else if($a['class'] == 'XII'){
						$data['class_id'] = 15;
					}
					else if($a['class'] == 'LKG'){
						$data['class_id'] = 2;
					}
					else if($a['class'] == 'UKG'){
						$data['class_id'] = 3;
					}
					else if($a['class']== 'NURSERY'){
						$data['class_id'] = 1;
					}
						
					if($a['section'] == 'A'){
						$data['section'] = 1;
					}
					else if($a['section'] == 'B'){
						$data['section'] = 2;
					}
					else if($a['section'] == 'C'){
						$data['section'] = 3;
					}
					else if($a['section'] == 'D'){
						$data['section'] = 4;
					}
					else if($a['section'] == 'E'){
						$data['section'] = 5;
					}
					else if($a['section'] == 'F'){
						$data['section'] = 6;
					}
					else if($a['section'] == 'G'){
						$data['section'] = 7;
					}
					else if($a['section'] == 'H'){
						$data['section'] = 8;
					}
					else if($a['section'] == 'I'){
						$data['section'] = 9;
					}
					else if($a['section'] == 'J'){
						$data['section'] = 10;
					}
					else if($a['section'] == 'K'){
						$data['section'] = 11;
					}
					else if($a['section'] == 'L'){
						$data['section'] = 12;
					}
					else if($a['section'] == 'M'){
						$data['section'] = 13;
					}
					if(isset($a['subject_group'])){
						if($a['subject_group'] == 'Maths'){
							$data['subject_group'] = 'Maths';
						}
						else if($a['subject_group'] == 'BIO'){
							$data['subject_group'] = 'Boilogy';
						}
						else if($a['subject_group'] == 'Commerce'){
							$data['subject_group'] = 'Commerce';
						}
						else if($a['subject_group'] == 'Arts'){
							$data['subject_group'] = 'Arts';
						}
					}
					if(isset($a['elective_subject'])){
						if($a['elective_subject'] == 'CS'){
							$data['elective'] = 23;
						}
						else if($a['elective_subject'] == 'Hindi'){
							$data['elective'] = 26;
						}
						else if($a['elective_subject'] == 'PE'){
							$data['elective'] = 27;
						}
						else if($a['elective_subject'] == 'Maths'){
							$data['elective'] = 28;
						}
					}
					if(isset($a['fit'])){
						if($a['fit'] == 'Yes'){
							$data['fit'] = 1;
						}
						else if($a['fit'] == 'No'){
							$data['fit'] = 0;
						}
					}
					$data['address'] = $a['address'];
					$data['admission_no'] = $a['admission_no'];
					$data['admission_date'] = date('Y-m-d',strtotime($a['admission_date']));
					$data['roll_no'] = $a['roll_no'];
					$data['medium'] = $a['medium'];
					$data['name'] = $a['student_name'];
					$data['mother_name'] = $a['mother_name'];
					$data['father_name'] = $a['father_name'];
					$date1 = strtr($a['dob'], '/', '-');
					$data['dob'] = date("Y-m-d", strtotime($date1));
					$data['gender'] = $a['gender'];
					$data['address'] = $a['address'];
					$data['contact_no'] = $a['contact_no'];
					$data['house'] = $a['house'];
					$data['aadhar'] = $a['aadhar'];
					$data['hostler'] = $a['hostler'];
					$data['blood_group'] = $a['blood_group'];
					$data['cast'] = $a['cast'];
					$data['created_at']= date('Y-m-d H:i:s');
					$data['school_id']= $this->session->userdata('school_id');
					$data['session'] = $this->Admin_model->current_session();
					$data['created_by'] = $this->session->userdata('user_id');
					$data['ip'] = $this->input->ip_address();
					$data['status'] = 1;
						
					$this->db->select('*');
					$result = $this->db->get_where('student',array('admission_no'=>$data['admission_no'],'school_id'=>$data['school_id'],'status'=>1))->result_array();
					
					if(count($result)>0){
						$this->db->where('admission_no',$data['admission_no']);
						$this->db->update('student',$data);
					}
					else{
						$this->db->insert('student',$data);
					}
				}
				$log_info=array(
						'eventid'=> 6, //event id
						'event_by'=>$this->session->userdata('user_id'),
						'school_id'=>$this->session->userdata('school_id'),
						'session_id'=>$this->Admin_model->current_session(),
						'ip'=> $this->input->ip_address(),
						'logtime'=>date('Y-m-d H:i:s')
				);
				$this->db->insert('log_tab',$log_info);
				
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

	function student_list(){
		if($this->input->post('text') != ''){
			$data['search_text'] = $this->input->post('text');
		}
		
		$data['medium'] = $this->input->post('medium');
		$data['e_type'] = $this->input->post('e_type');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['school'] = $this->session->userdata('school_id');
		$data['session'] = $this->input->post('session');
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');

		$this->db->select('s.class_id,s.medium,s.fit,s.height,s.weight,s.email_id,s.guardian,s.local_address,s.medical,s.tc,s.subject_group,s.elective,s.s_id,s.photo,s.aadhar,s.name,s.roll_no,s.admission_no,s.father_name,s.mother_name,s.gender,s.address,s.contact_no,s.house,s.hostler,s.blood_group,s.cast,DATE_FORMAT(s.dob, "%d-%m-%Y") dob,DATE_FORMAT(s.admission_date, "%d-%m-%Y") admission_date,c.name as cname,sec.name as secname,sub.name as sub_name');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		$this->db->join('subject sub','sub.sub_id = s.elective','left');
		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['fit'] != '0'){
			if($data['fit'] == 'yes'){
				$this->db->where('fit',1);
			}
			else{
				$this->db->where('fit',0);
			}
		}
		if($this->input->post('text') != ''){
			$this->db->where("(s.name LIKE '%".$data['search_text']."%' OR s.roll_no LIKE '%".$data['search_text']."%' OR s.admission_no LIKE '%".$data['search_text']."%')");
			 
		}
		$this->db->order_bY('s.roll_no','asc');
		$result = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.school_id'=>$data['school'],'s.session'=>$data['session'],'s.status'=>1))->result_array();
      
		$result_1 = array();
		foreach($result as $r){
			$temp = array();
if($data['school'] == 1){
   $school = 'shakuntala';
}
else{
   $school = 'sharda';
}

$path = base_url().'photos/students/'.$school.'/'.$r['admission_no'].'.jpg'; 

if (file_get_contents($path)) {
				$temp = $r;
				$temp['photo'] =  $r['admission_no'].'.jpg';
			}
else {
				$temp = $r;
				$temp['photo'] =  $r['admission_no'].'.JPG';
			}
                       //else{
                         // $temp = $r;
                 	  //$temp['photo'] =  '1.jpg';
                      // }
			$result_1[] = $temp;	
		}
		$result = $result_1;


		if(count($result)>0){
			$this->db->select('max');
			$max = $this->db->get_where('exam_type',array('e_id'=>$data['e_type']))->result_array();
			if(count($max) > 0){
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','max'=>$max[0]['max'],'status'=>200));
			}
			else{
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','status'=>200));
			}
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}

	function student_list_marksheet(){

		if($this->input->post('text') != ''){
			$data['search_text'] = $this->input->post('text');
		}
		$data['medium'] = $this->input->post('medium');
		$data['e_type'] = $this->input->post('e_type');
		$data['class'] = (int)$this->input->post('class');
		$data['section'] = (int)$this->input->post('section');
		$data['school'] = (int)$this->session->userdata('school_id');
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');

               if($data['class'] == 12 || $data['class'] == 13){

                 if($data['fit'] == 'no'){
		   			$data['fit'] = 0;
                 } 
                 else{
                  $data['fit'] = 1;
                 }
                }

		$this->db->select('s.*,c.name as cname,sec.name as secname');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
//		$this->db->last_query(); 

		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['class'] == 12 || $data['class'] == 13){
			if(isset($data['fit'])){
				
					if($data['fit'] == 1){
						$this->db->where('fit',1);
					}
					else{
						$this->db->where('fit',0);
					}
				
			}
		}
		if($data['section'] != '0'){
			$this->db->where('section',$data['section']);
		}
		$this->db->order_by('s.roll_no','ASC');
		if($this->input->post('text') != ''){
			$this->db->where("(s.name LIKE '%".$data['search_text']."%' OR s.roll_no LIKE '%".$data['search_text']."%' OR s.admission_no LIKE '%".$data['search_text']."%')");
			 
		}
		$result = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.school_id'=>$data['school'],'s.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		if(count($result)>0){
			$this->db->select('max');
			$max = $this->db->get_where('exam_type',array('e_id'=>$data['e_type']))->result_array();
			if(count($max) > 0){
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','max'=>$max[0]['max'],'status'=>200));
			}
			else{
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','status'=>200));
			}
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}
	
	
	
	function compart_student_list_marksheet(){
		if($this->input->post('text') != ''){
			$data['search_text'] = $this->input->post('text');
		}
		$data['medium'] = $this->input->post('medium');
		$data['e_type'] = $this->input->post('e_type');
		$data['class'] = (int)$this->input->post('class');
		$data['section'] = (int)$this->input->post('section');
		$data['school'] = (int)$this->session->userdata('school_id');
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');
	
		if($data['class'] == 12 || $data['class'] == 13){
	
			if($data['fit'] == 'no'){
				$data['fit'] = 0;
			}
			else{
				$data['fit'] = 1;
			}
		}
	
		$this->db->select('DISTINCT (s.s_id),s.name,s.roll_no,s.admission_no,c.name as cname,sec.name as secname');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		$this->db->join('class_ix_compartment ixc','ixc.student_id = s.s_id');
			
		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['class'] == 12 || $data['class'] == 13){
			if(isset($data['fit'])){
	
				if($data['fit'] == 1){
					$this->db->where('fit',1);
				}
				else{
					$this->db->where('fit',0);
				}
	
			}
		}
		if($data['section'] != '0'){
			$this->db->where('s.section',$data['section']);
		}
		$this->db->order_by('s.roll_no','ASC');
		if($this->input->post('text') != ''){
			$this->db->where("(s.name LIKE '%".$data['search_text']."%' OR s.roll_no LIKE '%".$data['search_text']."%' OR s.admission_no LIKE '%".$data['search_text']."%')");
	
		}
		$result = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.school_id'=>$data['school'],'s.status'=>1))->result_array();
		//print_r($this->db->last_query()); die;
		if(count($result)>0){
			$this->db->select('max');
			$max = $this->db->get_where('exam_type',array('e_id'=>$data['e_type']))->result_array();
			if(count($max) > 0){
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','max'=>$max[0]['max'],'status'=>200));
			}
			else{
				echo json_encode(array('data'=>$result,'msg'=>'All Student Record','status'=>200));
			}
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}


	function student_list_marks(){
		$data['medium'] = $this->input->post('medium');
		$data['e_type'] = $this->input->post('e_type');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['term'] = $this->input->post('term');
		$data['school'] = $this->session->userdata('school_id');
		$data['subject'] = $this->input->post('subject');
		$data['session'] = $this->Admin_model->current_session(); 
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');
		$data['school_id'] = $this->session->userdata('school_id');
		$power = $this->power();
		 
		$this->db->select('*');
		$result = $this->db->get_where('subject',array('sub_id'=>$data['subject']))->result_array();
		if($result[0]['subj_type'] == 'Elective'){
			$data['elective'] = $result[0]['sub_id'];
		}
		$flag = 1;
		if($power == 5){
			$flag = 0;
		}
		else{
			$school_id = $this->session->userdata('school_id');
			$uid = $this->session->userdata('user_id');
			$result = $this->Admin_model->get_teacher_id($uid);
			$this->db->select('*');
			$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$data['class'],'section'=>$data['section'],'medium'=>$data['medium'],'status'=>1,'teacher_id'=>$result[0]['t_id']))->result_array();
			if(count($result)>0){
				$flag = 0;
			}
			else{
				$flag = 1;
			}
		}

		$this->db->select('s.*,c.name as cname,sec.name as secname');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		 
		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['fit'] != '0'){
			if($data['fit'] == 'yes'){
				$this->db->where('fit',1);
			}
			else{
				$this->db->where('fit',0);
			}
		}
		$this->db->order_by('s.roll_no','asc');
		$students = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.school_id'=>$data['school'],'s.session'=>$data['session'],'s.status'=>1))->result_array();

		$this->db->select('*');
		$mark_master = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'session_id'=>$data['session'],'class_id'=>$data['class'],'medium'=>$data['medium'],'section'=>$data['section'],'e_type'=>$data['e_type'],'sub_id'=>$data['subject'],'status'=>1))->result_array();
		
		$this->db->select('sub_id,subj_type');
		$subject_type = $this->db->get_where('subject',array('sub_id'=>$data['subject']))->result_array();
		if($data['class'] < 12){
			$internal_marks = 5;
		}
		else{
			$internal_marks = 5;
		}
		
		if($subject_type[0]['subj_type'] == 'Co-Scholastic'){
			if($data['class'] < 12){
				$max_mark = 3;
			}
			else{
				$max_mark = 5;
			}
			$sub_type = 'Co-Scholastic';
		}
		else{
			$this->db->select('*');
			$max_mark = $this->db->get_where('exam_type',array('e_id'=>$data['e_type'],'status'=>1))->result_array();
			$max_mark = $max_mark[0]['max'];
			 
			if($data['e_type'] == 9 && $data['fit'] == 'yes' && $data['subject'] == 13){
			    $max_mark = 40;
			    $prt_mark = 60;
			}
			$sub_type = 'Scholastic';
		}		
		$final = array();
		if(count($mark_master)>0){
			$this->db->select('*');
			$mark_records = $this->db->get_where('student_mark',array('mm_id'=>$mark_master[0]['m_id']))->result_array();
            
			$this->db->select('*');
			$notebook_marks = $this->db->get_where('notebook_marks',array('mm_id'=>$mark_master[0]['m_id']))->result_array();
			
			foreach($students as $student){
				$f = 1;
				foreach($mark_records as $mark_record){
					if($subject_type[0]['subj_type'] == 'Co-Scholastic'){
						$temp = array();
						if($student['s_id'] == $mark_record['student_id']){
							$temp['s_id'] = $student['s_id'];
							$temp['name'] = $student['name'];
							$temp['admission_no'] = $student['admission_no'];
							$temp['roll_no'] = $student['roll_no'];
							$temp['cname'] = $student['cname'];
							$temp['secname'] = $student['secname'];
							$temp['marks'] = $mark_record['marks'];
							$temp['n_marks'] = 0;
							$temp['a_marks'] = 0;
							$temp['p_marks'] = 0;
							$f = 0;
							$final[] = $temp;
							break;
						}
						else{
							continue;
						}
					}
					else{
						$flag_1 = 1;
						foreach($notebook_marks as $notebook){
							$flag_1 = 0;
							$temp = array();
							if($student['s_id'] == $mark_record['student_id'] && $student['s_id'] == $notebook['student_id']){
								$temp['s_id'] = $student['s_id'];
								$temp['name'] = $student['name'];
								$temp['admission_no'] = $student['admission_no'];
								$temp['roll_no'] = $student['roll_no'];
								$temp['cname'] = $student['cname'];
								$temp['secname'] = $student['secname'];
								$temp['marks'] = $mark_record['marks'];
								$temp['n_marks'] = $notebook['notebook_mark'];
								$temp['a_marks'] = $notebook['subj_enrich'];
								$temp['p_marks'] = $notebook['p_marks'];
								$f = 0;
								$final[] = $temp;
								break;
							}
							else{
								continue;
							}
						}
						if($flag_1){
							if($student['s_id'] == $mark_record['student_id']){
								$temp['s_id'] = $student['s_id'];
								$temp['name'] = $student['name'];
								$temp['admission_no'] = $student['admission_no'];
								$temp['roll_no'] = $student['roll_no'];
								$temp['cname'] = $student['cname'];
								$temp['secname'] = $student['secname'];
								$temp['marks'] = $mark_record['marks'];
								$temp['n_marks'] = 0;
								$f = 0;
								$final[] = $temp;
								break;
							}
							else{
								continue;
							}
						}
					}
				}
				if($f){
					$temp['s_id'] = $student['s_id'];
					$temp['name'] = $student['name'];
					$temp['admission_no'] = $student['admission_no'];
					$temp['roll_no'] = $student['roll_no'];
					$temp['cname'] = $student['cname'];
					$temp['secname'] = $student['secname'];
					$temp['marks'] = 0;
					$temp['n_marks'] = 0;
					$temp['a_marks'] = 0;
					$final[] = $temp;
				}
			}
			if(count($final)>0){
			    if($data['e_type'] == 9 && $data['fit'] == 'yes'){
			    	
			        echo json_encode(array('data'=>$final,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'p_mark'=>$prt_mark,'flag'=>0,'s_type'=>$sub_type,'internal_marks'=>$internal_marks));
			    }
			    else{
				    echo json_encode(array('data'=>$final,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'flag'=>$flag,'s_type'=>$sub_type,'internal_marks'=>$internal_marks));
			    }
			}
			else{
				echo json_encode(array('msg'=>'No record found..','status'=>500));
			}
		}
		else{
			if(count($students)>0){
				if($data['subject'] == 13){
					echo json_encode(array('data'=>$students,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'p_mark'=>$prt_mark,'s_type'=>$sub_type,'flag'=>0,'internal_marks'=>$internal_marks));
				}
				else{
					echo json_encode(array('data'=>$students,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'s_type'=>$sub_type,'internal_marks'=>$internal_marks));
				}
			}
			else{
				echo json_encode(array('msg'=>'no record.','status'=>500));
			}
		}
	}

	function student_list_attendance(){
		$data['medium'] = $this->input->post('medium');
		$data['e_type'] = $this->input->post('e_type');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['term'] = $this->input->post('term');
		$data['school'] = $this->session->userdata('school_id');
		$data['session'] = $this->Admin_model->current_session();
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');
		$power = $this->power();
		$flag = 1;   //
		if($power == 5){
			$flag = 0;
		}
		else if($power != 5){
			$uid = $this->session->userdata('user_id');
			$school_id = $this->session->userdata('school_id');

			$result = $this->Admin_model->get_teacher_id($uid);

			$this->db->select('*');
			$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$data['class'],'section'=>$data['section'],'medium'=>$data['medium'],'status'=>1,'teacher_id'=>$result[0]['t_id']))->result_array();
			if(count($result)>0){
				$flag = 0;
			}
		}

		$this->db->select('s.*,c.name as cname,sec.name as secname');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		 
		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['fit'] != '0'){
			if($data['fit'] == 'yes'){
				$this->db->where('fit',1);
			}
			else{
				$this->db->where('fit',0);
			}
		}
		$this->db->order_by('s.roll_no','asc');
		$students = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.school_id'=>$data['school'],'s.status'=>1))->result_array();
		 
		$this->db->select('*');
		$att_master = $this->db->get_where('attendance_master',array('session_id'=>$data['session'],'school_id'=>$data['school'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'term'=>$data['term'],'status'=>1))->result_array();
		 
		$final = array();
		if(count($att_master)>0){
			$this->db->select('*');
			$att_records = $this->db->get_where('student_atttendance',array('a_master_id'=>$att_master[0]['a_id']))->result_array();

			foreach($students as $student){
				$f = 1;
				foreach($att_records as $att_record){
					$temp = array();
					if($student['s_id'] == $att_record['student_id']){
						$temp['s_id'] = $student['s_id'];
						$temp['name'] = $student['name'];
						$temp['admission_no'] = $student['admission_no'];
						$temp['roll_no'] = $student['roll_no'];
						$temp['cname'] = $student['cname'];
						$temp['secname'] = $student['secname'];
						$temp['present'] = $att_record['present'];
						$f = 0;
						$final[] = $temp;
						break;
					}
					else{
						continue;
					}
				}
				if($f){
					$temp['s_id'] = $student['s_id'];
					$temp['name'] = $student['name'];
					$temp['admission_no'] = $student['admission_no'];
					$temp['roll_no'] = $student['roll_no'];
					$temp['cname'] = $student['cname'];
					$temp['secname'] = $student['secname'];
					$temp['present'] = 0;
					$final[] = $temp;
				}
			}
			if(count($final)>0){
				echo json_encode(array('data'=>$final,'msg'=>'all record.','flag'=>$flag,'status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'No record Found.','status'=>500));
			}
		}
		else{
			foreach($students as $student){
				$temp = array();
				$temp['s_id'] = $student['s_id'];
				$temp['name'] = $student['name'];
				$temp['admission_no'] = $student['admission_no'];
				$temp['roll_no'] = $student['roll_no'];
				$temp['cname'] = $student['cname'];
				$temp['secname'] = $student['secname'];
				$temp['present'] = 0;
				$final[] = $temp;
			}
			if(count($final)>0){
				echo json_encode(array('data'=>$final,'msg'=>'all record.','status'=>200));
			}
			else{
				echo json_encode(array('msg'=>'No record Found.','status'=>500));
			}
		}
		 
	}

	function student_list_filter(){
		$data['medium'] = $this->input->post('medium');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$text = $this->input->post('text');
		$data['elective'] =  $this->input->post('elective');
		$data['subject_group'] =  $this->input->post('s_group');
		$data['fit'] =  $this->input->post('fit');
		 
		 
		$this->db->select('s.*,c.name as cname,sec.name as secname,DATE_FORMAT(s.dob, "%d-%m-%Y") dob,DATE_FORMAT(s.admission_date, "%d-%m-%Y") admission_date');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		if($data['elective'] != 0){
			$this->db->where('elective',$data['elective']);
		}
		if($data['subject_group'] != '0'){
			$this->db->where('subject_group',$data['subject_group']);
		}
		if($data['fit'] != '0'){
			if($data['fit'] == 'yes'){
				$this->db->where('fit',1);
			}
			else{
				$this->db->where('fit',0);
			}
		}
		$this->db->where("(s.admission_no LIKE '%$text%' OR s.roll_no LIKE '%$text%' OR s.name LIKE '%$text%')");
		$result = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.status'=>1))->result_array();
		//print_r($result); die;
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'All Student Record','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}

	function mid_result_class(){
		$data['medium'] = $this->input->post('medium');
		$data['class_id'] = $this->input->post('class');
		$data['section_id'] = $this->input->post('section');
		$data['school'] = $this->session->userdata('school_id');
		$data['session'] = $this->Admin_model->current_session();
		$data['fit'] = $this->input->post('fit');
		$date = date('d-m-Y');
		$result = $this->Result_model->mid_result($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'all record','status'=>200,'date'=>$date));
		}
		else{
			echo json_encode(array('msg'=>'No record Found.','status'=>500));
		}
	}
	
	function final_result_class(){
	    $data['medium'] = $this->input->post('medium');
	    $data['class_id'] = $this->input->post('class');
	    $data['section_id'] = $this->input->post('section');
	    $data['school'] = $this->session->userdata('school_id');
	    $data['session'] = $this->Admin_model->current_session();
	    $data['fit'] = $this->input->post('fit');
	    $data['type'] = $this->input->post('type');
	    $date = date('d-m-Y');
	    $fnl_array = array();
	    if($data['class_id'] == 12){
	    	$result = $this->Result_model->student_final_result_ninth_loop($data);
	    	/////////////////////////////////////new changes//////////////////////////////
	    	foreach($result as $r){
	    		$t2 = array();
	    		$t2['student'][] = $r['student'][0];
	    		$marks = array();
	    		$back = array();
	    		$aggrigate = 0;
	    		foreach($r['marks'] as $mm){
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
	    		$t2['marks'] = $marks;
	    		$t2['co_marks'] = $r['co_marks'];
	    		$t2['back'] = $back;
	    		$t2['aggrigate'] = round($aggrigate,2);
	    		$fnl_array[] = $t2;
	    	}
	    	$final_array = $fnl_array;
	    	
	    	
	    	foreach($final_array as $f){
	    		if(count($f['back']) > 0){
	    			foreach($f['back'] as $b){
	    				if($b == 'Hindi'){
	    					$sname = $b;
	    					$b = 5;
	    					$mrk = 	80;
	    				}
	    				else if($b == 'Science'){
	    					$sname = $b;
	    					$b = 6;
	    					$mrk = 	80;
	    				}
	    				else if($b == 'So. Science'){
	    					$sname = $b;
	    					$b = 7;
	    					$mrk = 	80;
	    				}
	    				else if($b == 'Maths'){
	    					$sname = $b;
	    					$b = 9;
	    					$mrk = 	80;
	    				}
	    				else if($b == 'English'){
	    					$sname = $b;
	    					$b = 31;
	    					$mrk = 	80;
	    				}
	    				$temp = array();
	    				$temp['student_id'] = $f['student'][0]['s_id'];
	    				$temp['subject'] = $b;
	    				$temp['mm'] = $mrk;
	    				$temp['s_name'] = $sname;
	    				$temp['n_marks'] = 0;
	    				$temp['class'] = $f['student'][0]['class_id'];
	    				$temp['section'] = $f['student'][0]['section'];
	    				$temp['session'] = $data['session'];
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
	    				if(count($result1)>0){
	    					
	    				}else{
	    					$this->db->insert('class_ix_compartment',$temp);
	    				}
	    			}
	    		}
	    	}
	    }
	    else{
	    	$result = $this->Result_model->final_result($data);
	    	/////////////////////////////////////////////new changes////////////////////////////
	    	$final_array = array();
	    	foreach($result as $r){
	    		$temp = array();
	    		$temp['student'] = $r['student_detail']['student'][0];
	    		foreach($r['student_detail']['marks'] as $mm){
	    			foreach ($r['student_deatil_final']['marks'] as $fm){
	    				$t = array();
	    				if($mm['sub_id'] == $fm['sub_id']){
	    					$t['sub_id'] = $mm['sub_id'];
	    					$t['name'] = $mm['name'];
	    					if($mm['pre_mark'] != 'A'){
	    						$t['pre_mark'] = round((($mm['pre_mark']/ 50) * 10),2);
	    					}
	    					else{
	    						$t['pre_mark'] = 'Abst';
	    					}
	    					
	    					if($mm['mid_mark'] != 'A'){
	    						$t['mid_mark'] = $mm['mid_mark'];
	    					}
	    					else{
	    						$t['mid_mark'] = 'Abst';
	    					}
	    					$t['notebook_mark'] = $mm['notebook_mark'];
	    					$t['subj_enrich'] = $mm['subj_enrich'];
	    					
	    					if($fm['pre_mark'] != 'A'){
	    						$t['post_mark'] = round((($fm['pre_mark']/50) * 10),2);
	    					}
	    					else{
	    						$t['post_mark'] = 'Abst';
	    					}
	    					if($fm['mid_mark'] != 'A'){
	    						$t['final_mark'] = $fm['mid_mark'];
	    					}
	    					else{
	    						$t['final_mark'] = 'Abst';
	    					}
	    					
	    					$t['final_notebook_mark'] = $fm['notebook_mark'];
	    					$t['final_subj_enrich'] = $fm['subj_enrich'];
	    					$t['term_1_total'] = round(($t['pre_mark'] + $mm['notebook_mark'] + $mm['subj_enrich'] + $t['mid_mark']),2);
	    					$t['term_2_total'] = round(($t['post_mark'] + $fm['notebook_mark'] + $fm['subj_enrich'] + $t['final_mark']),2);
	    					
	    					if(($t['term_1_total'] + $t['term_2_total']) < 66){
	    						$t1 = array();
	    						$t1['sub_id'] = $mm['sub_id'];
	    						$t1['name'] = $mm['name'];
	    						$temp['back'][] = $t1;
	    						$t['term_1_total'] = $t['term_1_total'].'*'; 
	    						$t['term_2_total'] = $t['term_2_total'].'*'; 
	    					}
	    					
	    					$grade = ceil($t['term_1_total']);
	    					if($grade > 90){
	    						$t['term_1_grade'] = 'A1';
	    					}
	    					else if($grade > 80){
	    						$t['term_1_grade'] = 'A2';
	    					}
	    					else if($grade > 70){
	    						$t['term_1_grade'] = 'B1';
	    					}
	    					else if($grade > 60){
	    						$t['term_1_grade'] = 'B2';
	    					}
	    					else if($grade > 50){
	    						$t['term_1_grade'] = 'C1';
	    					}
	    					else if($grade > 40){
	    						$t['term_1_grade'] = 'C2';
	    					}
	    					else if($grade > 32){
	    						$t['term_1_grade'] = 'D';
	    					}
	    					else if($grade > 0){
	    						$t['term_1_grade'] = 'E';
	    					}
	    					else{
	    						$t['term_1_grade'] = '-';
	    					}
	    					
	    					$grade = ceil($t['term_2_total']);
	    					if($grade > 90){
	    						$t['term_2_grade'] = 'A1';
	    					}
	    					else if($grade > 80){
	    						$t['term_2_grade'] = 'A2';
	    					}
	    					else if($grade > 70){
	    						$t['term_2_grade'] = 'B1';
	    					}
	    					else if($grade > 60){
	    						$t['term_2_grade'] = 'B2';
	    					}
	    					else if($grade > 50){
	    						$t['term_2_grade'] = 'C1';
	    					}
	    					else if($grade > 40){
	    						$t['term_2_grade'] = 'C2';
	    					}
	    					else if($grade > 32){
	    						$t['term_2_grade'] = 'D';
	    					}
	    					else if($grade > 0){
	    						$t['term_2_grade'] = 'E';
	    					}
	    					else{
	    						$t['term_2_grade'] = '-';
	    					}
	    					
	    					
	    					$temp['marks'][] = $t;
	    				}
	    			}
	    		}
	    		
	    		foreach($r['student_detail']['co_marks'] as $mm){
	    			foreach ($r['student_deatil_final']['co_marks'] as $fm){
	    				$t = array();
	    				if($mm['sub_id'] == $fm['sub_id']){
	    					$t['sub_id'] = $mm['sub_id'];
	    					$t['name'] = $mm['name'];
	    					$t['term_1_mark'] = $mm['mark'];
	    					$t['term_2_mark'] = $fm['mark'];
	    					$temp['co_marks'][] = $t;
	    				}
	    			}
	    		}
	    		
	    		$final_array[]  = $temp;
	    	}
	    	
	    	
	    	foreach($final_array as $f){
	    		if(isset($f['back'])){
	    			if(count($f['back']) > 0){	
		    			foreach($f['back'] as $b){
		    				if($b['name'] == 'Hindi'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				else if($b['name'] == 'Science'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				else if($b['name'] == 'So. Science'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				else if($b['name'] == 'Maths'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				else if($b['name'] == 'English'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				else if($b['name'] == 'EVS'){
		    					$sname = $b['name'];
		    					$b = $b['sub_id'];
		    					$mrk = 	80;
		    				}
		    				$temp = array();
		    				$temp['student_id'] = $f['student']['s_id'];
		    				$temp['subject'] = $b;
		    				$temp['mm'] = $mrk;
		    				$temp['s_name'] = $sname;
		    				$temp['n_marks'] = 0;
		    				$temp['class'] = $f['student']['class_id'];
		    				$temp['section'] = $f['student']['section'];
		    				$temp['session'] = $data['session'];
		    				$temp['medium'] = $f['student']['medium'];
		    				$temp['school'] = $f['student']['school_id'];
		    				$temp['created_at'] = date('d-m-y h:i:s');
		    				$temp['created_by'] = $this->session->userdata('user_id');
		    				 
		    				$this->db->select('*');
		    				$result1 = $this->db->get_where('class_ix_compartment',array(
		    						'student_id' => $f['student']['s_id'],
		    						'subject' => $b,
		    						'class' => $f['student']['class_id'],
		    						'section' => $f['student']['section'],
		    						'medium' => $f['student']['medium'],
		    						'school' => $f['student']['school_id'],
		    						's_name' => $sname
		    				))->result_array();
		    				if(count($result1)>0){
		    	
		    				}else{
		    					$this->db->insert('class_ix_compartment',$temp);
		    				}
		    			}
		    		}
	    		}
	    	}
	    	
	    }
	    print_r($final_array); die;
	    if(count($final_array)>0){
	        echo json_encode(array('data'=>$final_array,'msg'=>'all record','status'=>200,'date'=>$date));
	    }
	    else{
	        echo json_encode(array('msg'=>'No record Found.','status'=>500));
	    }
	}
	
	function mid_result_high_class(){
		$data['medium'] = $this->input->post('medium');
		$data['class_id'] = $this->input->post('class');
		$data['section_id'] = $this->input->post('section');
		$data['school'] = $this->session->userdata('school_id');
		$data['session'] = $this->Admin_model->current_session();
		$data['sgroup'] = $this->input->post('s_group');
		
		$date = date('d-m-Y');
		$result = $this->Result_model->mid_result_high_class($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'all record','status'=>200,'date'=>$date));
		}
		else{
			echo json_encode(array('msg'=>'No record Found.','status'=>500));
		}
	}

	function mid_result_classwise(){
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$data['school'] = $this->session->userdata('school_id');
		$data['session'] = $this->Admin_model->current_session();

		$result = $this->Result_model->mid_result_classwise($data);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'all record','status'=>200,'date'=>$date));
		}
		else{
			echo json_encode(array('msg'=>'No record Found.','status'=>500));
		}

	}

	function admission_no_check(){
		$str = $this->input->post('str');
		$data['school_id'] = $this->session->userdata('school_id');
		$result = $this->db->query("select * from student where admission_no like'".$str."'  AND school_id = ".$data['school_id']." AND status = 1")->result_array();
		 
		if(count($result)>0){
			echo json_encode(array('data'=>$str,'status'=>500));
		}
		else{
			echo json_encode(array('data'=>$str,'status'=>200));
		}
	}

	function classwise_pre(){
		$data['class_id'] = $this->input->post('c_id');
		$data['section'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['session'] = $this->input->post('session');
		$data['type'] = $this->input->post('type');
		$data['fit'] = $this->input->post('fit');
		
	    $result = $this->Student_model->classwise_pre($data);

		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function classwise_pre_high_class(){
		$data['class_id'] = (int)$this->input->post('c_id');
		$data['section'] = (int)$this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$data['school_id'] = (int)$this->session->userdata('school_id');
		$data['session'] = (int)$this->input->post('session');
		$data['type'] = $this->input->post('type');
		$data['s_group'] = $this->input->post('s_group');
		
		if($data['type'] == 'pre'){
			$result = $this->Student_model->classwise_pre_high_class($data);
		}
		else if($data['type'] == 'post_mid'){
		    $result = $this->Student_model->classwise_post_high_class($data);
		}
		else if($data['type'] == 'final'){
			$result = $this->Student_model->classwise_final_high_class($data);
		}
		
		else if($data['type'] == 'final_fard'){
			$val['section_id'] = $data['section'];
			$val['class_id'] = $data['class_id'];
			$val['medium'] = $data['medium'];
			$val['sgroup'] = $data['s_group'];
			if(($val['section_id'] == 1 && $val['sgroup'] == 'Maths')){
				$result1 = $this->Result_model->student_deatil_high_class_final_loop($val);
				$val['sgroup'] = 'Boilogy';
				$result2 = $this->Result_model->student_deatil_high_class_final_loop($val);
				
				
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
			    
				$result = $this->Result_model->student_deatil_high_class_final_loop($val);
			}
			
			$fnl_array = array();
			foreach($result as $r){
				$temp = array();
				$temp['student'] = $r['student'][0];
				$pre_total = 0;
				$mid_total = 0;
				$post_total = 0;
				$session_end = 0;
				$academic_total = 0;
				$grand_total = 0;
				///////////
				$anual_total = 0;
				$outoff = 0;
				$post_mid_marks = 0;
				$acdmc = ''; 
				$marks = array();
				foreach($r['final_marks'] as $mm){
					$marks[] = $mm;
					$pre_total = $pre_total + $mm['pre_5'];
					$mid_total = $mid_total + $mm['mid_20'];
					$post_total = $post_total + $mm['post_5'];
					$session_end = $session_end + $mm['final_thory_practical'];
					$academic_total = $academic_total + $mm['academic_attention'];
					$grand_total = $grand_total + $mm['grand_total'];
					$post_mid_marks = $post_mid_marks + $mm['post_mid_marks'];
					$anual_total = $anual_total + $mm['annual_total'];
					$outoff = $outoff + ($mm['final_thory_marks_max'] + $mm['final_practical_marks_max']);
					
					if(ceil($mm['grand_total']) < 33){
						 $acdmc = $academic_total . '*';
						//$temp['grand_total'] = $temp['grand_total'].'*';
						$temp['back'][] = $mm['subject_name'];
					}
					else{
						$acdmc = $academic_total;
					}
				}
				$temp['final_marks'] = $marks;
				$temp['pre_total'] = $pre_total;
				$temp['mid_total'] = $mid_total;
				$temp['post_total'] = $post_total;
				$temp['session_end'] = $session_end;
				$temp['academic_total'] = $acdmc;
				$temp['grand_total'] = $grand_total;
				//$temp['aggrigate'] = $pre_total + $mid_total + $post_total + $session_end + $academic_total + $grand_total;
				$temp['outoff'] = $outoff;
				$temp['post_mid_marks'] = $post_mid_marks;
				//$temp['aggrigate'] = $pre_total + $mid_total + $post_total + $session_end + $academic_total + $anual_total +$post_mid_marks;
				//$temp['percent'] = round((($temp['aggrigate'])*100/ 1250),2);
				$temp['aggrigate'] = $r['total_obtail'];
				$temp['percent'] = $r['percent'];
				
				if(isset($temp['back'])){
					if(count($temp['back']) > 0 && count($temp['back']) < 3){
						$temp['result'] = 'Compart';
					}
					else if(count($temp['back']) > 2){
						$temp['result'] = 'Detained';
					}
					else if(count($temp['back']) == 0){
						$temp['result'] = 'Pass';
					}
				}
				else{
					$temp['result'] = 'Pass';
				}
				////// div
				if(ceil($temp['percent']) > 59){
					$temp['div'] = '1st';
				}
				else if(ceil($temp['percent']) > 45 && ceil($temp['percent']) < 60){
					$temp['div'] = '2nd';
				}
				else if(ceil($temp['percent']) > 33 && ceil($temp['percent']) < 46){
					$temp['div'] = '3rd';
				}
				else{
					$temp['div'] = 'Fail';
				}
				
				$fnl_array[] = $temp;
				
			}
			
			$pass_list = array();
			foreach ($fnl_array as $f){
				if($f['result'] == 'Pass'){
					$pass_list[] = $f;
				}
			}
			$topper_list = $pass_list;
			$toppers = array();
			foreach ($topper_list as $key => $row){
				if(isset($row['grand_total'])){
					$toppers[$key] = $row['grand_total'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
			array_multisort($toppers, SORT_DESC, $topper_list);
			
			$fnl1_array = array();
			foreach ($fnl_array as $ff){
				$temp = array();
				$f = 1;
				$pre_marks = 0;
				$c = 0;
				
				foreach($topper_list as $key => $value){
					if($ff['student']['s_id'] == $value['student']['s_id']){
						$temp = $ff;
						if($pre_marks < $value['grand_total']){
							$pre_marks = $value['grand_total'];
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
				$fnl1_array[] = $temp;
			}
			
			$result = array();
			$result = $fnl1_array;
		
		}
		
		
		
		else{
			$result = $this->Student_model->classwise_mid_high_class($data);
			
		}
	
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}

	function stu_del(){
		$sid = $this->input->post('s_id');
		$this->db->where('s_id',$sid);
		if($this->db->delete('student')){
			$log_info=array(
					'eventid'=> 1, //event id
					'event_by'=>$this->session->userdata('user_id'),
					'school_id'=>$this->session->userdata('school_id'),
					'session_id'=>$this->Admin_model->current_session(),
					'ip'=> $this->input->ip_address(),
					'logtime'=>date('Y-m-d H:i:s')
			);
			$this->db->insert('log_tab',$log_info);
			
			echo json_encode(array('status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}

	function student_detail(){
		 
		$data['id'] = $this->input->post('s_id');
		$this->db->select('*,DATE_FORMAT(dob, "%d/%m/%Y") dob,DATE_FORMAT(admission_date, "%d/%m/%Y") admission_date');
		$result = $this->db->get_where('student',array('s_id'=>$data['id'],'status'=>1))->result_array();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'student record.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No record Found.','status'=>500));
		}
	}

	function student_update() {
		$data1['stu_id'] = $this->input->post('stu_id');
		$data['admission_no'] = $this->input->post('admission_no');
		$data['roll_no'] = $this->input->post('roll_no');
		$data['name'] = $this->input->post('student_name');
		$data['medium'] = $this->input->post('medium');
		$data['section'] = $this->input->post('section');
		$data['gender'] = $this->input->post('stu_sex');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['father_name'] = $this->input->post('father_name');
		$data['mother_name'] = $this->input->post('mother_name');
		$data['dob'] = $this->input->post('dob');
		$data['dob'] = str_replace("/","-",$data['dob']);
		$data['dob'] = date("Y-m-d", strtotime($data['dob']));
		 
		$data['admission_date'] = $this->input->post('admission_date');
		$data['admission_date'] = str_replace("/","-",$data['admission_date']);
		$data['admission_date'] = date("Y-m-d", strtotime($data['admission_date']));
		$data['cast'] = $this->input->post('caste');
		$data['blood_group'] = $this->input->post('blood');
		$data['aadhar'] = $this->input->post('aadhaar');
		$data['class_id'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['address'] = $this->input->post('address');
		$data['guardian'] = $this->input->post('guardian');
		$data['local_address'] = $this->input->post('local_address');
		$data['contact_no'] = $this->input->post('contact_no');
		$data['email_id'] = $this->input->post('email');
		$data['medical'] = $this->input->post('medical');
		$data['height'] = $this->input->post('height');
		$data['weight'] = $this->input->post('weight');
		$data['tc'] = $this->input->post('transfer');
		$data['house'] = $this->input->post('house');
		$data['hostler'] = $this->input->post('hostler');
		$data['session'] = $this->Admin_model->current_session();
		$data['ip'] =  $this->input->ip_address();
		$data['created_by'] = $this->session->userdata('user_id');
		$data['created_at'] = date('Y-m-d H:i:s');

		if($data['class_id'] == '12' || $data['class_id'] == '13'){
			$data['fit'] = $this->input->post('fit');
			if($data['fit'] == 'Yes'){
				$data['fit'] = 1;
			}
			else{
				$data['fit'] = 0;
			}
		}

		if($data['class_id'] == '14' || $data['class_id'] == '15'){
			$data['elective'] = $this->input->post('elective');
			$data['subject_group'] = $this->input->post('subject_group');
		}
		
		$this->db->trans_begin();
		$this->db->where('s_id',$data1['stu_id']);
		$this->db->update('student',$data);
		$log_info = array(
				'eventid' => 2, //event id
				'event_by' => $this->session->userdata('user_id'),
				'school_id' => $this->session->userdata('school_id'),
				'session_id' => $this->Admin_model->current_session(),
				'class_id' => $data['class_id'],
				'section_id' => $data['section'],
				'student_id' => $data1['stu_id'],
				'medium' => $data['medium'],
				'ip'=> $this->input->ip_address(),
				'logtime'=>date('Y-m-d H:i:s')
		);
		
		$this->db->insert('log_tab',$log_info);
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>500));
		}
		else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200));
		}
	}
    
    function student_list_marks_high_class(){
    	$data['session'] = (int)$this->Admin_model->current_session();
    	$data['class'] = (int)$this->input->post('class');
    	$data['section'] = (int)$this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['e_type'] = (int)$this->input->post('e_type');
    	$data['school_id'] = (int)$this->session->userdata('school_id');
    	$data['s_group'] = $this->input->post('s_group');
		
		if($data['s_group'] == 'commer'){
    		$data['s_group'] = 'Commerce';
    	}
    	else if($data['s_group'] == 'maths'){
    		$data['s_group'] = 'Maths';
    	}
    	else if($data['s_group'] == 'bio'){
    		$data['s_group'] = 'Boilogy';
    	}
		
    	$data['elective'] = (int)$this->input->post('elective');
    	$data['subject'] = (int)$this->input->post('subject'); 

    	$this->db->select('*');
    	if($data['elective'] != 0){
    		$this->db->where('elective',$data['elective']);
    	}
    	if($data['s_group'] != ''){
    		$this->db->where('subject_group',$data['s_group']);
    	}
    	$this->db->order_by('roll_no','ASC');
    	$result = $this->db->get_where('student',array('school_id' => $data['school_id'],'medium'=>$data['medium'],'class_id' => $data['class'],'section' => $data['section'],'status' => 1))->result_array();
   
    	
		if($data['s_group'] == 'Commerce'){
    		$data['s_group'] = 'commer';
    	}
    	else if($data['s_group'] == 'maths'){
    		$data['s_group'] = 'maths';
    	}
    	else if($data['s_group'] == 'Boilogy'){
    		$data['s_group'] = 'bio';
    	}
    	
    	
    	$this->db->select('*');
    	$marks_master = $this->db->get_where('high_class_mark_master',
    			array('session_id'=>$data['session'],
    				  'school_id' => $data['school_id'],
					  's_group' => $data['s_group'],
    				  'class_id' => $data['class'],
    				  'section_id' => $data['section'],
    				  'e_type' => $data['e_type'],
    				  'elective' => $data['elective'],	
    				  'medium' => $data['medium'],
    				  'subject' => $data['subject']))->result_array();
    			
    	if(count($marks_master) > 0){
    		$this->db->select('*');
    		$student_marks = $this->db->get_where('student_marks_high_class',array('hm_id'=>$marks_master[0]['id'],'school_id'=>$data['school_id'],'class_id'=>$data['class'],'section_id'=>$data['section'],'status'=>1))->result_array();
    	}
    	else{
    		$student_marks = array();
    	}	
    	//print_r($this->db->last_query()); die;
    	
    	$flag_1 = 0;
    	$students_mark = array();
    	if(count($student_marks) > 0){
    		foreach($result as $r){
    			$flag = 1;
    			foreach($student_marks as $sm){
    				if($sm['student_id'] == $r['s_id']){
    					$temp = $r;
    					$temp['marks'] = $sm['marks'];
    					$temp['p_marks'] = $sm['p_marks'];
    					$temp['a_marks'] = $sm['a_marks'];
 		   				$students_mark[] = $temp;
 		   				$flag = 0;
 		   				$flag_1 = 1;
    				}
    			}
    			if($flag){
    				$temp = $r;
    				$temp['marks'] = 0;
    				$temp['p_marks'] = 0;
    				$temp['a_marks'] = 0;
    				$students_mark[] = $temp;
    				$flag = 0;
    			}
    		}
    	}
    	
    	if(count($result)>0){
    		if($data['e_type'] == 1){
    			$etype = 1;
    		}
    		if($data['e_type'] == 4){
    			$etype = 2;
    		}
    		if($data['e_type'] == 6){
    		    $etype = 3;
    		}
    		if($data['e_type'] == 9){
    		    $etype = 4;
    		}
    		$this->db->select('*');
    		$subject_detail = $this->db->get_where('subject_format_11_12',array(
    				'status'=>1,	
    				'class'=>(int)$data['class'],
    				's_group' => $this->input->post('s_group'),
    				'e_type' => (int)$etype,
    				'sub_id'=>(int)$data['subject']))->result_array();
    	
    		if($subject_detail[0]['practical'] == 1){
    			$s_marks = $subject_detail[0]['subj_marks'];
    			$p_marks = $subject_detail[0]['practical_mark'];
    			$a_marks = 10;
    		}
    		else{
    			$s_marks = $subject_detail[0]['subj_marks'];
    			$p_marks = 0;
    			$a_marks = 10;
    		}
    		
    		
    		if($flag_1){
    		    
    		    echo json_encode(array('data'=>$students_mark,'s_marks'=>$s_marks,'p_marks'=>$p_marks,'a_marks'=>$a_marks,'status'=>200));
    		}
    		else{
    		    echo json_encode(array('data'=>$result,'s_marks'=>$s_marks,'p_marks'=>$p_marks,'a_marks'=>$a_marks,'status'=>200));
    		}
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }
    
    
    function compart_student_list_marks_high_class(){
    	$data['session'] = (int)$this->Admin_model->current_session();
    	$data['class'] = (int)$this->input->post('class');
    	$data['section'] = (int)$this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['e_type'] = (int)$this->input->post('e_type');
    	$data['school_id'] = (int)$this->session->userdata('school_id');
    	$data['s_group'] = $this->input->post('s_group');
    
    	if($data['s_group'] == 'commer'){
    		$data['s_group'] = 'Commerce';
    	}
    	else if($data['s_group'] == 'maths'){
    		$data['s_group'] = 'Maths';
    	}
    	else if($data['s_group'] == 'bio'){
    		$data['s_group'] = 'Boilogy';
    	}
    
    	$data['elective'] = (int)$this->input->post('elective');
    	$data['subject'] = (int)$this->input->post('subject');
    
    	$this->db->select('s.*,ixc.n_marks,ixc.mm');
    	$this->db->join('class_ix_compartment ixc','ixc.student_id = s.s_id');
    	if($data['elective'] != 0){
    		$this->db->where('elective',$data['elective']);
    	}
    	if($data['s_group'] != ''){
    		$this->db->where('subject_group',$data['s_group']);
    	}
    	$this->db->order_by('roll_no','ASC');
    	$this->db->where('ixc.subject',$data['subject']);
    	$result = $this->db->get_where('student s',array('s.school_id' => $data['school_id'],'s.medium'=>$data['medium'],'s.class_id' => $data['class'],'s.section' => $data['section'],'s.status' => 1))->result_array();
    	
    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('msg'=>'no record found.','status'=>500));
    	}
    }
    
    function marks_entry_high_class(){
    	$data['session'] = (int)$this->Admin_model->current_session();
    	$data['school_id'] = (int)$this->session->userdata('school_id');
    	$data['class'] = (int)$this->input->post('class');
    	$data['section'] = (int)$this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['e_type'] = (int)$this->input->post('e_type');
    	$data['s_group'] = $this->input->post('s_group');
    	$data['elective'] = (int)$this->input->post('elective');
    	$data['subject'] = (int)$this->input->post('subject');
    	$data['s_marks'] = $this->input->post('s_marks');
    	$data['p_marks'] = $this->input->post('p_marks');
    	$data['a_marks'] = $this->input->post('a_marks');
    	
    	$this->db->trans_begin();
    	$this->db->select('*');
    	$result = $this->db->get_Where('high_class_mark_master',array(
    			'session_id'=>$data['session'],
    			's_group'=>$data['s_group'],
    			'school_id'=>$data['school_id'],
    			'class_id'=>$data['class'],
    			'section_id'=>$data['section'],
    			'e_type'=>$data['e_type'],
    			'medium'=>$data['medium'],
    			'subject'=>$data['subject'],
    			'elective'=>$data['elective']))->result_array();
		//$update = 0;
    	if(count($result)>0){
    		$this->db->where('id',$result[0]['id']);
    		$this->db->delete('high_class_mark_master');
    		//$update = 1;
    	}
    	
    	$master['session_id'] = $data['session']; 
    	$master['school_id'] = $data['school_id'];
    	$master['class_id'] = $data['class'];
    	$master['section_id'] = $data['section'];
    	$master['e_type'] = $data['e_type'];
    	$master['s_group'] = $data['s_group'];
    	$master['subject'] = $data['subject'];
    	$master['medium'] = $data['medium'];
    	$master['elective'] = $data['elective'];
    	
    	$this->db->insert('high_class_mark_master',$master);
    	$x = $this->db->insert_id();
    	
    	$val = array();  
    	if(count($data['s_marks']) > 0){
    	    if(count($data['p_marks']) > 0){
    	        if(count($data['a_marks']) > 0){
    	            foreach($data['s_marks'] as $smarks){
    	                foreach($data['p_marks'] as $pmarks){
    	                    foreach($data['a_marks'] as $amarks){
    	                        if($smarks['s_id'] == $pmarks['s_id'] && $pmarks['s_id'] == $amarks['s_id']){
    	                            $temp = array();
    	                            $temp['session'] = $data['session'];
    	                            $temp['school_id'] = $data['school_id'];
    	                            $temp['class_id'] = $data['class'];
    	                            $temp['section_id'] = $data['section'];
    	                            $temp['student_id'] = $pmarks['s_id'];
    	                            $temp['subject_id'] = $data['subject'];
    	                            $temp['e_type'] = $data['e_type'];
    	                            $temp['marks'] = $smarks['val'];
    	                            $temp['hm_id'] = $x;
    	                            $temp['p_marks'] = $pmarks['val'];
    	                            $temp['a_marks'] = $amarks['val'];
    	                        }else{
    	                            continue;
    	                        }
    	                        $val[]=$temp;
    	                    }
    	                    
    	                }
    	            }
    	        }
    	    }
    	}
    	    if(count($data['s_marks']) > 0){
    	        if(count($data['p_marks']) > 0){
    	            foreach($data['s_marks'] as $smarks){
    	                foreach($data['p_marks'] as $pmarks){
    	                    if($smarks['s_id'] == $pmarks['s_id']){
    	                        $temp = array();
    	                        $temp['session'] = $data['session'];
    	                        $temp['school_id'] = $data['school_id'];
    	                        $temp['class_id'] = $data['class'];
    	                        $temp['section_id'] = $data['section'];
    	                        $temp['student_id'] = $pmarks['s_id'];
    	                        $temp['subject_id'] = $data['subject'];
    	                        $temp['e_type'] = $data['e_type'];
    	                        $temp['marks'] = $smarks['val'];
    	                        $temp['hm_id'] = $x;
    	                        $temp['p_marks'] = $pmarks['val'];
    	                        $temp['a_marks'] = 0;
    	                    }
    	                    else{
    	                        continue;
    	                    }
    	                    $val[] = $temp;
    	                    }
    	                }
    	          }
    		else{
    			foreach($data['s_marks'] as $smarks){
    				if(count($data['a_marks']) > 0){
    					foreach($data['a_marks'] as $amarks){
	    					if($smarks['s_id'] == $amarks['s_id']){
	    						$temp = array();
	    						$temp['session'] = $data['session'];
	    						$temp['school_id'] = $data['school_id'];
	    						$temp['class_id'] = $data['class'];
	    						$temp['section_id'] = $data['section'];
	    						$temp['student_id'] = $smarks['s_id'];
	    						$temp['subject_id'] = $data['subject'];
	    						$temp['e_type'] = $data['e_type'];
	    						$temp['marks'] = $smarks['val'];
	    						$temp['hm_id'] = $x;
	    						$temp['a_marks'] = $amarks['val'];
	    					}
	    					else{
	    						continue;
	    					}
	    					$val[] = $temp;
    					}
    				}
    				else{
	    				$temp = array();
	    				$temp['session'] = $data['session'];
	    				$temp['school_id'] = $data['school_id'];
	    				$temp['class_id'] = $data['class'];
	    				$temp['section_id'] = $data['section'];
	    				$temp['student_id'] = $smarks['s_id'];
	    				$temp['subject_id'] = $data['subject'];
	    				$temp['e_type'] = $data['e_type'];
	    				$temp['marks'] = $smarks['val'];
	    				$temp['hm_id'] = $x;
	    				$temp['p_marks'] = 0;
	    				$val[] = $temp;
    				}
    			}
    		}
    	} 
    	$this->db->insert_batch('student_marks_high_class',$val);
    	if ($this->db->trans_status() === FALSE) {
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'something went wrong.','status'=>500));
    	}
    	else{
    		$this->db->trans_commit();
    		echo json_encode(array('msg'=>'student marks submitted successfully.','status'=>200));
    	}
    }
    
    public function csv_download($data, $data1)
    {
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
        $phpExcel->getActiveSheet()->freezePane('A1');
        //coloum width
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4.1);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
        
        // 		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray);
        // 		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray1);
        // 		$phpExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArray12);
        $prestasi->setCellValue('A1', 'S. No.');
        $prestasi->setCellValue('B1', 'Class');
        $prestasi->setCellValue('C1', 'Section');
        $prestasi->setCellValue('D1', 'Medium');
        $prestasi->setCellValue('E1', 'Exam_Type');
        $prestasi->setCellValue('F1', 'Subject');
        $prestasi->setCellValue('G1', 'Subject_Type');
        $prestasi->setCellValue('G1', 'Subject_Group');
        $prestasi->setCellValue('H1', 'Student_Name');
        $prestasi->setCellValue('I1', 'Admission_No');
        $prestasi->setCellValue('J1', 'Roll_No');
        $prestasi->setCellValue('K1', 'Subject_Marks');
        $prestasi->setCellValue('L1', 'Notebook');
        $prestasi->setCellValue('M1', 'Subject_Enrichment');
        $prestasi->setCellValue('N1', 'Practical_Marks');
        
        
        //----------------data coming from model -------------------------------------
        $this->db->select('*');
        $result = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],
            'e_type'=>$data['e_type'],
            'class_id'=>$data['class_id'],
            'section'=>$data['section_id'],
            'medium'=>$data['medium'],
            'sub_id'=>$data['subject_id'],
            'status' => 1
        ))->result_array();
        
        if(count($result)>0){
            if(isset($data1['marks']) && ($data1['notebook']=='') && ($data1['subj_anrich']=='') && ($data1['practical']=='')){
                
                $this->db->select('sm.medium as Medium, c.name as Class, s.name as Section, sb.name as Subject, sb.subj_type as Subject_Type, ext.e_name as Exam_Type, sm.marks as Marks, std.admission_no as Admission_No, std.roll_no as Roll_No,std.name as Student_Name');
                $this->db->from('student_mark sm');
                $this->db->join('class c','c.c_id=sm.class_id', 'inner');
                $this->db->join('section s','s.id=sm.section_id', 'inner');
                $this->db->join('subject sb','sb.sub_id=sm.subject_id', 'inner');
                $this->db->join('exam_type ext','ext.e_id=sm.e_type', 'inner');
                $this->db->join('student std','std.s_id=sm.student_id', 'inner');
                $this->db->where('sm.mm_id',$result[0]['m_id']);
                $csv_data['query'] = $this->db->get()->result_array();
                
            }else{
                $this->db->select('sm.medium as Medium, c.name as Class, s.name as Section, sb.name as Subject, sb.subj_type as Subject_Type, ext.e_name as Exam_Type, sm.marks as Marks, std.admission_no as Admission_No, std.roll_no as Roll_No,std.name as Student_Name, nb.notebook_mark, nb.subj_enrich, nb.p_marks');
                $this->db->from('student_mark sm');
                $this->db->join('notebook_marks nb','nb.mm_id=sm.mm_id AND nb.student_id = sm.student_id', 'inner');
                $this->db->join('class c','c.c_id=sm.class_id', 'inner');
                $this->db->join('section s','s.id=sm.section_id', 'inner');
                $this->db->join('subject sb','sb.sub_id=sm.subject_id', 'inner');
                $this->db->join('exam_type ext','ext.e_id=sm.e_type', 'inner');
                $this->db->join('student std','std.s_id=sm.student_id', 'inner');
                $this->db->where('sm.mm_id',$result[0]['m_id']);
                //                 $this->db->get()->result_array();
                //                 print_r($this->db->last_query()); die;
                $csv_data['query'] =  $this->db->get()->result_array();
            }
        }
        
        //-------------------------------------------------------------------------
        
        $no=0;
        $rowexcel = 1;
        foreach($csv_data['query'] as $row)
        {
            $no++;
            $rowexcel++;
            $phpExcel->getActiveSheet()->getStyle('A'.$rowexcel.':C'.$rowexcel)->applyFromArray($styleArray);
            $phpExcel->getActiveSheet()->getStyle('A'.$rowexcel.':C'.$rowexcel)->applyFromArray($styleArray1);
            $prestasi->setCellValue('A'.$rowexcel, $no);
            $prestasi->setCellValue('B'.$rowexcel, $row["Class"]);
            $prestasi->setCellValue('C'.$rowexcel, $row["Section"]);
            $prestasi->setCellValue('D'.$rowexcel, $row["Medium"]);
            $prestasi->setCellValue('E'.$rowexcel, $row["Exam_Type"]);
            $prestasi->setCellValue('F'.$rowexcel, $row["Subject"]);
            $prestasi->setCellValue('G'.$rowexcel, $row["Subject_Type"]);
            $prestasi->setCellValue('H'.$rowexcel, $row["Student_Name"]);
            $prestasi->setCellValue('I'.$rowexcel, $row["Admission_No"]);
            $prestasi->setCellValue('J'.$rowexcel, $row["Roll_No"]);
            
            if(isset($data1['marks']) && ($data1['notebook']=='') && ($data1['subj_anrich']=='') && ($data1['practical']=='')){
                $prestasi->setCellValue('K'.$rowexcel, $row["Marks"]);
            }else{
                $prestasi->setCellValue('K'.$rowexcel, $row["Marks"]);
                $prestasi->setCellValue('L'.$rowexcel, $row["notebook_mark"]);
                $prestasi->setCellValue('M'.$rowexcel, $row["subj_enrich"]);
                $prestasi->setCellValue('N'.$rowexcel, $row["p_marks"]);
            }
        }
        //$prestasi->setTitle('Customer Report');
        
        $date =date('U');
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        
        //ob_end_clean();
        if(!is_dir('./high_marks_entry')){
            mkdir('./high_marks_entry');
        }
        
        $filename = "high_marks_entry/StudentMarksRecord_".$csv_data['query'][0]['Class']."_".$csv_data['query'][0]['Section']."_".$date.".xlsx";
        
        $objWriter->save($filename);
        $result = array(
            'file_name' => $filename,
            'file_path' =>$filename
        );
        //print_r($filename); die;
        // 	       $this->load->helper('download');
        // 	       force_download('./'.$filename, NULL);
        return $filename;
        
    }// end of csv download function...
    
    
    
    
    
    
    
    
    
    
    
    
    function compart_marks_entry_high_class(){
    	$data['session'] = (int)$this->Admin_model->current_session();
    	$data['school_id'] = (int)$this->session->userdata('school_id');
    	$data['class'] = (int)$this->input->post('class');
    	$data['section'] = (int)$this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['e_type'] = (int)$this->input->post('e_type');
    	$data['s_group'] = $this->input->post('s_group');
    	$data['elective'] = (int)$this->input->post('elective');
    	$data['subject'] = (int)$this->input->post('subject');
    	$data['s_marks'] = $this->input->post('s_marks');
    	
    	$this->db->trans_begin();
    	foreach($data['s_marks'] as $mrk){
    		$this->db->where(array('medium'=>$data['medium'],
    				'class'=>$data['class'],
    				'section'=>$data['section'],
    				'school'=>$data['school_id'],
    				'student_id'=>$mrk['s_id'],
    				'subject' => $data['subject']
    		));
    		$this->db->update('class_ix_compartment',array('n_marks'=>$mrk['val']));
    	}
    	
    	if ($this->db->trans_status() === FALSE) {
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'something went wrong.','status'=>500));
    	}
    	else{
    		$this->db->trans_commit();
    		echo json_encode(array('msg'=>'student marks submitted successfully.','status'=>200));
    	}
    }
    
    function advance_search(){
    	if($this->input->post('string') != ''){
    		$data['search_text'] = $this->input->post('string');
    		$data['session'] = $this->Admin_model->current_session();
    	}
    	$data['school'] = $this->session->userdata('school_id');
    	$this->db->select('s.class_id,s.medium,s.fit,s.height,s.weight,s.email_id,s.guardian,s.local_address,s.medical,s.tc,s.subject_group,s.elective,s.s_id,s.photo,s.aadhar,s.name,s.roll_no,s.admission_no,s.father_name,s.mother_name,s.gender,s.address,s.contact_no,s.house,s.hostler,s.blood_group,s.cast,DATE_FORMAT(s.dob, "%d-%m-%Y") dob,DATE_FORMAT(s.admission_date, "%d-%m-%Y") admission_date,c.name as cname,sec.name as secname,sub.name as sub_name');
    	$this->db->join('class c','c.c_id = s.class_id');
    	$this->db->join('section sec','sec.id = s.section');
    	$this->db->join('subject sub','sub.sub_id = s.elective','left');
    	
    	if($this->input->post('string') != ''){
    		$this->db->where("(s.admission_no LIKE '%".$data['search_text']."%' OR s.name LIKE '%".$data['search_text']."%')");
    	
    	}
    	$this->db->order_bY('s.roll_no','asc');
    	$result = $this->db->get_where('student s',array('s.school_id'=>$data['school'],'s.session'=>$data['session'],'s.status'=>1))->result_array();
    		


$result_1 = array();
		foreach($result as $r){
			$temp = array();
if($data['school'] == 1){
   $school = 'shakuntala';
}
else{
   $school = 'sharda';
}

$path = base_url().'photos/students/'.$school.'/'.$r['admission_no'].'.jpg'; 

if (file_get_contents($path)) {
				$temp = $r;
				$temp['photo'] =  $r['admission_no'].'.jpg';
			}
else {
				$temp = $r;
				$temp['photo'] =  $r['admission_no'].'.JPG';
			}
                       //else{
                         // $temp = $r;
                 	  //$temp['photo'] =  '1.jpg';
                      // }
			$result_1[] = $temp;	
		}
		$result = $result_1;


    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'msg'=>'All Student Record','status'=>200));
    	}
    	else{
    		echo json_encode(array('msg'=>'No Record Found.','status'=>500));
    	}
    }
    
    function final_fard(){
    	$data['class_id'] = $this->input->post('c_id');
    	$data['section'] = $this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['school_id'] = $this->session->userdata('school_id');
    	$data['session'] = $this->input->post('session');
    	$result = $this->Student_model->final_fard($data);
    	if(count($result) > 0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }
    
    function term2_fard(){
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('c_id');
    	$data['section_id'] = $this->input->post('section');
    	$data['school'] = $this->session->userdata('school_id');
    	$data['session'] = $this->input->post('session');
    	$data['type'] = 'final';
    	$date = date('d-m-Y');
    	$result = $this->Student_model->term2_fard($data);
    	
    	if(count($result) > 0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }
    
    function final_fard_1_8(){
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('c_id');
    	$data['section_id'] = $this->input->post('section');
    	$data['school'] = $this->session->userdata('school_id');
    	$data['session'] = $this->Admin_model->current_session();
    	if($data['class_id'] == 12){
    		$result = $this->Result_model->student_final_result_ninth_loop($data);
    		////////////////////////////////////new changes//////////////////////////////
    			foreach($result as $r){
    				$t2 = array();
    				$t2['student'][] = $r['student'][0];
    				$marks = array();
    				$back = array();
    				$preiodic_total = 0;
    				$notebook_total = 0;
    				$sub_ench_total = 0;
    				$session_end_total = 0;
    				$fit = 0;
    				foreach($r['marks'] as $mm){
    					if($mm['sub_name'] == 'FIT'){
    						$fit = 1;
    						$temp = $mm;
    						$temp['annualsub_total'] = $mm['annual_mark'] + $mm['practical'];
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
    						$preiodic_total = $preiodic_total + $mm['priodic'] + $mm['extra'];
    						$notebook_total = $notebook_total + $mm['notebook'];
    						$sub_ench_total = $sub_ench_total + $mm['subjenrich'];
    						$session_end_total = $session_end_total + $mm['annual_mark'];
    						
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
    				$t2['marks'] = $marks;
    				$t2['back'] = $back;
    				$t2['preodic_total'] = $preiodic_total;
    				$t2['notebook_total'] = $notebook_total;
    				$t2['sub_ench_total'] = $sub_ench_total;
    				$t2['session_end_total'] = $session_end_total;
    				$t2['aggrigate'] = $preiodic_total + $notebook_total + $sub_ench_total + $session_end_total;
    				if($fit){
    					$total_marks = ((count($marks) - 1)*10) + ((count($marks) - 1)*5) + ((count($marks) - 1)*5)+ ((count($marks) - 1)*80);  
    				}
    				else{
    					$total_marks = (count($marks) * 10) + (count($marks) * 5) + (count($marks) * 5)+ (count($marks) * 80);
    				}
    				$t2['percent'] = (($t2['aggrigate'] * 100)/ $total_marks); 
    				
    					if(isset($t2['back'])){
    						if(count($t2['back'])>0){
    							$t2['result'] = 'Compart';
    						}
    						else{
	    						$t2['result'] = 'Pass';
    						}
    				}
    				else{
    					$t2['result'] = 'Fail';
    				}
    				
    				if(ceil($t2['percent']) > 59){
    					$t2['div'] = '1st';
    				}
    				else if(ceil($t2['percent']) > 45 && ceil($t2['percent']) < 60){
    					$t2['div'] = '2nd';
    				}
    				else if(ceil($t2['percent']) > 33 && ceil($t2['percent']) < 46){
    					$t2['div'] = '3rd';
    				}
    				else{
    					$t2['div'] = 'Fail';
    				}
    				$fnl_array[] = $t2;
    			}
    			
    			$pass_list = array();
    			foreach ($fnl_array as $f){
    				if($f['result'] == 'Pass'){
    					$pass_list[] = $f;
    				}
    				else{
    					
    				}
    			}
    			
    			$topper_list = $pass_list;
    			
    			$toppers = array();
    			foreach ($topper_list as $key => $row){
    				if(isset($row['aggrigate'])){
    					$toppers[$key] = $row['aggrigate'];
    				}
    				else{
    					$toppers[$key] = 0;
    				}
    			}
    			array_multisort($toppers, SORT_DESC, $topper_list);
    			
    			$fnl1_array = array();
    			foreach ($fnl_array as $ff){
    				$temp = array();
    				$f = 1;
    				$pre_marks = 0;
    				$c = 0;
    				foreach($topper_list as $key => $value){
    					if($ff['student'][0]['s_id'] == $value['student'][0]['s_id']){
    						$temp = $ff;
    						if($pre_marks < $value['aggrigate']){
    							$pre_marks = $value['aggrigate'];
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
    			$fnl1_array[] = $temp;
    			}
    			
    			if(count($fnl1_array) > 0){
    				echo json_encode(array('data'=>$fnl1_array,'status'=>200));
    			}
    			else{
    				echo json_encode(array('status'=>500));
    			}
    			die;
    			///////////////////////////////////////////////////////
    		}
			else{
				$result = $this->Result_model->final_result($data);
				$computer_marks = array();
    		
				foreach($result as $r){
					$temp = array();
					foreach($r['student_detail']['co_marks'] as $mm){
						foreach($r['student_deatil_final']['co_marks'] as $fm){
							$t = array();
							if($mm['sub_id'] == 22){
								if($mm['sub_id'] == $fm['sub_id']){
									if($mm['mark'] == 'A'){
										$t1['post'] = 5;
									}
									else if($mm['mark'] == 'B'){
										$t1['post'] = 4;
									}
									else if($mm['mark'] == 'C'){
										$t1['post'] = 3;
									}
									else if($mm['mark'] == 'D'){
										$t1['post'] = 2;
									}
									else if($mm['mark'] == 'E'){
										$t1['post'] = 1;
									}	
									else{
										$t1['post'] = 0;
									}
									//////////
									if($fm['mark'] == 'A'){
										$t1['final'] = 5;
									}
									else if($fm['mark'] == 'B'){
										$t1['final'] = 4;
									}
									else if($fm['mark'] == 'C'){
										$t1['final'] = 3;
									}
									else if($fm['mark'] == 'D'){
										$t1['final'] = 2;
									}
									else if($fm['mark'] == 'E'){
										$t1['final'] = 1;
									}
									else{
										$t1['final'] = 0;
									}
									
									$avg = ceil(($t1['post'] + $t1['final'])/2);
									if($avg == 5){
										$t['marks'] = 'A';
									}
									else if($avg == 4){
										$t1['marks'] = 'B';
									}
									else if($avg == 3){
										$t1['marks'] = 'C';
									}
									else if($avg == 2){
										$t1['marks'] = 'D';
									}
									else if($avg == 1){
										$t1['marks'] = 'E';
									}
									else{
										$t1['marks'] = '-';
									}
									$t['student_id'] = $mm['student_id'];
									$temp = $t;
								}
							}
						}
					}
					$computer_marks[] = $temp;
				}
	    		
				$final_array = array();
				foreach($result as $r){
					$temp = array();
					foreach($r['student_detail']['marks'] as $mm){
						foreach($r['student_deatil_final']['marks'] as $fm){
							$t = array();
							if($mm['sub_id'] == $fm['sub_id']){
								$t['sub_id'] = $mm['sub_id'];
								$t['name'] = $mm['name'];
								if($mm['pre_mark'] != 'A'){
									$t['pre_mark'] = round((($mm['pre_mark']/ 50) * 10),2);
								}
								else{
									$t['pre_mark'] = 'Abst';
								}
    					
								if($mm['mid_mark'] != 'A'){
									$t['mid_mark'] = $mm['mid_mark'];
								}
								else{
									$t['mid_mark'] = 'Abst';
								}
								$t['notebook_mark'] = $mm['notebook_mark'];
								$t['subj_enrich'] = $mm['subj_enrich'];
							
								if($fm['pre_mark'] != 'A'){
									$t['post_mark'] = round((($fm['pre_mark']/50) * 10),2);
								}
								else{
									$t['post_mark'] = 'Abst';
								}
								if($fm['mid_mark'] != 'A'){
									$t['final_mark'] = $fm['mid_mark'];
								}
								else{
									$t['final_mark'] = 'Abst';
								}
	    				
								$t['final_notebook_mark'] = $fm['notebook_mark'];
								$t['final_subj_enrich'] = $fm['subj_enrich'];
								$t['term_1_total'] = round(($t['pre_mark'] + $mm['notebook_mark'] + $mm['subj_enrich'] + $t['mid_mark']),2);
								$t['term_2_total'] = round(($t['post_mark'] + $fm['notebook_mark'] + $fm['subj_enrich'] + $t['final_mark']),2);
								$t['grand_total'] = $t['term_1_total'] + $t['term_2_total'];  
								
								if(($t['term_1_total'] + $t['term_2_total']) < 66){
									$t1 = array();
									$t1['sub_id'] = $mm['sub_id'];
									$t1['name'] = $mm['name'];
									$temp['back'][] = $t1;
								}
								$temp['marks'][] = $t;
							}
						}
						$temp['student'] = $r['student_detail']['student'];
					}
					$final_array[] = $temp;
				}
	    	
				$ffinal_array = array();
				foreach($final_array as $f){
					$temp = array();
					$temp = $f;
					$total = 0;
					foreach($f['marks'] as $m){
						$total = $total + $m['grand_total'];
					}
					$temp['G_total'] = $total;
					$ffinal_array[] = $temp;
				}
	    	
				$pass_list = array();
				foreach ($ffinal_array as $f){
					if(isset($f['back'])){
						
					}
					else{
						$pass_list[] = $f;
					}
				}
    		
				$topper_list = $pass_list;
	    	
				$toppers = array();
				foreach ($topper_list as $key => $row){
					if(isset($row['G_total'])){
						$toppers[$key] = $row['G_total'];
					}
					else{
						$toppers[$key] = 0;
					}
				}
				array_multisort($toppers, SORT_DESC, $topper_list);
	    	
				$fnl_array = array();
				foreach ($ffinal_array as $ff){
					$temp = array();
					$f = 1;
					$pre_marks = 0;
					$c = 0;
					foreach($topper_list as $key => $value){
						if($ff['student'][0]['s_id'] == $value['student'][0]['s_id']){
							$temp = $ff;
							if($pre_marks < $value['G_total']){
								$pre_marks = $value['G_total'];
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
					
					$outoff = ((((count($ff['marks'])*100)))*2);
					$temp['outoff'] = $outoff; 
					if(ceil((ceil($ff['G_total']) * 100)/$outoff) > 32){
						$temp['result'] = 'Pass';
					}
					else{
						$temp['result'] = 'Fail';
					}
					$temp['percent'] = round((($ff['G_total'] * 100)/$outoff),2);
				
					if(ceil($temp['percent']) > 59){
						$temp['div'] = '1st';
					}
					else if(ceil($temp['percent']) > 45 && ceil($temp['percent']) < 60){
						$temp['div'] = '2nd';
					}
					else if(ceil($temp['percent']) > 33 && ceil($temp['percent']) < 46){
						$temp['div'] = '3rd';
					}
					else{
						$temp['div'] = 'Fail';
					}
					$fnl_array[] = $temp;
				}
				
				$fnl_array_with_computer = array();
				foreach($fnl_array as $f){
					$temp = $f;
					foreach ($computer_marks as $cm){
						if($f['student'][0]['s_id'] == $cm['student_id']){
							$temp['computer'] = $cm['marks'];
							$fnl_array_with_computer[] = $temp;
						}
					}
				}
			}
    		
			if(count($fnl_array) > 0){
	    		echo json_encode(array('data'=>$fnl_array_with_computer,'status'=>200));
    		}
    		else{
	    		echo json_encode(array('status'=>500));
    		}
    	}
    	
    	function compart_student_list_marks(){
    		$data['medium'] = $this->input->post('medium');
    		$data['e_type'] = $this->input->post('e_type');
    		$data['class'] = $this->input->post('class');
    		$data['section'] = $this->input->post('section');
    		$data['term'] = $this->input->post('term');
    		$data['school'] = $this->session->userdata('school_id');
    		$data['subject'] = $this->input->post('subject');
    		$data['session'] = $this->Admin_model->current_session();
    		$data['elective'] =  $this->input->post('elective');
    		$data['subject_group'] =  $this->input->post('s_group');
    		$data['fit'] =  $this->input->post('fit');
    		$data['school_id'] = $this->session->userdata('school_id');
    		$power = $this->power();

    		$this->db->select('*');
    		$result = $this->db->get_where('subject',array('sub_id'=>$data['subject']))->result_array();
    		if($result[0]['subj_type'] == 'Elective'){
    			$data['elective'] = $result[0]['sub_id'];
    		}
    		$flag = 1;
    		if($power == 5){
    			$flag = 0;
    		}
    		else{
    			$school_id = $this->session->userdata('school_id');
    			$uid = $this->session->userdata('user_id');
    			$result = $this->Admin_model->get_teacher_id($uid);
    			$this->db->select('*');
    			$result = $this->db->get_where('class_teachers',array('school_id'=>$school_id,'class_id'=>$data['class'],'section'=>$data['section'],'medium'=>$data['medium'],'status'=>1,'teacher_id'=>$result[0]['t_id']))->result_array();
    			if(count($result)>0){
    				$flag = 0;
    			}
    			else{
    				$flag = 1;
    			}
    		}
    	
    		$this->db->select('s.*,c.name as cname,sec.name as secname,ixc.n_marks');
    		$this->db->join('class_ix_compartment ixc','ixc.student_id = s.s_id');
    		$this->db->join('class c','c.c_id = s.class_id');
    		$this->db->join('section sec','sec.id = s.section');
    			
    		if($data['elective'] != 0){
    			$this->db->where('elective',$data['elective']);
    		}
    		if($data['subject_group'] != '0'){
    			$this->db->where('subject_group',$data['subject_group']);
    		}
    		if($data['fit'] != '0'){
    			if($data['fit'] == 'yes'){
    				$this->db->where('fit',1);
    			}
    			else{
    				$this->db->where('fit',0);
    			}
    		}
    		$this->db->order_by('s.roll_no','asc');
    		$students = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.school_id'=>$data['school'],'s.status'=>1,'ixc.subject'=>$data['subject']))->result_array();
    	
    		$this->db->select('*');
    		$max_mark = $this->db->get_where('exam_type',array('e_id'=>$data['e_type'],'status'=>1))->result_array();
    		$max_mark = $max_mark[0]['max'];
    	
    		if($data['e_type'] == 9 && $data['fit'] == 'yes' && $data['subject'] == 13){
    			$max_mark = 40;
    			$prt_mark = 60;
    		}
    		$sub_type = 'Scholastic';
    		
    		$final = array();

    		if(count($students)>0){
    			if($data['subject'] == 13){
    				echo json_encode(array('data'=>$students,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'p_mark'=>$prt_mark,'s_type'=>$sub_type,'flag'=>0,'internal_marks'=>$internal_marks));
    			}
    			else{
    				echo json_encode(array('data'=>$students,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'s_type'=>$sub_type));
    			}
    		}
    		else{
    			echo json_encode(array('msg'=>'no record.','status'=>500));
    		}
    	}
    	
	}
