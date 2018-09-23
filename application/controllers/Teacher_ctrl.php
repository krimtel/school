<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ctrl extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
		$this->load->model(array('Admin_model','Teacher_model'));
    }
    
    function add_teacher() {
    	$t_id = $this->input->post('t_id');
    	$data['name'] = $this->input->post('name');
    	$data['gender'] = $this->input->post('gender');
    	$data['school_id'] = $this->session->userdata('school_id');
    	$school = strtolower($this->session->userdata('school'));
    	$data['email'] = $this->input->post('email');
    	$data['address'] = $this->input->post('address');
    	$data['phone'] = $this->input->post('phone');
    	$data['dob'] = $this->input->post('dob');
    	$data['dob'] = date("Y-m-d", strtotime($data['dob']));
    	$data['qualification'] = $this->input->post('qualif');
    	$data['designation'] = $this->input->post('design');
    	$data['ip'] =  $this->input->ip_address();
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d H:i:s');
  
    	$this->db->trans_begin();
    	$bulk_images = array();
    	if(isset($_FILES['userFiles'])){
    	
    	$filesCount = count($_FILES['userFiles']['name']);
	    	for($i = 0; $i < $filesCount; $i++){
	    		$file_name = $_FILES['userFiles']['name'][$i];
	    			
	    		$ext = end((explode(".", $file_name)));
	    		$file_name = preg_replace('/\s+/', '_', $file_name);
	    		$_FILES['userFile']['name'] = $file_name;
	    		$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
	    		$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
	    		$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
	    		$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];
	    			
	    		$data['photo'] = $_FILES['userFile']['name'];
	    		$uploadPath = 'photos/teachers/'.$school;
	    	
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
    	if($t_id != ''){
    		$this->db->where('t_id',$t_id);
    		$this->db->update('teacher',$data);
    	}
    	else{
    		$this->db->insert('teacher',$data);
    	}
    	if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
    	}
    	else{
    		$this->db->trans_commit();
    		echo json_encode(array('status'=>200));
    	}
    }
    
    function add_teacher_csv(){
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
    			foreach($csv_array as $a){    					
    					$data['name'] = $a['Teacher Name'];
						if(isset($a['Address'])){
							$data['address'] = $a['Address'];
						}
						if(isset($a['Contact No'])){
							$data['phone'] = $a['Contact No'];
    					}
						if(isset($a['DOB'])){
							$date1 = strtr($a['DOB'], '/', '-');
							$data['dob'] = date("Y-m-d", strtotime($date1));
						}
						if(isset($a['Qualification'])){
							$data['qualification'] = $a['Qualification'];
						}
						if(isset($a['Designation'])){
							$data['designation'] = $a['Designation'];
						}
						
						$data['school_id'] = $this->session->userdata('school_id');
    					$data['created_at'] = date('Y-m-d');
    					$data['created_by'] = $this->session->userdata('user_id');
    					$data['ip'] = $this->input->ip_address();
    					$bunch[] = $data;
    				}
    			$this->db->insert_batch('teacher',$bunch);
    			}
    		}
    	echo json_encode(array('status'=>200));
    }

    public function update_t_profile(){
    	$id = $this->input->post('id');
    	$temp['name'] = $this->input->post('name');
    	$temp['gender'] = $this->input->post('gender');
    	$temp['email'] = $this->input->post('email');
    	$temp['address'] = $this->input->post('address');
    	$temp['phone'] = $this->input->post('phone');
    	$dob= $this->input->post('dob');
    	$temp['dob'] = date("Y-m-d", strtotime($dob));
    	$temp['qualification'] = $this->input->post('qualif');
    	$temp['designation'] = $this->input->post('design');
    	$old_image = $this->input->post('old_image');
    	$temp['ip'] =  $this->input->ip_address();
    	$temp['created_by'] = $this->session->userdata('user_id');
    	$temp['created_at'] = date('Y-m-d H:i:s');
    
    	$school = strtolower($this->session->userdata('school'));
    	$target_dir  = './photos/teachers/'.$school.'/';
    	if(!empty($_FILES['userFile']['name'])){
    
    		if(!empty($old_image) && file_exists($target_dir.$old_image)){
    			unlink($target_dir.$old_image);
    		}
    		$imagename=$_FILES['userFile']['name'];
    		$ext=pathinfo($imagename,PATHINFO_EXTENSION);
    		$var_img_name=time().".".$ext;
    		$imgtemp=$_FILES['userFile']['tmp_name'];
    		$target_file = $target_dir.basename($_FILES['userFile']['name']);
    		move_uploaded_file($imgtemp,$target_dir.$var_img_name);
    		$temp['photo']=$var_img_name;
    	}
    	//--------------------------------------------------------------
    
    	if(empty($_FILES['userFile']['name']))
    	{
    		$temp['photo']=$old_image;
    	}
    	$this->db->trans_begin();
    
    	$this->db->where('t_id',$id);
    	$this->db->update('teacher' ,$temp);
    
    	if ($this->db->trans_status() === FALSE)
    	{
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'Updation Failed', 'status'=>500));
    	}
    	else
    	{
    		$this->db->trans_commit();
    		echo json_encode(array('msg'=>'Update Successfully.','status'=>200));
    	}
    
    }
    
    public function update_t_pass(){
    	$id = $this->input->post('users_id');
    	$old_pass = $this->input->post('old_pass');
    	$password = $this->input->post('confirm_pass');
    
    	$this->db->select('password');
    	$result = $this->db->get_where('users', array('uid'=> $id))->result_array();
    	$db_pass = $result[0]['password'];
    
    	if($old_pass == $db_pass){
    		$this->db->trans_begin();
    		$this->db->where('uid', $id);
    		$this->db->set('password', $password);
    		$this->db->update('users');
    
    		if ($this->db->trans_status() === FALSE)
    		{
    			$this->db->trans_rollback();
    			echo json_encode(array('msg'=>'Updation Failed', 'status'=>500));
    		}else
    		{
    			$this->db->trans_commit();
    			echo json_encode(array('msg'=>'Update Successfully.','status'=>200));
    		}
    	}else{
    		echo json_encode(array('msg'=>'Old Password not match.', 'status'=>500));
    	}
    
    
    }
    
    function alloated_subjects(){
    	$school_id = $this->session->userdata('school_id');
    	$this->db->select('sa.*,t.name as t_name,c.name as c_name,s.name as s_name,sec.name as sec_name,GROUP_CONCAT(s.name) as subjects');
    	$this->db->join('class c','c.c_id = sa.class_id');
    	$this->db->join('section sec','sec.id = sa.section_id');
    	$this->db->join('subject s','s.sub_id = sa.subject_id');
    	$this->db->join('teacher t','t.t_id = sa.teacher_id');
    	$this->db->group_by('sa.teacher_id,sa.class_id,sa.section_id,sa.medium');
    	$this->db->order_by('t.name','asc');
    	$this->db->where_not_in('c.c_id',array('14','15'));
    	$result = $this->db->get_where('subject_allocation sa',array('t.school_id'=>$school_id,'sa.status'=>1))->result_array();
    	
    	$this->db->select('sa.*,t.name as t_name,c.name as c_name,s.subject as s_name,sec.name as sec_name,GROUP_CONCAT(s.subject) as subjects');
    	$this->db->join('class c','c.c_id = sa.class_id');
    	$this->db->join('section sec','sec.id = sa.section_id');
    	$this->db->join('subjects_11_12 s','s.id = sa.subject_id');
    	$this->db->join('teacher t','t.t_id = sa.teacher_id');
    	$this->db->group_by('sa.teacher_id,sa.class_id,sa.section_id,sa.medium,sa.s_group');
    	$this->db->order_by('t.name','asc');
    	$this->db->where_in('c.c_id',array('14','15'));
    	$result_high_class = $this->db->get_where('subject_allocation sa',array('t.school_id'=>$school_id,'sa.status'=>1))->result_array();
    	//print_r($this->db->last_query()); die;
    	// marge arrays
    	$result = array_merge($result,$result_high_class);    	
    	
    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    }
    
    function teacher_detail(){
    	$data['teacher_id'] = $this->input->post('t_id');
    	
    	$this->db->select('*');
    	$result = $this->db->get_where('teacher',array('t_id'=>$data['teacher_id']))->result_array();
    	if(count($result) > 0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }

	function add_user(){
		$data['t_id'] = $this->input->post('teacher');
		$data['uname'] = $this->input->post('uname');
		$data['password'] = $this->input->post('password');
		$data['ip'] = $this->input->ip_address();
		$data['created_date'] = date('Y-m-d h:i:s');
		$data['u_type'] = 'Teacher';
		$data['school_id'] = $this->session->userdata('school_id');
		$data1['s_entry'] = $this->input->post('student_entry');
		$data1['m_entry'] = $this->input->post('marks_entry');
		
		$permission = array();
    	$text = '0';
    	if($data1['s_entry'] || $data1['m_entry']){
    		if($data1['s_entry']){
    			$text  =  $text.','.'1';
    		}
    		if($data1['m_entry']){
    			$text  =  $text.','.'2';
    		}
    	}
		
		$this->db->trans_begin();
			$result = $this->db->get_where('users',array('t_id'=>$data['t_id'],'status'=>1))->result_array();

			if(count($result)>0){
				$this->db->where('uid',$result[0]['uid']);
				$this->db->update('users',array('uname'=>$data['uname'],'password'=>$data['password']));
				
				$permission_result = $this->db->get_where('user_permission',array('user_id'=>$result[0]['uid']))->result_array();
				if(count($permission_result)>0){
					$this->db->where('user_id',$result[0]['uid']);
					$this->db->update('user_permission',array('permission'=>$text));
				}
				else{
					$permission['user_id'] = $result[0]['uid'];
					$permission['permission'] = $text;
					$this->db->insert('user_permission',$permission);
				}
				
			}else{
				$this->db->insert('users',$data);
				
				$x = $this->db->insert_id();
				$permission['user_id'] = $x;
				$permission['permission'] = $text;
				
				$this->db->insert('user_permission',$permission);
				
			}
			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			echo json_encode(array('msg'=>'user  added successfully.','status'=>200));
		}
	}
	
	function teacher_abstract(){
		$u_id = $this->session->userdata('user_id');
		$result = $this->Admin_model->get_teacher_id($u_id);
		$t_id = $result[0]['t_id']; 
		 
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['medium'] = $this->input->post('medium');
		$data['session'] = $this->Admin_model->current_session();
		$data['type'] = $this->input->post('type');
		
		$detail = $this->db->query("select c.name as cname,s.name as secname from class c,section s where c.c_id =".$data['class'] ." AND s.id =". $data['section'])->result_array();
		$detail['school_id'] = $data['school_id'];
		
		if($this->session->userdata('utype') == 'Teacher'){
			$this->db->select('*');
			$result = $this->db->get_where('class_teachers',array('school_id'=>$data['school_id'],'class_id' => $data['class'],'section' => $data['section'],'medium' => $data['medium'],'teacher_id' => $t_id))->result_array();
			if(count($result)>0){
				$result = $this->Teacher_model->teacher_abstract($data);
			}
			else{
				$data['teacher_id'] = $t_id;
				$result = $this->Teacher_model->teacher_abstract_teacher($data);
			}
		}
		else{
			$result = $this->Teacher_model->teacher_abstract($data);
		}
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200,'detail'=>$detail));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function teacher_abstract_new(){
		$data['t_id'] = $this->input->post('t_id');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['medium'] = $this->input->post('medium');
		$data['session'] = $this->Admin_model->current_session();
		$data['e_type'] = $this->input->post('e_type');

		if($this->session->userdata('utype') == 'Teacher'){
			$result = $this->Teacher_model->teacher_abstract_new($data);
		}
		else{
			 $result = $this->Teacher_model->teacher_abstract_new($data);
		}
		$result1 = $this->Teacher_model->teacher_abstract_new_high_class($data);
		$result = array_merge($result,$result1);
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200,'school_id'=>$data['school_id']));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function teacher_delete(){
		$data['t_id'] = $this->input->post('t_id');
		$this->db->where('t_id',$data['t_id']);
		$this->db->update('teacher',array('status'=>0));
		echo json_encode(array('status'=>200));
	}

        function subject_delete(){
		$data['t_id'] = $this->input->post('teacher_id');
		$data['alloc_id'] = $this->input->post('alloc_id');
		$data['medium'] = $this->input->post('medium');
		$data['s_group'] = $this->input->post('s_group');
		$data['c_id'] = $this->input->post('c_id');
		$data['sec_id'] = $this->input->post('sec_id');
		$this->db->where(array(
		    'teacher_id'=>$data['t_id'],
		    'class_id' => $data['c_id'],
		    'section_id' => $data['sec_id'],
		    'medium' => $data['medium'],
		    's_group' => $data['s_group']
		      )
		   );
		if($this->db->update('subject_allocation',array('status'=>0))){
			echo json_encode(array('msg'=>'teacher subject allocation record deleted successfully.','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'something gone wrong. please contact to admin.','status'=>500));
		}
	}

       function teacher_alloated_subjects(){
		$data['t_id'] = $this->input->post('teacher_id');
		$school_id = $this->session->userdata('school_id');
		$this->db->select('sa.*,t.name as t_name,c.name as c_name,s.name as s_name,sec.name as sec_name,GROUP_CONCAT(s.name) as subjects');
		$this->db->join('class c','c.c_id = sa.class_id');
		$this->db->join('section sec','sec.id = sa.section_id');
		$this->db->join('subject s','s.sub_id = sa.subject_id');
		$this->db->join('teacher t','t.t_id = sa.teacher_id');
		$this->db->where_not_in('c.c_id',array('14','15'));
		$this->db->group_by('sa.teacher_id,sa.class_id,sa.section_id');
		$result = $this->db->get_where('subject_allocation sa',array('t.t_id'=>$data['t_id'],'t.school_id'=>$school_id,'sa.status'=>1))->result_array();
		
		$this->db->select('sa.*,t.name as t_name,c.name as c_name,s.subject as s_name,sec.name as sec_name,GROUP_CONCAT(s.subject) as subjects');
		$this->db->join('class c','c.c_id = sa.class_id');
		$this->db->join('section sec','sec.id = sa.section_id');
		$this->db->join('subjects_11_12 s','s.id = sa.subject_id');
		$this->db->join('teacher t','t.t_id = sa.teacher_id');
		$this->db->group_by('sa.teacher_id,sa.class_id,sa.section_id,sa.medium,sa.s_group');
		$this->db->order_by('t.name','asc');
		$this->db->where_in('c.c_id',array('14','15'));
		$result_high_class = $this->db->get_where('subject_allocation sa',array('t.t_id'=>$data['t_id'],'t.school_id'=>$school_id,'sa.status'=>1))->result_array();
		
		// marge arrays
		$result = array_merge($result,$result_high_class);
	
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'status'=>200));
		}
                else{
			echo json_encode(array('msg'=>'No record found.','status'=>500));
		}
	}
	
	function class_teacher(){
		$data['teacher_id'] = $this->input->post('t_id');
		$data['class_id'] = $this->input->post('class_id');
		$data['section'] = $this->input->post('section');
		$data['medium'] = $this->input->post('medium');
		$data['school_id'] = $this->session->userdata('school_id');
		$f = 1;
		$session = $this->Admin_model->current_session();
		$data['session'] = $session; 
		
		$this->db->select('*');
		$result = $this->db->get_where('class_teachers',array('teacher_id'=>$data['teacher_id'],'medium'=>$data['medium'],'status'=>1))->result_array();
		
		if(count($result)>0){
			$f = 0;
			$this->db->where('id',$result[0]['id']);
			$this->db->delete('class_teachers');
		
			if($this->db->insert('class_teachers',$data)){
				$x = $this->db->insert_id();
				
				$this->db->select('ct.id,c.name cname,c.c_id,t.t_id,t.name,s.name as sname');
				$this->db->join('class c','c.c_id = ct.class_id');
				$this->db->join('teacher t','t.t_id = ct.teacher_id');
				$this->db->join('section s','s.id = ct.section');
				$result = $this->db->get_where('class_teachers ct',array('ct.id'=>$x))->result_array();
				
				if($f){
					echo json_encode(array('data'=>$result,'msg'=>'class teacher add sussesfully.','status'=>200));
				}
				else{
					echo json_encode(array('data'=>$result,'msg'=>'class teacher updated sussesfully.','status'=>300));
				}
			}
		}
		else{
			if($this->db->insert('class_teachers',$data)){
				$x = $this->db->insert_id();
			
				$this->db->select('ct.id,c.name cname,c.c_id,t.t_id,t.name,s.name as sname');
				$this->db->join('class c','c.c_id = ct.class_id');
				$this->db->join('teacher t','t.t_id = ct.teacher_id');
				$this->db->join('section s','s.id = ct.section');
				$result = $this->db->get_where('class_teachers ct',array('ct.id'=>$x))->result_array();
			
				if(count($result)>0){
					echo json_encode(array('data'=>$result,'msg'=>'class teacher add sussesfully.','status'=>200));
				}
				else{
					echo json_encode(array('msg'=>'some thing went wrong.','status'=>500));
				}
			}
		}
	}
	
	function class_teachers(){
		$result = $this->Admin_model->class_teachers();
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'all record','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No record.','status'=>500));
		}
	}
	
	function class_teacher_delete(){
		$data['t_id'] = $this->input->post('t_id');
		$this->db->where('teacher_id',$data['t_id']);
		$this->db->update('class_teachers',array('status'=>0));
		echo json_encode(array('msg'=>'deleted successfully.','status'=>200));
	}
	
	function class_teacher_detail(){
		$data['t_id'] = $this->input->post('t_id');
		$data['medium'] = $this->input->post('medium');

		$result = $this->db->get_where('class_teachers',array('teacher_id'=>$data['t_id'],'medium'=>$data['medium'],'status'=>1))->result_array();
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Teacher Record.','status'=>200));
		}
		else{
			echo json_encode(array('status'=>500));
		}
	}
	
// 	function class_detail(){
// 		$data['c_id'] = $this->input->post('c_id');
		
// 		$this->db->select('*');
// 		$result = $this->db->get_where('class_teachers',array('class_id'=>$data['c_id']))->result_array();
// 		if(count($result)>0){
// 			echo json_encode(array('data'=>$result,'status'=>200));
// 		}
// 		else{
// 			echo json_encode(array('status'=>500));
// 		}
// 	}

// 	function class_teacher_detail(){
// 		$data['t_id'] = $this->input->post('t_id');
// 		$this->db->select('*');
// 		$result = $this->db->get_where('class_teachers ct',array('teacher_id'=>$data['t_id']))->result_array();
// 		if(count($result)>0){
// 			echo json_encode(array('data'=>$result,'msg'=>'teacher detail','status'=>200));
// 		}
// 		else{
// 			echo json_encode(array('msg'=>'no record found','status'=>500));
// 		}
// 	}
}
