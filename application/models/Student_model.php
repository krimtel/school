<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->model(array('Teacher_model'));
	}
	
	function classwise_pre($data){
		$data2['class'] = $data['class_id'];
		$data2['section'] = $data['section'];
		$data2['medium'] = $data['medium'];
		$data2['school_id'] = $data['school_id'];
		$data2['session'] = $data['session'];
		$data2['fit'] = $data['fit'];
		$e_type = '';
		$term = '';
		switch($data['type']){
			case 'pre' :
				$e_type = 1;
				$term = 'Pre';
				break;
			case 'mid' :
				$e_type = 4;
				$term = 'Mid';
				break;
			case 'post_mid' :
				$term = 'Mid';
				$e_type = 6;
				break;
			case 'final' :
				$term = 'Final';
				$e_type = 9;
		}
		$data2['type'] = $e_type;
		$data['teacher_abstract'] = $this->Teacher_model->teacher_abstract($data2);
		
	
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
		
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>$term,'status'=>1))->result_array();
		$days = $result[0]['days'];
		
		if($term == 'Final'){
			$this->db->select('days');
			$mid_result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Mid','status'=>1))->result_array();
			$mid_days = $result[0]['days'];
			$days = $result[0]['days'] - $mid_result[0]['days'];
		}
		
		$school_id = $this->session->userdata('school_id');
		
		$annual_atten = 0;
		if($term == 'Final'){
			$this->db->select('sa.present');
			$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
			$annual_atten = $this->db->get_where('attendance_master am',array('am.session_id'=>$data['session'],'am.medium'=>$data['medium'],'am.class_id'=>$data['class_id'],'am.term'=>'Annual','am.section_id'=>$data['section']))->result_array();  
		}
		
		$this->db->select('stu.*,c.name as cname,s.name as secname,concat('.$annual_atten[0]['present'].' - sa.present,"/'.$days.'") as present');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
		if($data['class_id'] == 12 || $data['class_id'] == 13){
			$this->db->where('stu.fit', $data['fit'],false);
		}
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'am.medium'=>$data['medium'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();

		$this->db->select('s.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subject_lists = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['class_id'],'s.subj_type'=>'Scholastic','cs.status'=>1))->result_array();
		
		
		if($class_category == '1-5'){
			$subject_lists = array_replace(array_flip(array('31','5','9','11')), $subject_lists);
		}
		else if($class_category == '6-9'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
		else if($class_category == '10th'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
		
		$student_marks = array();
		$computer_marks = array();
			foreach($subject_lists as $subject_list){
				$this->db->select('*');
				$mark_master = $this->db->get_where('mark_master',array(
						'school_id'=>$school_id,
						'class_id'=>$data['class_id'],
						'section'=>$data['section'],
						'e_type'=>$e_type,
						'session_id'=>$data['session'],
						'sub_id'=>$subject_list['sub_id'],
						'medium' => $data['medium'],
						'status'=>1))->result_array();
				
				if(count($mark_master) > 0){
					foreach($students as $student){
						$this->db->select('*');
						$marks = $this->db->get_where('student_mark',array('mm_id'=>$mark_master[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>$e_type,'status'=>1))->result_array();
						
						if(count($marks) > 0){
							$student_marks[$student['s_id']][$subject_list['sub_id']]['mark'] = $marks[0]['marks'];
						}
					}
				}
			}
			if($e_type == 4 || $e_type == 9){
				$this->db->select('*');
				$mark_master = $this->db->get_where('mark_master',array('school_id'=>$school_id,'medium'=>$data['medium'],'class_id'=>$data['class_id'],'section'=>$data['section'],'e_type'=>$e_type,'session_id'=>$data['session'],'sub_id'=>22,'status'=>1))->result_array();
				//print_r($mark_master); die;
				if(count($mark_master) > 0){
					foreach($students as $student){
						$comp = $this->db->get_where('student_mark',array('mm_id'=>$mark_master[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>22,'e_type'=>$e_type,'status'=>1))->result_array();
						if(count($comp) > 0){
							$computer_marks[$student['s_id']][22]['mark'] = $comp[0]['marks'];
						}
					}
				}
			}
			
		$final_array = array();
		foreach($students as $student){
			$flag_1 = 1;
			$temp = array();
			foreach($student_marks as $key => $value){ 
				if($student['s_id'] == $key){
					$marks = array();
					foreach($value as $k => $v){
						$p = array();
						foreach($subject_lists as $subject_list){
							if($subject_list['sub_id'] == $k){
								$p['subject_name'] = $subject_list['name'];
							}
						}
						$p['student_id'] = $key;
						$p['subject_id'] = $k;
						$p['marks'] = $v['mark'];
						$marks[] = $p;
						$flag_1 = 0;
					}
					
					$total = 0;
					foreach($marks as $m){
						if($m['marks'] == 'A'){
							$temp['p_f'] = 1;
						}
						if($m['subject_id'] != 13){
							if($e_type == 4 || $e_type == 9){
								if($m['marks'] < 27){
									$temp['p_f'] = 1;
								}
							}
							else{
								if($m['marks'] < 17){
									$temp['p_f'] = 1;
								}
							}
						}
						if($m['subject_id'] != 13){
							$total = $total + $m['marks'];
						}
					}
					$temp['marks'] = $marks;
					$temp['total_marks'] = $total;
				}
				else{
					continue;
				}
				$temp['student_id'] = $key;
			}
			if($flag_1){
				$temp['student_id'] = $student['s_id'];
				$temp['marks'] = 0;
				$temp['total_marks'] = 0;
			}
			$temp['present'] = $student['present'];
			$temp['roll_no'] = $student['roll_no'];
			$temp['admission_no'] = $student['admission_no'];
			$temp['name'] = $student['name'];
			$temp['fname'] = $student['father_name'];
			$temp['mname'] = $student['mother_name'];
			$temp['cname'] = $student['cname'];
			$temp['secname'] = $student['secname'];
			$final_array[] = $temp;
		}
			$com_marks = array();
			foreach($students as $student){
				foreach($computer_marks as $key => $value){
						$temp = array();
					if($student['s_id'] == $key){
						$temp['s_id'] = $student['s_id'];
						$temp['mark'] = $value[22]['mark'];
						$com_marks[] = $temp;
					}
				}
			}
			
			$pass_fail_filtered = array();
			foreach($final_array as $f){
				if(!isset($f['p_f'])){}
				else{
					$pass_fail_filtered[] = $f;
				}
			}

		$topper_list = $final_array;
		
		$toppers = array();
		foreach ($topper_list as $key => $row){
			if(isset($row['p_f'])){
				$toppers[$key] = 'A';
			}
			else{
				if(isset($row['total_marks'])){
					$toppers[$key] = $row['total_marks'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
		}
		array_multisort($toppers, SORT_DESC, $topper_list);
		
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
			foreach($topper_list as $topper){
			if(isset($topper['p_f'])){
				$marks = 0;
				$rank = 0;
				$topper['rank'] = 0;
				$top_student[] = $topper;
			}
			else{
				if($c == 0) {
					$marks = $topper['total_marks'];
					$rank = $rank + 1;
					$topper['rank'] = $rank; 
					$top_student[] = $topper;
					$c = $c + 1;
				}
				else {
					if($topper['total_marks'] == $marks){
						$marks = $topper['total_marks'];
						$topper['rank'] = $rank;
						$top_student[] = $topper;
					}
					else if($topper['total_marks'] < $marks){
						$marks = $topper['total_marks'];
						$rank = $rank + 1;
						$topper['rank'] = $rank;
						$top_student[] = $topper;
						$c = $c + 1;
					}
				}
			}
		}
		
		$stulist_with_rank = array();
		foreach ($final_array as $student){
			foreach ($top_student as $top){
				if($student['student_id'] == $top['student_id']){
					$student['rank'] = $top['rank'];
					$stulist_with_rank[] = $student;
					break;
				}	
			}
		}
		
		if($e_type == 4 || $e_type == 9){
			$stulist_with_rank_1 = array();
			foreach ($stulist_with_rank as $student){
				$flag_1 = 1;
				$temp = array();
				foreach ($com_marks as $com_mark){
					if($student['student_id'] == $com_mark['s_id']){
						$temp = $student;
						$temp['comp'] = $com_mark['mark'];
						$stulist_with_rank_1[] = $temp;
						$flag_1 = 0;
					}
				}
				if($flag_1){
					$temp = $student;
					$temp['comp'] = 0;
					$stulist_with_rank_1[] = $temp;
				}
			}
		}
		
		
		$data['s_list'] = $stulist_with_rank;
		if($e_type == 4 || $e_type == 9){
			$data['computer'] = $com_marks;
			$data['s_list'] = $stulist_with_rank_1;
		}
		
		$data['t_list'] = $top_student;
		if($data['type'] == 'pre' || $data['type'] == 'post_mid'){
			$flag = 0;
			foreach($data['s_list'][0]['marks'] as $mrk){
				if($mrk['subject_id'] == 13){
					$flag = 50;
				}
			}
			$data['out_of'] = (int)count($data['s_list'][0]['marks']) * 50 - $flag; 
		}
		else{
			$flag = 0;
			foreach($data['s_list'][0]['marks'] as $mrk){
				if($mrk['subject_id'] == 13){
					$flag = 80;
				}
			}
			$data['out_of'] = (int)count($data['s_list'][0]['marks']) * 80 - $flag;
		}
		return $data;
	}
	
	function classwise_mid_high_class($data){
		$data2['class'] = $data['class_id'];
		$data2['section'] = $data['section'];
		$data2['medium'] = $data['medium'];
		$data2['school_id'] = $data['school_id'];
		$data2['session'] = $data['session'];
		$data2['type'] = 4;
		
		if($data['s_group'] == 'Maths'){
			$data2['s_group'] = 'maths';
		}
		else if($data['s_group'] == 'Boilogy'){
			$data2['s_group'] = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$data2['s_group'] = 'commer';
		}
		else{
			$data2['s_group'] = 'art';
		}
		$data1['teacher_abstract'] = $this->Teacher_model->teacher_abstract_high_class_mid($data2);
		
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Mid','status'=>1))->result_array();
		$days = $result[0]['days'];

		$this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present, DATE_FORMAT(stu.dob, "%d/%m/%Y") dob,DATE_FORMAT(stu.admission_date, "%d/%m/%Y") admission_date');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'stu.subject_group'=>$data['s_group'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();

		$this->db->select('id');
		if($data['type'] == 'pre'){
			$this->db->where('e_type',4);
		}
		if($data['s_group'] == 'Maths'){
			$sgroup = 'maths';		
		}
		else if($data['s_group'] == 'Boilogy'){
			$sgroup = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$sgroup = 'commer';
		}
		else{
			$sgroup = 'art';
		}
		$mark_masters = $this->db->get_where('high_class_mark_master',array(
				'school_id' => $data['school_id'],
				'class_id' => $data['class_id'],
				'section_id' => $data['section'],
				'medium' => $data['medium'],
				'e_type' => 4
		))->result_array();
	
		$mark_master_ids = array();
		foreach($mark_masters as $mark_master){
			array_push($mark_master_ids, $mark_master['id']);
		}
		
		$this->db->select('*');
		$this->db->where_in('hm_id',$mark_master_ids);
		$student_marks = $this->db->get('student_marks_high_class')->result_array();
		
		$this->db->select('distinct(sf.sub_id) as id,sf.subj_marks,ss.subject,ss.type');
		$this->db->join('subjects_11_12 ss','ss.id = sf.sub_id');
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>'mid','sf.class'=>$data['class_id']))->result_array();
		
		if($sgroup == 'maths'|| $sgroup == 'bio'){
			$subjects_order = array('5','9','10','11','12','1','2','3','4');
		}
		if($sgroup == 'commer'){
			$subjects_order = array('5','9','10','11','12','6','7','8');
		}
		
		$subject_order = array();
		foreach($subjects_order as $subject){
			foreach($subjects as $s){
				if($subject == $s['id']){
					$subject_order[] = $s;
				}
			}
		}
		$subjects = $subject_order;
		
		///////////////////////student detail with subject marks///////////////////////////////////
		$student_mark_n_detail = array();
		foreach($students as $student){
			$marks = array();
			foreach($subjects as $subject){
				$f = 1;
				foreach($student_marks as $student_mark){
					if($subject['id'] == $student_mark['subject_id'] && $student['s_id'] == $student_mark['student_id']){
						$mark['sub_id'] = $subject['id'];
						$mark['sub_name'] = $subject['subject'];
						$mark['sub_type'] = $subject['type'];
						$mark['subj_marks'] = $subject['subj_marks'];
						$mark['marks'] = $student_mark['marks'];
						$marks[] = $mark;
						$f = 0;
					}
				}
				if($f){
					$mark['sub_id'] = $subject['id'];
					$mark['sub_name'] = $subject['subject'];
					$mark['sub_type'] = $subject['type'];
					$mark['subj_marks'] = $subject['subj_marks'];
					$mark['marks'] = '-';
					$marks[] = $mark;
				}
			}
			$total_marks = 0;
			$out_of = 0;
			$temp = $student;
			$temp['flag'] = 1;
			
			foreach ($marks as $mark){
				if($mark['subj_marks'] == 100){
					$min_marks = 33;
				}
				else if($mark['subj_marks'] == 90){
					$min_marks = 30;
				}
				else if($mark['subj_marks'] == 80){
					$min_marks = 27;
				}
				else if($mark['subj_marks'] == 70){
					$min_marks = 23;
				}
				else if($mark['subj_marks'] == 50){
					$min_marks = 17;
				}
				if($mark['marks'] == 'A'){
					$mark['marks'] = 0;
					$temp['flag'] = 0;
				}
				if($mark['marks'] < $min_marks && $mark['marks'] != '-'){
					$temp['flag'] = 0;
				}
				if($mark['marks'] != '-'){
					$total_marks = $total_marks + $mark['marks'];
					$out_of = $out_of + $mark['subj_marks'];
				}
			}
			
			$temp['total'] = $total_marks;
			$temp['marks'] = $marks;
			$temp['out_of'] = $out_of;
			$temp['percent'] = $total_marks / $out_of ; 
			$student_mark_n_detail[] = $temp;
		}
		
		////////////////computer science co-scholastics marks added/////////////////////////
		
		$only_pass_student = array();
		foreach($student_mark_n_detail as $student_marks){
			if($student_marks['flag']){
				$only_pass_student[] = $student_marks;
			}
		}
		//////////// sorting according to total marks //////////////////////////////
		$toppers = array();
		foreach ($only_pass_student as $key => $row){
			if(isset($row['percent'])){
				$toppers[$key] = $row['percent'];
			}
			else{
				$toppers[$key] = 0;
			}
		}
		array_multisort($toppers, SORT_DESC, $only_pass_student);
		
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
		
		foreach($only_pass_student as $topper){
			if($c == 0) {
				$marks = $topper['percent'];
				$rank = $rank + 1;
				$topper['rank'] = $rank;
				$top_student[] = $topper;
				$c = $c + 1;
			}
			else {
				if($topper['percent'] == $marks){
					$marks = $topper['percent'];
					$topper['rank'] = $rank;
					$top_student[] = $topper;
				}
				else if($topper['percent'] < $marks){
					$marks = $topper['percent'];
					$rank = $rank + 1;
					$topper['rank'] = $rank;
					$top_student[] = $topper;
					$c = $c + 1;
				}
			}
		}
		
		$new_array = array();
		foreach ($student_mark_n_detail as $student){
			$f = 1;
			$temp = array();
			foreach ($top_student as $top){
				if($student['s_id'] == $top['s_id']){
					$f = 0;
					$temp = $student;
					$temp['rank'] = $top['rank']; 
					$new_array[] = $temp;
				}
			}
			if($f){
				$temp = $student;
				$temp['rank'] = 0;
				$new_array[] = $temp;
			}
		}
		
		$data1['student_with_rank'] = $new_array;
		$data1['top_list'] = $top_student;
		return $data1; 
	}
	
	function classwise_pre_high_class($data){
		$data2['class'] = $data['class_id'];
		$data2['section'] = $data['section'];
		$data2['medium'] = $data['medium'];
		$data2['school_id'] = $data['school_id'];
		$data2['session'] = $data['session'];
		$data2['type'] = 1;
		if($data['s_group'] == 'Maths'){
			$data2['s_group'] = 'maths';
		}
		else if($data['s_group'] == 'Boilogy'){
			$data2['s_group'] = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$data2['s_group'] = 'commer';
		}
		else{
			$data2['s_group'] = 'art'; 
		}
		$data1['teacher_abstract'] = $this->Teacher_model->teacher_abstract_high_class($data2);
		
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Mid','status'=>1))->result_array();
		$days = $result[0]['days'];
	
		$this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present, DATE_FORMAT(stu.dob, "%d/%m/%Y") dob,DATE_FORMAT(stu.admission_date, "%d/%m/%Y") admission_date');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'stu.subject_group'=>$data['s_group'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();
		
		$this->db->select('id');
		if($data['type'] == 'pre'){
			$this->db->where('e_type',1);
		}
		if($data['s_group'] == 'Maths'){
			$sgroup = 'maths';
		}
		else if($data['s_group'] == 'Boilogy'){
			$sgroup = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$sgroup = 'commer';
		}
		else{
			$sgroup = 'art';
		}
		$mark_masters = $this->db->get_where('high_class_mark_master',array(
				'school_id' => $data['school_id'],
				'class_id' => $data['class_id'],
				'section_id' => $data['section'],
				//'s_group' => $sgroup,
				'medium' => $data['medium']
		))->result_array();
	
		$mark_master_ids = array();
		foreach($mark_masters as $mark_master){
			array_push($mark_master_ids, $mark_master['id']);
		}
	
		$this->db->select('*');
		$this->db->where_in('hm_id',$mark_master_ids);
		$student_marks = $this->db->get('student_marks_high_class')->result_array();
	
		$this->db->select('id,subject,type,subj_marks');
		$subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'','e_type'=>1))->result_array();
		
		if($sgroup == 'maths'|| $sgroup == 'bio'){
			$subjects_order = array('5','9','10','11','12','1','2','3','4');
		}
		if($sgroup == 'commer'){
			$subjects_order = array('5','9','10','11','12','6','7','8');
		}
	
		$subject_order = array();
		foreach($subjects_order as $subject){
			foreach($subjects as $s){
				if($subject == $s['id']){
					$subject_order[] = $s;
				}
			}
		}
		$subjects = $subject_order;
		//print_r($subject_order); die;
		///////////////////////student detail with subject marks///////////////////////////////////
		//print_r($student_marks); die;
		$student_mark_n_detail = array();
		foreach($students as $student){
			$marks = array();
			foreach($subjects as $subject){
				$f = 1;
				foreach($student_marks as $student_mark){
					if($subject['id'] == $student_mark['subject_id'] && $student['s_id'] == $student_mark['student_id']){
						$mark['sub_id'] = $subject['id'];
						$mark['sub_name'] = $subject['subject'];
						$mark['sub_type'] = $subject['type'];
						$mark['subj_marks'] = $subject['subj_marks'];
						$mark['marks'] = $student_mark['marks'];
						$marks[] = $mark;
						$f = 0;
					}
				}
				if($f){
					$mark['sub_id'] = $subject['id'];
					$mark['sub_name'] = $subject['subject'];
					$mark['sub_type'] = $subject['type'];
					$mark['subj_marks'] = $subject['subj_marks'];
					$mark['marks'] = '-';
					$marks[] = $mark;
				}
			}
			$total_marks = 0;
			$out_of = 0;
			$temp = $student;
			$temp['flag'] = 1;
			foreach ($marks as $mark){
				if($mark['marks'] == 'A'){
					$mark['marks'] = 0;
					$temp['flag'] = 0;
				}
				if($mark['marks'] != '-'){
					$total_marks = $total_marks + $mark['marks'];
					$out_of = $out_of + $mark['subj_marks'];
				}
				if($mark['marks'] < 17 && $mark['marks'] != '-'){
					$temp['flag'] = 0;
				}
			}
			$temp['total'] = $total_marks;
			$temp['marks'] = $marks;
			$temp['out_of'] = $out_of;
			$temp['percent'] = $total_marks / $out_of;
			$student_mark_n_detail[] = $temp;
		}
		$only_pass_student = array();
		foreach($student_mark_n_detail as $student_marks){
			if($student_marks['flag']){
				$only_pass_student[] = $student_marks;
			}
		}
		//////////// sorting according to total marks //////////////////////////////
		$toppers = array();
		foreach ($only_pass_student as $key => $row){
			if(isset($row['percent'])){
				$toppers[$key] = $row['percent'];
			}
			else{
				$toppers[$key] = 0;
			}
		}
		array_multisort($toppers, SORT_DESC, $only_pass_student);
	
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
	
		foreach($only_pass_student as $topper){
			if($c == 0) {
				$marks = $topper['percent'];
				$rank = $rank + 1;
				$topper['rank'] = $rank;
				$top_student[] = $topper;
				$c = $c + 1;
			}
			else {
				if($topper['percent'] == $marks){
					$marks = $topper['percent'];
					$topper['rank'] = $rank;
					$top_student[] = $topper;
				}
				else if($topper['percent'] < $marks){
					$marks = $topper['percent'];
					$rank = $rank + 1;
					$topper['rank'] = $rank;
					$top_student[] = $topper;
					$c = $c + 1;
				}
			}
		}
	
		$new_array = array();
		foreach ($student_mark_n_detail as $student){
			$f = 1;
			$temp = array();
			foreach ($top_student as $top){
				if($student['s_id'] == $top['s_id']){
					$f = 0;
					$temp = $student;
					$temp['rank'] = $top['rank'];
					$new_array[] = $temp;
				}
			}
			if($f){
				$temp = $student;
				$temp['rank'] = 0;
				$new_array[] = $temp;
			}
		}
	
		$data1['student_with_rank'] = $new_array;
		$data1['top_list'] = $top_student;
		return $data1;
	}
	
	function classwise_post_high_class($data){
	    $data2['class'] = $data['class_id'];
	    $data2['section'] = $data['section'];
	    $data2['medium'] = $data['medium'];
	    $data2['school_id'] = $data['school_id'];
	    $data2['session'] = $data['session'];
	    $data2['type'] = 3;
	    
	    if($data['s_group'] == 'Maths'){
	        $data2['s_group'] = 'maths';
	    }
	    else if($data['s_group'] == 'Boilogy'){
	        $data2['s_group'] = 'bio';
	    }
	    else if($data['s_group'] == 'Commerce'){
	        $data2['s_group'] = 'commer';
	    }
	    else{
	        $data2['s_group'] = 'art';
	    }
	    $data1['teacher_abstract'] = $this->Teacher_model->teacher_abstract_high_class($data2);
	    
	    if($data['class_id'] > 3 && $data['class_id'] < 9){
	        $class_category = '1-5';
	    }
	    else if($data['class_id'] > 8 && $data['class_id'] < 13){
	        $class_category = '6-9';
	    }
	    else if($data['class_id'] == 13){
	        $class_category = '10th';
	    }
	    else if($data['class_id'] == 14){
	        $class_category = '11th';
	    }
	    else if($data['class_id'] == 15){
	        $class_category = '12th';
	    }
	    else{
	        $class_category = 'primary';
	    }
	    $this->db->select('days');
	    $result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Mid','status'=>1))->result_array();
	    $days = $result[0]['days'];
	    
	    $this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present, DATE_FORMAT(stu.dob, "%d/%m/%Y") dob,DATE_FORMAT(stu.admission_date, "%d/%m/%Y") admission_date');
	    $this->db->join('class c','c.c_id = stu.class_id');
	    $this->db->join('section s','s.id = stu.section');
	    $this->db->join('attendance_master am','am.class_id = stu.class_id');
	    $this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
	    $this->db->order_by('roll_no','ASC');
	    $this->db->where('am.section_id','stu.section',false);
	    $this->db->where('sa.student_id', 'stu.s_id',false);
	    $students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'stu.subject_group'=>$data['s_group'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();
	    
	    $this->db->select('id');
	    if($data['type'] == 'post_mid'){
	        $this->db->where('e_type',6);
	    }
	    if($data['s_group'] == 'Maths'){
	        $sgroup = 'maths';
	    }
	    else if($data['s_group'] == 'Boilogy'){
	        $sgroup = 'bio';
	    }
	    else if($data['s_group'] == 'Commerce'){
	        $sgroup = 'commer';
	    }
	    else{
	        $sgroup = 'art';
	    }
	    $mark_masters = $this->db->get_where('high_class_mark_master',array(
	        'school_id' => $data['school_id'],
	        'class_id' => $data['class_id'],
	        'section_id' => $data['section'],
	        //'s_group' => $sgroup,
	        'medium' => $data['medium']
	    ))->result_array();
	    
	    $mark_master_ids = array();
	    foreach($mark_masters as $mark_master){
	        array_push($mark_master_ids, $mark_master['id']);
	    }
	    
	    $this->db->select('*');
	    $this->db->where_in('hm_id',$mark_master_ids);
	    $student_marks = $this->db->get('student_marks_high_class')->result_array();
	    
	    $this->db->select('id,subject,type,subj_marks');
	    $subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'e_type'=>1))->result_array();
	    
	    if($sgroup == 'maths'|| $sgroup == 'bio'){
	        $subjects_order = array('5','9','10','11','12','1','2','3','4');
	    }
	    if($sgroup == 'commer'){
	        $subjects_order = array('5','9','10','11','12','6','7','8');
	    }
	    
	    $subject_order = array();
	    foreach($subjects_order as $subject){
	        foreach($subjects as $s){
	            if($subject == $s['id']){
	                $subject_order[] = $s;
	            }
	        }
	    }
	    $subjects = $subject_order;
	    
	    ///////////////////////student detail with subject marks///////////////////////////////////
	    $student_mark_n_detail = array();
	    foreach($students as $student){
	        $marks = array();
	        foreach($subjects as $subject){
	            $f = 1;
	            foreach($student_marks as $student_mark){
	                if($subject['id'] == $student_mark['subject_id'] && $student['s_id'] == $student_mark['student_id']){
	                    $mark['sub_id'] = $subject['id'];
	                    $mark['sub_name'] = $subject['subject'];
	                    $mark['sub_type'] = $subject['type'];
	                    $mark['subj_marks'] = $subject['subj_marks'];
	                    $mark['marks'] = $student_mark['marks'];
	                    $marks[] = $mark;
	                    $f = 0;
	                }
	            }
	            if($f){
	                $mark['sub_id'] = $subject['id'];
	                $mark['sub_name'] = $subject['subject'];
	                $mark['sub_type'] = $subject['type'];
	                $mark['subj_marks'] = $subject['subj_marks'];
	                $mark['marks'] = '-';
	                $marks[] = $mark;
	            }
	        }
	        $total_marks = 0;
	        $out_of = 0;
	        $temp = $student;
	        $temp['flag'] = 1;
	        foreach ($marks as $mark){
	            if($mark['marks'] == 'A'){
	                $mark['marks'] = 0;
	                $temp['flag'] = 0;
	            }
	            if($mark['marks'] != '-'){
	                $total_marks = $total_marks + $mark['marks'];
	                $out_of = $out_of + $mark['subj_marks'];
	            }
	            if($mark['marks'] < 17 && $mark['marks'] != '-'){
	                $temp['flag'] = 0;
	            }
	        }
	        $temp['total'] = $total_marks;
	        $temp['marks'] = $marks;
	        $temp['out_of'] = $out_of;
	        $temp['percent'] = $total_marks / $out_of;
	        $student_mark_n_detail[] = $temp;
	    }
	    $only_pass_student = array();
	    foreach($student_mark_n_detail as $student_marks){
	        if($student_marks['flag']){
	            $only_pass_student[] = $student_marks;
	        }
	    }
	    //////////// sorting according to total marks //////////////////////////////
	    $toppers = array();
	    foreach ($only_pass_student as $key => $row){
	        if(isset($row['percent'])){
	            $toppers[$key] = $row['percent'];
	        }
	        else{
	            $toppers[$key] = 0;
	        }
	    }
	    array_multisort($toppers, SORT_DESC, $only_pass_student);
	    
	    $c =  0;
	    $marks;
	    $rank = 0;
	    $top_student = array();
	    
	    foreach($only_pass_student as $topper){
	        if($c == 0) {
	            $marks = $topper['percent'];
	            $rank = $rank + 1;
	            $topper['rank'] = $rank;
	            $top_student[] = $topper;
	            $c = $c + 1;
	        }
	        else {
	            if($topper['percent'] == $marks){
	                $marks = $topper['percent'];
	                $topper['rank'] = $rank;
	                $top_student[] = $topper;
	            }
	            else if($topper['percent'] < $marks){
	                $marks = $topper['percent'];
	                $rank = $rank + 1;
	                $topper['rank'] = $rank;
	                $top_student[] = $topper;
	                $c = $c + 1;
	            }
	        }
	    }
	    
	    $new_array = array();
	    foreach ($student_mark_n_detail as $student){
	        $f = 1;
	        $temp = array();
	        foreach ($top_student as $top){
	            if($student['s_id'] == $top['s_id']){
	                $f = 0;
	                $temp = $student;
	                $temp['rank'] = $top['rank'];
	                $new_array[] = $temp;
	            }
	        }
	        if($f){
	            $temp = $student;
	            $temp['rank'] = 0;
	            $new_array[] = $temp;
	        }
	    }
	    
	    $data1['student_with_rank'] = $new_array;
	    $data1['top_list'] = $top_student;
	    return $data1;
	}
	
	
	function final_fard($data){
		$data2['class'] = $data['class_id'];
		$data2['section'] = $data['section'];
		$data2['medium'] = $data['medium'];
		$data2['school_id'] = $data['school_id'];
		$data2['session'] = $data['session'];
			
// 		$e_type = '';
// 		$term = '';
// 		switch($data['type']){
// 			case 'pre' :
// 				$e_type = 1;
// 				$term = 'Mid';
// 				break;
// 			case 'mid' :
// 				$e_type = 4;
// 				$term = 'Mid';
// 				break;
// 			case 'post_mid' :
// 				$term = 'Mid';
// 				$e_type = 6;
// 				break;
// 			case 'final' :
// 				$term = 'Final';
// 				$e_type = 9;
// 		}
// 		$data2['type'] = $e_type;
// 		$data['teacher_abstract'] = $this->Teacher_model->teacher_abstract($data2);
	
	
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
	
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Final','status'=>1))->result_array();
		if(count($result)>0){
			$days = $result[0]['days'];
		}
		else{
			$days = 0;
		}
	
		$school_id = $this->session->userdata('school_id');
	
		$this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
		
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'am.medium'=>$data['medium'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();
		
		$this->db->select('s.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subject_lists = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['class_id'],'s.subj_type'=>'Scholastic','cs.status'=>1))->result_array();
		
		if($class_category == '1-5'){
			$subject_lists = array_replace(array_flip(array('31','5','9','11')), $subject_lists);
		}
		else if($class_category == '6-9'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
		else if($class_category == '10th'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
		
		$student_marks = array();
		foreach($subject_lists as $subject_list){
			$this->db->select('*');
			$mark_master_pre = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>1,
					'session_id'=>$data['session'],
					'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();
			
			$mark_master_mid = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>4,
					'session_id'=>$data['session'],
					'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();
			
			$mark_master_post = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>6,
					'session_id'=>$data['session'],
					'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();
			
			$mark_master_final = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>9,
					'session_id'=>$data['session'],
					'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();
			
			if(count($mark_master_pre) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_pre = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_pre[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>1,'status'=>1))->result_array();
	
					if(count($marks_pre) > 0){
						$student_marks[$student['s_id']]['pre'][$subject_list['sub_id']]['mark'] = $marks_pre[0]['marks'];
					}
				}
			}
			
			if(count($mark_master_mid) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_mid = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_mid[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>4,'status'=>1))->result_array();
			
					if(count($marks_mid) > 0){
						$student_marks[$student['s_id']]['mid'][$subject_list['sub_id']]['mark'] = $marks_mid[0]['marks'];
					}
				}
			}
			
			if(count($mark_master_post) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_post = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_post[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>6,'status'=>1))->result_array();
						
					if(count($marks_post) > 0){
						$student_marks[$student['s_id']]['post'][$subject_list['sub_id']]['mark'] = $marks_post[0]['marks'];
					}
				}
			}
			
			if(count($mark_master_final) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_final = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_final[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>9,'status'=>1))->result_array();
			
					if(count($marks_final) > 0){
						$student_marks[$student['s_id']]['final'][$subject_list['sub_id']]['mark'] = $marks_final[0]['marks'];
					}
				}
			}
		}
		
		$final_array = array();
		foreach($students as $student){
			$flag_1 = 1;
			$temp = array();
			
			foreach($student_marks as $key => $value){
				if($student['s_id'] == $key){
					$marks = array();
					foreach($value as $k => $v){
						foreach($v as $ky => $vl){
							$p = array();
							foreach($subject_lists as $subject_list){
								if($subject_list['sub_id'] == $ky){
									$p['subject_name'] = $subject_list['name'];
								}
							}
							$p['student_id'] = $key;
							$p['subject_id'] = $ky;
							$p['type'] = $k;
							$p['marks'] = $vl['mark'];
							$marks[] = $p;
							$flag_1 = 0;
						}
					}
					
					$total = 0;
					$outoff = 0;
					foreach($marks as $m){
						if($m['marks'] == 'A'){
							$temp['p_f'] = 1;
						}
						if($m['subject_id'] != 13){
							if($m['type'] == 'mid' || $m['type'] == 'final'){
								if($m['marks'] < 27){
									$temp['p_f'] = 1;
								}
							}
							else{
								if($m['marks'] < 17){
									$temp['p_f'] = 1;
								}
							}
						}
						if($m['subject_id'] != 13){
							$total = $total + $m['marks'];
							if($m['type'] == 'mid' || $m['type'] == 'final'){
								$outoff = $outoff + 80;
							}
							else{
								$outoff = $outoff + 50;
							}
						}
					}
					
					$new_marks = array();
					foreach($marks as $ma){
						$temp1 = array();
						$temp1['subject_name'] = $ma['subject_name'];
						$temp1['subject_id'] = $ma['subject_id'];
						foreach($marks as $mar){
							if($ma['subject_id'] == $mar['subject_id']){
								if($mar['type'] == 'pre'){
									$temp1['marks_pre'] = $mar['marks'];
								}
								if($mar['type'] == 'mid'){
									$temp1['marks_mid'] = $mar['marks'];
								}
								if($mar['type'] == 'post'){
									$temp1['marks_post'] = $mar['marks'];
								}
								if($mar['type'] == 'final'){
									$temp1['marks_final'] = $mar['marks'];
								}
							}
						}
					$new_marks[] = $temp1;
					}
					$new_marks = array_unique($new_marks, SORT_REGULAR);
					
					$temp['marks'] = $new_marks;
					$temp['total_marks'] = $total;
					$temp['outoff_marks'] = $outoff;
				}
				else{
					continue;
				}
				$temp['student_id'] = $key;
			}
			if($flag_1){
				$temp['student_id'] = $student['s_id'];
				$temp['marks'] = 0;
				$temp['total_marks'] = 0;
			}
			$temp['present'] = $student['present'];
			$temp['roll_no'] = $student['roll_no'];
			$temp['admission_no'] = $student['admission_no'];
			$temp['name'] = $student['name'];
			$temp['fname'] = $student['father_name'];
			$temp['mname'] = $student['mother_name'];
			$temp['cname'] = $student['cname'];
			$temp['secname'] = $student['secname'];
			$final_array[] = $temp;
		}
			
		$pass_fail_filtered = array();
		foreach($final_array as $f){
			if(!isset($f['p_f'])){}
			else{
				$pass_fail_filtered[] = $f;
			}
		}
	
		$topper_list = $final_array;
	
		$toppers = array();
		foreach ($topper_list as $key => $row){
			if(isset($row['p_f'])){
				$toppers[$key] = 'A';
			}
			else{
				if(isset($row['total_marks'])){
					$toppers[$key] = $row['total_marks'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
		}
		array_multisort($toppers, SORT_DESC, $topper_list);
	
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
		foreach($topper_list as $topper){
			if(isset($topper['p_f'])){
				$marks = 0;
				$rank = 0;
				$topper['rank'] = 0;
				$top_student[] = $topper;
			}
			else{
				if($c == 0) {
					$marks = $topper['total_marks'];
					$rank = $rank + 1;
					$topper['rank'] = $rank;
					$top_student[] = $topper;
					$c = $c + 1;
				}
				else {
					if($topper['total_marks'] == $marks){
						$marks = $topper['total_marks'];
						$topper['rank'] = $rank;
						$top_student[] = $topper;
					}
					else if($topper['total_marks'] < $marks){
						$marks = $topper['total_marks'];
						$rank = $rank + 1;
						$topper['rank'] = $rank;
						$top_student[] = $topper;
						$c = $c + 1;
					}
				}
			}
		}
	
		$stulist_with_rank = array();
		foreach ($final_array as $student){
			foreach ($top_student as $top){
				if($student['student_id'] == $top['student_id']){
					$student['rank'] = $top['rank'];
					$stulist_with_rank[] = $student;
					break;
				}
			}
		}
	
		$data['s_list'] = $stulist_with_rank;
		$data['t_list'] = $top_student;
		return $data;
	}
	
	
	function term2_fard($data){
		$data['class'] = $data['class_id'];
		$data['section'] = $data['section_id'];
		$data['medium'] = $data['medium'];
		$data['school_id'] = $data['school'];
		$data['session'] = $data['session'];

		$e_type = '';
		$term = '';
		switch($data['type']){
			case 'pre' :
				$e_type = 1;
				$term = 'Mid';
				break;
			case 'mid' :
				$e_type = 4;
				$term = 'Mid';
				break;
			case 'post_mid' :
				$term = 'Mid';
				$e_type = 6;
				break;
			case 'final' :
				$term = 'Final';
				$e_type = 9;
		}
		$data['type'] = $e_type;

        $data['teacher_abstract'] = $this->Teacher_model->teacher_abstract($data);
				
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
	
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Final','status'=>1))->result_array();
		if(count($result)>0){
			$days = $result[0]['days'];
		}
		else{
			$days = 0;
		}
	
		$school_id = $this->session->userdata('school_id');
	
		$this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
	
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'am.medium'=>$data['medium'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();
	
		$this->db->select('s.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subject_lists = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['class_id'],'s.subj_type'=>'Scholastic','cs.status'=>1))->result_array();
	
		if($class_category == '1-5'){
			$subject_lists = array_replace(array_flip(array('31','5','9','11')), $subject_lists);
		}
		else if($class_category == '6-9'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
		else if($class_category == '10th'){
			$subject_lists = array_replace(array_flip(array('31','5','9','6','7','12')), $subject_lists);
		}
	
		$student_marks = array();
		foreach($subject_lists as $subject_list){
			$this->db->select('*');	
			$mark_master_post = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>6,
					'session_id'=>$data['session'],
			        'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();

			$mark_master_final = $this->db->get_where('mark_master',array(
					'school_id'=>$school_id,
					'class_id'=>$data['class_id'],
					'section'=>$data['section'],
					'e_type'=>9,
					'session_id'=>$data['session'],
					'sub_id'=>$subject_list['sub_id'],
					'medium' => $data['medium'],
					'status'=>1))->result_array();

			if(count($mark_master_post) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_post = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_post[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>6,'status'=>1))->result_array();
	
					if(count($marks_post) > 0){
						$student_marks[$student['s_id']]['post'][$subject_list['sub_id']]['mark'] = $marks_post[0]['marks'];
					}
				}
			}
				
			if(count($mark_master_final) > 0){
				foreach($students as $student){
					$this->db->select('*');
					$marks_final = $this->db->get_where('student_mark',array('mm_id'=>$mark_master_final[0]['m_id'],'student_id'=>$student['s_id'],'subject_id'=>$subject_list['sub_id'],'e_type'=>9,'status'=>1))->result_array();
						
					if(count($marks_final) > 0){
						$student_marks[$student['s_id']]['final'][$subject_list['sub_id']]['mark'] = $marks_final[0]['marks'];
					}
				}
			}
		}
	
		$final_array = array();
		foreach($students as $student){
			$flag_1 = 1;
			$temp = array();
				
			foreach($student_marks as $key => $value){
				if($student['s_id'] == $key){
					$marks = array();
					foreach($value as $k => $v){
						foreach($v as $ky => $vl){
							$p = array();
							foreach($subject_lists as $subject_list){
								if($subject_list['sub_id'] == $ky){
									$p['subject_name'] = $subject_list['name'];
								}
							}
							$p['student_id'] = $key;
							$p['subject_id'] = $ky;
							$p['type'] = $k;
							$p['marks'] = $vl['mark'];
							$marks[] = $p;
							$flag_1 = 0;
						}
					}
						
					$total = 0;
					$outoff = 0;
					foreach($marks as $m){
						if($m['marks'] == 'A'){
							$temp['p_f'] = 1;
						}
						if($m['subject_id'] != 13){
							if($m['type'] == 'mid' || $m['type'] == 'final'){
								if($m['marks'] < 27){
									$temp['p_f'] = 1;
								}
							}
							else{
								if($m['marks'] < 17){
									$temp['p_f'] = 1;
								}
							}
						}
						if($m['subject_id'] != 13){
							$total = $total + $m['marks'];
							if($m['type'] == 'mid' || $m['type'] == 'final'){
								$outoff = $outoff + 80;
							}
							else{
								$outoff = $outoff + 50;
							}
						}
					}
						
					$new_marks = array();
					foreach($marks as $ma){
						$temp1 = array();
						$temp1['subject_name'] = $ma['subject_name'];
						$temp1['subject_id'] = $ma['subject_id'];
						foreach($marks as $mar){
							if($ma['subject_id'] == $mar['subject_id']){
								if($mar['type'] == 'post'){
									$temp1['marks_post'] = $mar['marks'];
								}
								if($mar['type'] == 'final'){
									$temp1['marks_final'] = $mar['marks'];
								}
							}
						}
						$new_marks[] = $temp1;
					}
					$new_marks = array_unique($new_marks, SORT_REGULAR);
						
					$temp['marks'] = $new_marks;
					$temp['total_marks'] = $total;
					$temp['outoff_marks'] = $outoff;
				}
				else{
					continue;
				}
				$temp['student_id'] = $key;
			}
			if($flag_1){
				$temp['student_id'] = $student['s_id'];
				$temp['marks'] = 0;
				$temp['total_marks'] = 0;
			}
			$temp['present'] = $student['present'];
			$temp['roll_no'] = $student['roll_no'];
			$temp['admission_no'] = $student['admission_no'];
			$temp['name'] = $student['name'];
			$temp['fname'] = $student['father_name'];
			$temp['mname'] = $student['mother_name'];
			$temp['cname'] = $student['cname'];
			$temp['secname'] = $student['secname'];
			$final_array[] = $temp;
		}
			
		$pass_fail_filtered = array();
		foreach($final_array as $f){
			if(!isset($f['p_f'])){}
			else{
				$pass_fail_filtered[] = $f;
			}
		}
	
		$topper_list = $final_array;
	
		$toppers = array();
		foreach ($topper_list as $key => $row){
			if(isset($row['p_f'])){
				$toppers[$key] = 'A';
			}
			else{
				if(isset($row['total_marks'])){
					$toppers[$key] = $row['total_marks'];
				}
				else{
					$toppers[$key] = 0;
				}
			}
		}
		array_multisort($toppers, SORT_DESC, $topper_list);
	
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
		foreach($topper_list as $topper){
			if(isset($topper['p_f'])){
				$marks = 0;
				$rank = 0;
				$topper['rank'] = 0;
				$top_student[] = $topper;
			}
			else{
				if($c == 0) {
					$marks = $topper['total_marks'];
					$rank = $rank + 1;
					$topper['rank'] = $rank;
					$top_student[] = $topper;
					$c = $c + 1;
				}
				else {
					if($topper['total_marks'] == $marks){
						$marks = $topper['total_marks'];
						$topper['rank'] = $rank;
						$top_student[] = $topper;
					}
					else if($topper['total_marks'] < $marks){
						$marks = $topper['total_marks'];
						$rank = $rank + 1;
						$topper['rank'] = $rank;
						$top_student[] = $topper;
						$c = $c + 1;
					}
				}
			}
		}
	
		$stulist_with_rank = array();
		foreach ($final_array as $student){
			foreach ($top_student as $top){
				if($student['student_id'] == $top['student_id']){
					$student['rank'] = $top['rank'];
					$stulist_with_rank[] = $student;
					break;
				}
			}
		}
	
		$data['s_list'] = $stulist_with_rank;
		$data['t_list'] = $top_student;
		return $data;
	}
	
	
	function classwise_final_high_class($data){
		$data2['class'] = $data['class_id'];
		$data2['section'] = $data['section'];
		$data2['medium'] = $data['medium'];
		$data2['school_id'] = $data['school_id'];
		$data2['session'] = $data['session'];
		$data2['type'] = 9;
	
		if($data['s_group'] == 'Maths'){
			$data2['s_group'] = 'maths';
		}
		else if($data['s_group'] == 'Boilogy'){
			$data2['s_group'] = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$data2['s_group'] = 'commer';
		}
		else{
			$data2['s_group'] = 'art';
		}
		$data1['teacher_abstract'] = $this->Teacher_model->teacher_abstract_final_class_mid($data2);
	
		if($data['class_id'] > 3 && $data['class_id'] < 9){
			$class_category = '1-5';
		}
		else if($data['class_id'] > 8 && $data['class_id'] < 13){
			$class_category = '6-9';
		}
		else if($data['class_id'] == 13){
			$class_category = '10th';
		}
		else if($data['class_id'] == 14){
			$class_category = '11th';
		}
		else if($data['class_id'] == 15){
			$class_category = '12th';
		}
		else{
			$class_category = 'primary';
		}
		$this->db->select('days');
		$result = $this->db->get_where('session_attendance',array('school_id'=>$data['school_id'],'class_category'=>$class_category,'term'=>'Mid','status'=>1))->result_array();
		$days = $result[0]['days'];
	
		$this->db->select('stu.*,c.name as cname,s.name as secname,concat(sa.present,"/'.$days.'") as present, DATE_FORMAT(stu.dob, "%d/%m/%Y") dob,DATE_FORMAT(stu.admission_date, "%d/%m/%Y") admission_date');
		$this->db->join('class c','c.c_id = stu.class_id');
		$this->db->join('section s','s.id = stu.section');
		$this->db->join('attendance_master am','am.class_id = stu.class_id');
		$this->db->join('student_atttendance sa','sa.a_master_id = am.a_id');
		$this->db->order_by('roll_no','ASC');
		$this->db->where('am.section_id','stu.section',false);
		$this->db->where('sa.student_id', 'stu.s_id',false);
		$students = $this->db->get_where('student stu',array('stu.class_id'=>$data['class_id'],'stu.section'=>$data['section'],'stu.school_id'=>$data['school_id'],'stu.medium'=>$data['medium'],'stu.session'=>$data['session'],'stu.subject_group'=>$data['s_group'],'am.term' => 'Mid','am.status'=>1,'stu.status'=>1))->result_array();
	
		$this->db->select('id');
		if($data['type'] == 'pre'){
			$this->db->where('e_type',9);
		}
		if($data['s_group'] == 'Maths'){
			$sgroup = 'maths';
		}
		else if($data['s_group'] == 'Boilogy'){
			$sgroup = 'bio';
		}
		else if($data['s_group'] == 'Commerce'){
			$sgroup = 'commer';
		}
		else{
			$sgroup = 'art';
		}
		$mark_masters = $this->db->get_where('high_class_mark_master',array(
				'school_id' => $data['school_id'],
				'class_id' => $data['class_id'],
				'section_id' => $data['section'],
				'medium' => $data['medium'],
				'e_type' => 9
		))->result_array();
	
		$mark_master_ids = array();
		foreach($mark_masters as $mark_master){
			array_push($mark_master_ids, $mark_master['id']);
		}
	
		$this->db->select('*');
		$this->db->where_in('hm_id',$mark_master_ids);
		$student_marks = $this->db->get('student_marks_high_class')->result_array();
	
		$this->db->select('distinct(sf.sub_id) as id,sf.subj_marks,ss.subject,ss.type');
		$this->db->join('subjects_11_12 ss','ss.id = sf.sub_id');
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>'mid','sf.class'=>$data['class_id']))->result_array();
	
		if($sgroup == 'maths'|| $sgroup == 'bio'){
			$subjects_order = array('5','9','10','11','12','1','2','3','4');
		}
		if($sgroup == 'commer'){
			$subjects_order = array('5','9','10','11','12','6','7','8');
		}
	
		$subject_order = array();
		foreach($subjects_order as $subject){
			foreach($subjects as $s){
				if($subject == $s['id']){
					$subject_order[] = $s;
				}
			}
		}
		$subjects = $subject_order;
	
		///////////////////////student detail with subject marks///////////////////////////////////
		$student_mark_n_detail = array();
		foreach($students as $student){
			$marks = array();
			foreach($subjects as $subject){
				$f = 1;
				foreach($student_marks as $student_mark){
					if($subject['id'] == $student_mark['subject_id'] && $student['s_id'] == $student_mark['student_id']){
						$mark['sub_id'] = $subject['id'];
						$mark['sub_name'] = $subject['subject'];
						$mark['sub_type'] = $subject['type'];
						$mark['subj_marks'] = $subject['subj_marks'];
						$mark['marks'] = $student_mark['marks'];
						$marks[] = $mark;
						$f = 0;
					}
				}
				if($f){
					$mark['sub_id'] = $subject['id'];
					$mark['sub_name'] = $subject['subject'];
					$mark['sub_type'] = $subject['type'];
					$mark['subj_marks'] = $subject['subj_marks'];
					$mark['marks'] = '-';
					$marks[] = $mark;
				}
			}
			$total_marks = 0;
			$out_of = 0;
			$temp = $student;
			$temp['flag'] = 1;
				
			foreach ($marks as $mark){
				if($mark['subj_marks'] == 100){
					$min_marks = 33;
				}
				else if($mark['subj_marks'] == 90){
					$min_marks = 30;
				}
				else if($mark['subj_marks'] == 80){
					$min_marks = 27;
				}
				else if($mark['subj_marks'] == 70){
					$min_marks = 23;
				}
				else if($mark['subj_marks'] == 50){
					$min_marks = 17;
				}
				if($mark['marks'] == 'A'){
					$mark['marks'] = 0;
					$temp['flag'] = 0;
				}
				if($mark['marks'] < $min_marks && $mark['marks'] != '-'){
					$temp['flag'] = 0;
				}
				if($mark['marks'] != '-'){
					$total_marks = $total_marks + $mark['marks'];
					$out_of = $out_of + $mark['subj_marks'];
				}
			}
				
			$temp['total'] = $total_marks;
			$temp['marks'] = $marks;
			$temp['out_of'] = $out_of;
			$temp['percent'] = $total_marks / $out_of ;
			$student_mark_n_detail[] = $temp;
		}
	
		////////////////computer science co-scholastics marks added/////////////////////////
	
		$only_pass_student = array();
		foreach($student_mark_n_detail as $student_marks){
			if($student_marks['flag']){
				$only_pass_student[] = $student_marks;
			}
		}
		//////////// sorting according to total marks //////////////////////////////
		$toppers = array();
		foreach ($only_pass_student as $key => $row){
			if(isset($row['percent'])){
				$toppers[$key] = $row['percent'];
			}
			else{
				$toppers[$key] = 0;
			}
		}
		array_multisort($toppers, SORT_DESC, $only_pass_student);
	
		$c =  0;
		$marks;
		$rank = 0;
		$top_student = array();
	
		foreach($only_pass_student as $topper){
			if($c == 0) {
				$marks = $topper['percent'];
				$rank = $rank + 1;
				$topper['rank'] = $rank;
				$top_student[] = $topper;
				$c = $c + 1;
			}
			else {
				if($topper['percent'] == $marks){
					$marks = $topper['percent'];
					$topper['rank'] = $rank;
					$top_student[] = $topper;
				}
				else if($topper['percent'] < $marks){
					$marks = $topper['percent'];
					$rank = $rank + 1;
					$topper['rank'] = $rank;
					$top_student[] = $topper;
					$c = $c + 1;
				}
			}
		}
	
		$new_array = array();
		foreach ($student_mark_n_detail as $student){
			$f = 1;
			$temp = array();
			foreach ($top_student as $top){
				if($student['s_id'] == $top['s_id']){
					$f = 0;
					$temp = $student;
					$temp['rank'] = $top['rank'];
					$new_array[] = $temp;
				}
			}
			if($f){
				$temp = $student;
				$temp['rank'] = 0;
				$new_array[] = $temp;
			}
		}
	
		$data1['student_with_rank'] = $new_array;
		$data1['top_list'] = $top_student;
		return $data1;
	}
}