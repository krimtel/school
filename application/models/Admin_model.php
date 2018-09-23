<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	function session_list(){
		$this->db->select('*');
		$result = $this->db->get_where('session')->result_array();
		return $result;
	}

	function class_list(){
		$this->db->select('*');
		$result = $this->db->get_where('class')->result_array();
		return $result;
	}

	function subjects(){
		$this->db->select('*');
		$result = $this->db->get_where('subject')->result_array();
		return $result;
	}

	function classes(){
		$this->db->select('*');
		$result = $this->db->get_where('class',array('status'=>1))->result_array();
		return $result;
	}

	function teachers(){
		$this->db->select('*');
		$this->db->where('school_id',$this->session->userdata('school_id'));
		$this->db->order_by('name','asc');
		$result = $this->db->get_where('teacher',array('status'=>1))->result_array();
		return $result;
	}

	function sections(){
		$this->db->select('*');
		$result = $this->db->get_where('section',array('status'=>1))->result_array();
		return $result;
	}

	function current_session(){
		$this->db->select('session_id');
		$result = $this->db->get_where('session',array('status'=>1))->result_array();
		return $result[0]['session_id'];
	}

	function dashboard_stuff(){
		$school_id = $this->session->userdata('school_id');

		$this->db->select('count(*) as student');
		$data['student'] = $this->db->get_where('student',array('school_id'=>$school_id,'status'=>1))->result_array();
		$data['student'] = $data['student'][0]['student'];

		$this->db->select('count(*) as teacher');
		$data['teacher'] = $this->db->get_where('teacher',array('school_id'=>$school_id,'status'=>1))->result_array();
		$data['teacher'] = $data['teacher'][0]['teacher'];
		return $data;
	}



	function users(){
		$school_id = $this->session->userdata('school_id');
		$this->db->select('t.*,up.permission,u.uid,u.uname,u.password');
		$this->db->join('users u','u.t_id = t.t_id');
		$this->db->join('user_permission up','up.user_id = u.uid');
		$this->db->order_by('t.name','asc');
		$result = $this->db->get_where('teacher t',array('t.status'=>1,'u.school_id'=>$school_id,'t.school_id'=>$school_id))->result_array();
		//print_r($result); die;
		return $result;
	}

	function class_subject(){
		$this->db->select('cs.*,s.name,s.subj_type,c.name as cname');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$this->db->join('class c','c.c_id = cs.class_id');
		$this->db->order_by('cs.class_id');
		$subjects = $this->db->get_where('class_sujects cs',array('cs.status'=>1))->result_array();


		$final = array();
		$classes = array();
		foreach($subjects as $subject){
			array_push($classes,$subject['class_id']);
		}
		$classes = array_unique($classes);

		foreach($classes as $class){
			$temp1 = array();
			foreach($subjects as $subject){
				$temp = array();
				if($class == $subject['class_id']){
					$temp['id'] = $subject['subject_id'];
					$temp['name'] = $subject['name'];
					$temp['type'] = $subject['subj_type'];
				}
				else{
					continue;
				}
				$temp1[] = $temp;
			}
				
			foreach($subjects as $subject){
				$temp = array();
				if($class == $subject['class_id']){
					$temp['subjects'] = $temp1;
					$temp['c_id'] = $class;
					$temp['cname'] = $subject['cname'];
					$temp['type'] = $subject['subj_type'];
					$final[] = $temp;
					break;
				}
			}
		}
		return $final;
	}

	function e_type(){
		$this->db->select('*');
		$result = $this->db->get_where('exam_type',array('status'=>1))->result_array();
		return $result;
	}

	function teacher_classes(){
		$result = $this->db->get_where('users',array('uid'=>$this->session->userdata('user_id')))->result_array();
		$t_id = $result[0]['t_id'];
		$result = $this->db->query('select * from class where status = 1 AND c_id in(select class_id from subject_allocation where teacher_id = '.$t_id.' group by class_id)')->result_array();
		return $result;
	}
	
	function teacher_classes_high_class(){
		$result = $this->db->get_where('users',array('uid'=>$this->session->userdata('user_id')))->result_array();
		$t_id = $result[0]['t_id'];
		$result = $this->db->query('select * from class where status = 1 AND c_id in(select class_id from subject_allocation where teacher_id = '.$t_id.' AND c_id in (14,15) group by class_id)')->result_array();
		return $result;
	}

	function sessions(){
		$result = $this->db->get_where('session')->result_array();
		return $result;
	}

	function elective_subjects(){
		$result = $this->db->get_where('subject',array('subj_type'=>'Elective'))->result_array();
		if(count($result)>0){
			return $result;
		}
	}

	function class_teachers(){
		$school_id = $this->session->userdata('school_id');

		$this->db->select('ct.id,c.name cname,c.c_id,t.t_id,t.name,s.name as sname,ct.medium');
		$this->db->join('class c','c.c_id = ct.class_id');
		$this->db->join('teacher t','t.t_id = ct.teacher_id');
		$this->db->join('section s','s.id = ct.section');
		$result = $this->db->get_where('class_teachers ct',array('t.school_id'=>$school_id,'ct.status'=>1))->result_array();
		return $result;
	}

	function session_days(){
		$school_id = $this->session->userdata('school_id');
		$this->db->select('sa.*,s.name');
		$this->db->join('session s','s.session_id = sa.session');
		$result = $this->db->get_where('session_attendance sa',array('sa.school_id'=>$school_id,'sa.status'=>1))->result_array();
		return $result;
	}
	
	function get_teacher_id($uid){
		$this->db->select('t_id');
		return $result = $this->db->get_where('users',array('uid'=>$uid,'status'=>1))->result_array();
	}
	
	function users_list(){
		$school_id = $this->session->userdata('school_id');
		$this->db->select('*');
		$result = $this->db->get_where('users',array('school_id'=>$school_id,'status'=>1))->result_array();
		return $result;
	}
	
	function class_teacher(){
		$u_id = $this->session->userdata('user_id');
		$school_id = $this->session->userdata('school_id');
		$result = $this->get_teacher_id($u_id);
		$t_id = $result[0]['t_id']; 
		
		$this->db->select('c.*');
		$this->db->join('class c','c.c_id = ct.class_id');
		$result = $this->db->get_where('class_teachers ct',array('ct.school_id'=>$school_id,'ct.teacher_id'=>$t_id,'ct.status'=>1))->result_array();
		return $result;
	}
}