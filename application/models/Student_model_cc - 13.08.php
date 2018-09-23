<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model_cc extends CI_Model {
	
	public function medium_list(){
		$this->db->select('*');
		$result = $this->db->get_where('cc_medium')->result_array();
		return $result;
	}

	public function exam_type_list(){
		$this->db->select('*');
		$result = $this->db->get_where('cc_exam_type')->result_array();
		return $result;
	}

	public function class_list(){
				$this->db->select('*');
				$this->db->limit('11');
		$result = $this->db->get_where('class')->result_array();
		return $result;
	}

	public function section_list(){
		$this->db->select('*');
		$result = $this->db->get_where('section')->result_array();
		return $result;
	}

	public function subject_list(){
		$this->db->select('*');
		$result = $this->db->get_where('cc_subject')->result_array();
		return $result;
	}

	public function search_list($school_id, $medium, $e_type, $class, $section, $subject){
		$this->db->select('s.*,c.name as cname,sec.name as secname,sub.sub_type as subtype');
		$this->db->from('student s');
		$this->db->join('class c','c.c_id = s.class_id', 'inner');
		$this->db->join('section sec','sec.id = s.section', 'inner');
		$this->db->join('cc_subject sub','sub.class_id = s.class_id', 'inner');
		$this->db->where('s.school_id', $school_id);
		$this->db->where('s.medium', $medium);
		$this->db->where('s.class_id', $class);
		$this->db->where('s.section', $section);
		$this->db->where('sub.sub_id', $subject);
		return $this->db->get()->result_array();
		
	}

		public function marks_entry($std_marks){		
		
		$mark_update = array(
    			'session_id'=> $std_marks[0]['session_id'],
    			'school_id' => $std_marks[0]['school_id'],
				'class_id' => $std_marks[0]['class'],
				'section_id' => $std_marks[0]['section'],
				'medium'=> $std_marks[0]['medium'],
				'exam_type'=> $std_marks[0]['e_type'],
    			'subject_id' => $std_marks[0]['subject'],	
    			'created_by' => $std_marks[0]['created_by'],
    			'created_at' => $std_marks[0]['created_at'],
				'status' => 0
    	);
		$mark_insert = array(
    			'session_id'=> $std_marks[0]['session_id'],
    			'school_id' => $std_marks[0]['school_id'],
				'class_id' => $std_marks[0]['class'],
				'section_id' => $std_marks[0]['section'],
				'medium'=> $std_marks[0]['medium'],
				'exam_type'=> $std_marks[0]['e_type'],
    			'subject_id' => $std_marks[0]['subject'],	
    			'created_by' => $std_marks[0]['created_by'],
    			'created_at' => $std_marks[0]['created_at'],
				'status' => 1
    	);
		if($std_marks[0]['status']==1){
			$this->db->where('id', $std_marks[0]['m_tbl_id']);
			$this->db->update('cc_mark_master', $mark_update);
			
			$this->db->insert('cc_mark_master',$mark_insert);
			$lastid = $this->db->insert_id();
		}else{
			$this->db->insert('cc_mark_master',$mark_insert);
			$lastid = $this->db->insert_id();
			//print_r($this->db->last_query()); die;
			
		}
	
		foreach($std_marks as $mark)
		{	
		$data[] = array(
					
					"m_master_id" => $lastid,
					"student_id" => $mark['student_id'],
					"marks" => $mark['val'],
                    "converted_mark" => $mark['con_marks'],
					"created_by" => $mark['created_by'],
					"created_at" => $mark['created_at'],
			);
		}	
		
		return $this->db->insert_batch('cc_student_marks', $data); 
		//print_r($this->db->last_query());	
	}
}