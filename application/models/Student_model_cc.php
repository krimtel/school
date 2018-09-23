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

	public function subject_list($class_id, $medium_id){
		$this->db->select('s.sub_id, s.sub_name, st.sub_type');
		$this->db->from('cc_subject s');
		$this->db->join('cc_subject_type st','st.id=s.sub_type','inner');
		$this->db->where('class_id', $class_id);
		$this->db->where('medium_id', $medium_id);
		return $this->db->get()->result_array();
		//print_r($this->db->last_query());die;
		
	}

	public function search_list($session_id, $school_id, $medium, $e_type, $class, $section, $subject){
	
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
			$this->db->select('sm.marks_id,sm.m_master_id,sm.student_id as s_id,sm.marks,sm.converted_mark,c.name as cname,sec.name as secname,st.sub_type as subtype, std.name as name, std.admission_no as admission_no, std.roll_no as roll_no');
			$this->db->from('cc_student_marks sm');
			$this->db->join('cc_mark_master mm', 'mm.id=sm.m_master_id', 'inner');
			$this->db->join('student std','std.s_id=sm.student_id', 'inner');
			$this->db->join('class c','c.c_id = mm.class_id', 'inner');
			$this->db->join('section sec','sec.id = mm.section_id', 'inner');
			$this->db->join('cc_subject sub','sub.sub_id = mm.subject_id', 'inner');
			$this->db->join('cc_subject_type st','st.id = sub.sub_type', 'inner');			
			$this->db->where('sm.m_master_id', $result[0]['id']);
			return $this->db->get()->result_array();
			//print_r($this->db->last_query());die;
		}else{
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
    		$this->db->trans_begin();
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
    	
    		foreach($std_marks as $mark){	
    		$data[] = array(
        					"m_master_id" => $lastid,
        					"student_id" => $mark['student_id'],
        					"marks" => $mark['val'],
                            "converted_mark" => $mark['con_marks'],
        					"created_by" => $mark['created_by'],
        					"created_at" => $mark['created_at'],
    			         );
    		      }	
    		
    		$this->db->insert_batch('cc_student_marks', $data); 
    		//print_r($this->db->last_query());	
    		    		
    		if ($this->db->trans_status() === FALSE){
            	$this->db->trans_rollback();
    			return 0;
    		}else{
            	$this->db->trans_commit();
    			return 1;
    		}
    }
    
    
    public function csv_export_model(){
        $last_id = $this->db->select('id')->order_by('id',"desc")->limit(1)->get('cc_mark_master')->result_array(); 
        $this->db->select('id');
        $this->db->from('cc_mark_master');
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $result = $this->db->get()->result_array();
        $last_id=$result[0]['id'];
       
        if($this->db->affected_rows() > 0){
            $this->db->select('c.name as Class, sec.name as Section, med.m_name as Medium, etype.et_name as Exam_Type, sub.sub_name as Subject, st.sub_type as Subject_Type, std.name as Student_Name, std.admission_no as Admission_No, std.roll_no as Roll_No, sm.Marks, sm.Converted_Mark');
            $this->db->from('cc_student_marks sm');
            $this->db->join('cc_mark_master mm', 'mm.id=sm.m_master_id', 'inner');
            $this->db->join('student std','std.s_id=sm.student_id', 'inner');
            $this->db->join('class c','c.c_id = mm.class_id', 'inner');
            $this->db->join('section sec','sec.id = mm.section_id', 'inner');
            $this->db->join('cc_subject sub','sub.sub_id = mm.subject_id', 'inner');
            $this->db->join('cc_subject_type st','st.id = sub.sub_type', 'inner');
            $this->db->join('cc_medium med','med.medium_id = mm.medium', 'inner');
            $this->db->join('cc_exam_type etype','etype.exam_type_id = mm.exam_type', 'inner');
            $this->db->where('sm.m_master_id', $last_id);
            return $this->db->get()->result_array();
             
        }
    }
    
    
    
    
    
}