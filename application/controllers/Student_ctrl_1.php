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


	function add_student() {
		$data['admission_no'] = $this->input->post('admission_no');
		$data['roll_no'] = $this->input->post('roll_no');
		$data['name'] = $this->input->post('student_name');
		$data['medium'] = $this->input->post('medium');
		$data['section'] = $this->input->post('section');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['father_name'] = $this->input->post('father_name');
		$data['mother_name'] = $this->input->post('mother_name');
		$data['dob'] = $this->input->post('dob');
		//$data['dob'] = date('Y-d-m',strtotime(str_replace('-', '/', $this->input->post('dob'))));
		$data['dob'] = date("Y-d-m", strtotime($data['dob']));

		$data['admission_date'] = $this->input->post('admission_date');
		$data['admission_date'] = date("Y-d-m", strtotime($data['admission_date']));
		//$data['admission_date'] = date('Y-d-m',strtotime(str_replace('-', '/', $this->input->post('admission_date'))));
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
			echo json_encode(array('status'=>200));
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
					$class = explode(" ",$a['Class']);
					if($class[0] == 'I'){
						$data['class_id'] = 4;
					}
					else if($class[0] == 'II'){
						$data['class_id'] = 5;
					}
					else if($class[0] == 'III'){
						$data['class_id'] = 6;
					}
					else if($class[0] == 'IV'){
						$data['class_id'] = 7;
					}
					else if($class[0] == 'V'){
						$data['class_id'] = 8;
					}
					else if($class[0] == 'VI'){
						$data['class_id'] = 9;
					}
					else if($class[0] == 'VII'){
						$data['class_id'] = 10;
					}
					else if($class[0] == 'VIII'){
						$data['class_id'] = 11;
					}
					else if($class[0] == 'IX'){
						$data['class_id'] = 12;
					}
					else if($class[0] == 'X'){
						$data['class_id'] = 13;
					}
					else if($class[0] == 'XI'){
						$data['class_id'] = 14;
					}
					else if($class[0] == 'XII'){
						$data['class_id'] = 15;
					}
					else if($class[0] == 'LKG'){
						$data['class_id'] = 2;
					}
					else if($class[0] == 'UKG'){
						$data['class_id'] = 3;
					}
					else if($class[0] == 'NURSERY'){
						$data['class_id'] = 1;
					}
						
					if($class[1] == 'A'){
						$data['section'] = 1;
					}
					else if($class[1] == 'B'){
						$data['section'] = 2;
					}
					else if($class[1] == 'C'){
						$data['section'] = 3;
					}
					else if($class[1] == 'D'){
						$data['section'] = 4;
					}
					else if($class[1] == 'E'){
						$data['section'] = 5;
					}
					else if($class[1] == 'F'){
						$data['section'] = 6;
					}
					else if($class[1] == 'G'){
						$data['section'] = 7;
					}
					else if($class[1] == 'H'){
						$data['section'] = 8;
					}
					else if($class[1] == 'I'){
						$data['section'] = 9;
					}
					else if($class[1] == 'J'){
						$data['section'] = 10;
					}
					else if($class[1] == 'K'){
						$data['section'] = 11;
					}
					else if($class[1] == 'L'){
						$data['section'] = 12;
					}
					else if($class[1] == 'M'){
						$data['section'] = 13;
					}
					if(isset($a['Subject_group'])){
						if($a['Subject_group'] == 'Maths'){
							$data['subject_group'] = 'Maths';
						}
						else if($a['Subject_group'] == 'BIO'){
							$data['subject_group'] = 'Boilogy';
						}
						else if($a['Subject_group'] == 'Commerce'){
							$data['subject_group'] = 'Commerce';
						}
						else if($a['Subject_group'] == 'Arts'){
							$data['subject_group'] = 'Arts';
						}
					}
					if(isset($a['elective subject'])){
						if($a['elective subject'] == 'CS'){
							$data['elective'] = 23;
						}
						else if($a['elective subject'] == 'Hindi'){
							$data['elective'] = 26;
						}
						else if($a['elective subject'] == 'PE'){
							$data['elective'] = 27;
						}
						else if($a['elective subject'] == 'Maths'){
							$data['elective'] = 28;
						}
					}
					if(isset($a['Fit'])){
						if($a['Fit'] == 'Yes'){
							$data['fit'] = 1;
						}
						else if($a['Fit'] == 'No'){
							$data['fit'] = 0;
						}
					}
					$data['admission_no'] = $a['Admission No'];
					$date1 = strtr($a['Admission Date'], '/', '-');
					$data['admission_date'] = date("Y-m-d", strtotime($date1));
					$data['roll_no'] = $a['Roll No'];
					$data['medium'] = $a['Medium'];
					$data['name'] = $a['Student Name'];
					$data['mother_name'] = $a['Mother Name'];
					$data['father_name'] = $a['Fathers Name'];
					$date1 = strtr($a['Date Of Birth'], '/', '-');
					$data['dob'] = date("Y-m-d", strtotime($date1));
					$data['gender'] = $a['Gender'];
					$data['address'] = $a['Address'];
					$data['contact_no'] = $a['Contact No'];
					$data['house'] = $a['House'];
					$data['aadhar'] = $a['Aadhar'];
					$data['hostler'] = $a['Hostler'];
					$data['blood_group'] = $a['Blood Group'];
					$data['cast'] = $a['Caste'];
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
		$students = $this->db->get_where('student s',array('s.medium'=>$data['medium'],'s.class_id'=>$data['class'],'s.section'=>$data['section'],'s.school_id'=>$data['school'],'s.status'=>1))->result_array();
		
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
				echo json_encode(array('data'=>$students,'msg'=>'all record.','status'=>200,'max'=>$max_mark,'s_type'=>$sub_type,'internal_marks'=>$internal_marks));
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
	    $result = $this->Result_model->final_result($data);
	    if(count($result)>0){
	        echo json_encode(array('data'=>$result,'msg'=>'all record','status'=>200,'date'=>$date));
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
		    					if($smarks['s_id'] == $pmarks['s_id'] && $smarks['s_id'] == $amarks['s_id']){
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
		    					}
		    					else{
		    						continue;
		    					}
		    					$val[] = $temp;
	    					}
	    				}
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
    
    	/*if($update){
	    	$log_info = array(
	    			'eventid' => 19, //event id
	    			'event_by' => $this->session->userdata('user_id'),
	    			'school_id' => $this->session->userdata('school_id'),
	    			'session_id' => $this->Admin_model->current_session(),
	    			'subject_id' => $data['subject_id'],
	    			'class_id' => $data['class_id'],
	    			'section_id' => $data['section_id'],
	    			'term' => $data['e_type'],
	    			'medium' => $data['medium'],
	    			'ip'=> $this->input->ip_address(),
	    			'logtime'=>date('Y-m-d H:i:s')
	    	);
    	}
    	else{
    		$log_info = array(
    				'eventid' => 8, //event id
    				'event_by' => $this->session->userdata('user_id'),
    				'school_id' => $this->session->userdata('school_id'),
    				'session_id' => $this->Admin_model->current_session(),
    				'subject_id' => $data['subject_id'],
    				'class_id' => $data['class_id'],
    				'section_id' => $data['section_id'],
    				'term' => $data['e_type'],
    				'medium' => $data['medium'],
    				'ip'=> $this->input->ip_address(),
    				'logtime'=>date('Y-m-d H:i:s')
    		);
    	}*/
    	//$this->db->insert('log_tab',$log_info);
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
    	$data['class_id'] = $this->input->post('c_id');
    	$data['section'] = $this->input->post('section');
    	$data['medium'] = $this->input->post('medium');
    	$data['school_id'] = $this->session->userdata('school_id');
    	$data['session'] = $this->input->post('session');
    	$result = $this->Student_model->term2_fard($data);
    	if(count($result) > 0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }
}
