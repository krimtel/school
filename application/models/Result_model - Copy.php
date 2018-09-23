<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result_model extends CI_Model {

	function current_session(){
		$this->db->select('session_id');
		$result = $this->db->get_where('session',array('status'=>1))->result_array();
		return $result[0]['session_id'];
	}
	
	function student_deatil($data){
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
		
		$school_id = $this->session->userdata('school_id');
		$data['session'] = $this->current_session();

		if(isset($data['type'])){
		    $result['student'] = $this->db->query("SELECT `s`.*, `c`.`name` as `cname`, `sec`.`name` as `sec_name`, `satt`.`days` as working_days, `sa`.`present` as `presentday`
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `s`.`s_id` = ".$data['s_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
		    
		    $result['mid_attendance'] = $this->db->query("SELECT `s`.*, `c`.`name` as `cname`, `sec`.`name` as `sec_name`, `satt`.`days` as working_days, `sa`.`present` as `presentday`
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `s`.`s_id` = ".$data['s_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Mid'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Mid'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
		    
		    $result['student'][0]['mid_days']  = $result['mid_attendance'][0]['working_days'];
		    $result['student'][0]['attend']  = $result['mid_attendance'][0]['presentday'];
		}
		else{
		$result['student'] = $this->db->query("SELECT `s`.*, `c`.`name` as `cname`, `sec`.`name` as `sec_name`, `satt`.`days` as working_days, `sa`.`present` as `presentday`
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `s`.`s_id` = ".$data['s_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Mid'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Mid'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
		}
		//print_r($result['student']); die; 
		
		if(count($result['student'])>0){
			$result['student'][0]['dob'] = date('d-m-Y',strtotime($result['student'][0]['dob']));
		}
		
$result_1 = array();
		foreach($result['student'] as $r){
			$temp = array();
if($school_id == 1){
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
		$result['student'] = $result_1;


		$this->db->select('s.sub_id,s.name as sname,s.subj_type');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class_id']))->result_array();
		
		if($class_category == '1-5'){
			$subjects = array_replace(array_flip(array('31','5','9','11')), $subjects);
			$temp = array();
			$sub_seq = array('31','5','9','11','18','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		else if($class_category == '6-9'){
			$temp = array();
			$sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		else if($class_category == '10th'){
			$temp = array();
			$sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		
		//////////////////marks master
		$this->db->select('*');
		$this->db->where_in('e_type',array(4,1));
		$marks_masters = $this->db->get_where('mark_master',array(
				'class_id'=> $data['class_id'],
				'section'=> $data['section_id'],
				'school_id' => $school_id,
		         'medium' => $data['medium'],
				'status' => 1
		))->result_array();
		
		$mm_ids = array();
		foreach($marks_masters as $marks_master){
			array_push($mm_ids, $marks_master['m_id']);
		}
		 
		///////////////student marks
		$this->db->select('*');
		$this->db->where_in('mm_id',$mm_ids);
		$student_marks = $this->db->get_where('student_mark',array('student_id'=>$data['s_id']))->result_array();
		
		/////////////////notebook
		$this->db->select('*');
		$this->db->where_in('mm_id',$mm_ids);
		$notebook_marks = $this->db->get_where('notebook_marks',array('student_id'=>$data['s_id']))->result_array();
		
		
		$scho_subj = array();
		$co_scho_subj = array();
		$internal_subj = array();
		
		foreach($subjects as $subject){
			if($subject['subj_type'] == 'Scholastic'){
				$temp['s_id'] = $subject['sub_id'];
				$temp['s_name'] = $subject['sname'];
				$scho_subj[] = $temp;
			}
			else if($subject['subj_type'] == 'Co-Scholastic'){
				$temp['s_id'] = $subject['sub_id'];
				$temp['s_name'] = $subject['sname'];
				$co_scho_subj[] = $temp;
			}
			else if($subject['subj_type'] == 'Internal_assessment'){
				$temp['s_id'] = $subject['sub_id'];
				$temp['s_name'] = $subject['sname'];
				$internal_subj[] = $temp;
			}
		}
		
		// Scholastic results //
		$scho_result = array();
		foreach($scho_subj as $scho_sub){
			foreach($student_marks as $student_mark){
				if($scho_sub['s_id'] == $student_mark['subject_id']){
					$temp['student_id']  = $student_mark['student_id'];
					$temp['sub_id'] = $scho_sub['s_id'];
					$temp['name'] = $scho_sub['s_name'];
					$temp['e_type'] = $student_mark['e_type'];
					$temp['mark'] = $student_mark['marks'];
					$scho_result[] = $temp;
				}
				else{
					continue;
				}
			}
		}
		
		$scho_notebook_result = array();
		foreach($scho_subj as $scho_sub){
			foreach($notebook_marks as $notebook_mark){
				if($scho_sub['s_id'] == $notebook_mark['subject_id']){
					$temp['student_id']  = $notebook_mark['student_id'];
					$temp['sub_id'] = $scho_sub['s_id'];
					$temp['name'] = $scho_sub['s_name'];
					$temp['e_type'] = $notebook_mark['e_type'];
					$temp['notebook_mark'] = $notebook_mark['notebook_mark'];
					$temp['subj_enrich'] = $notebook_mark['subj_enrich'];
					$scho_notebook_result[] = $temp;
				}
				else{
					continue;
				}
			}
		}
		$final = array();
		foreach($scho_result as $arr1){
			$f = 1;
			foreach($scho_notebook_result as $arr2){
				$temp = array();
				if($arr1['student_id'] == $arr2['student_id'] && $arr1['sub_id'] == $arr2['sub_id'] && $arr1['e_type'] == $arr2['e_type'] ){
					$temp['student_id'] = $arr1['student_id'];
					$temp['sub_id'] = $arr1['sub_id'];
					$temp['name'] = $arr1['name'];
					$temp['e_type'] = $arr1['e_type'];
					$temp['mark'] = $arr1['mark'];
					$temp['notebook_mark'] = $arr2['notebook_mark'];
					$temp['subj_enrich'] = $arr2['subj_enrich'];
					$final[] = $temp;
					$f = 0;
				}
			}
			if($f){
				$temp['student_id'] = $arr1['student_id'];
				$temp['sub_id'] = $arr1['sub_id'];
				$temp['name'] = $arr1['name'];
				$temp['e_type'] = $arr1['e_type'];
				$temp['mark'] = $arr1['mark'];
				$temp['notebook_mark'] = 0;
				$temp['subj_enrich'] = 0;
				$final[] = $temp;
			}
		}

		$final_1 = array();
		$f = 1;
		foreach ($final as $arra1){
			$temp = array();
			if($arra1['e_type'] == 1){ 
				$temp['student_id'] = $arra1['student_id'];
				$temp['sub_id'] = $arra1['sub_id'];
				$temp['name'] = $arra1['name'];
				$temp['pre_mark'] = $arra1['mark'];
				$f = 1;
				foreach ($final as $arra2){
					if($arra1['student_id'] == $arra2['student_id'] && $arra1['sub_id'] == $arra2['sub_id'] && $arra2['e_type'] == 4){
						if($arra2['mark'] == 'A'){
							$temp['mid_mark'] = 'Abst';
						}
						else{
							$temp['mid_mark'] = $arra2['mark'];
						}
						if($arra2['notebook_mark'] == 'A'){
							$temp['notebook_mark'] = 'Abst';
						}
						else{
							$temp['notebook_mark'] = $arra2['notebook_mark'];
						}
						if($arra2['subj_enrich'] == 'A'){
							$temp['subj_enrich'] = 'Abst';
						}
						else{
							$temp['subj_enrich'] = $arra2['subj_enrich'];
						}
						$final_1[] = $temp;
						$f = 0;
						break;
					}
				}
			}
			else{
				continue;
			}	
		}
		$co_scho_result = array();
		foreach($co_scho_subj as $co_scho_sub){
			foreach($student_marks as $student_mark){
				if($co_scho_sub['s_id'] == $student_mark['subject_id']){
					$temp = array();
					$temp['student_id']  = $student_mark['student_id'];
					$temp['sub_id'] = $co_scho_sub['s_id'];
					$temp['name'] = $co_scho_sub['s_name'];
					$temp['e_type'] = $student_mark['e_type'];
					if($student_mark['marks'] == 5){
						$temp['mark'] = 'A';
					}
					else if($student_mark['marks'] == 4){
						$temp['mark'] = 'B';
					}
					else if($student_mark['marks'] == 3){
						$temp['mark'] = 'A';
					}
					else if($student_mark['marks'] == 2){
						$temp['mark'] = 'B';
					}
					else if($student_mark['marks'] == 1){
						$temp['mark'] = 'C';
					}
					else if($student_mark['marks'] == 'A'){
						$temp['mark'] = 'Abst';
					}
					$co_scho_result[] = $temp;
				}
				else{
					continue;
				}
			}
		}
		$result['marks'] = $final_1;
		$result['co_marks'] = $co_scho_result;
		
		//if(count($result['marks'])>0){
			return $result;
// 		}
// 		else{
// 			return false;
// 		}
	}

	function mid_result($data){
		
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
		
		$school_id = $this->session->userdata('school_id');
		$data['session'] = $this->current_session();

		if($data['class_id'] == 12 ||$data['class_id'] == 13){
			if($data['fit'] == 'yes'){
				$fit = 1;
			}
			else{
				$fit = 0;
			}
		}
		
		if($data['class_id'] == 12 ||$data['class_id'] == 13){
		$result['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Mid'
			AND `am`.`status` = 1
			AND s.fit = ".$fit."
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Mid'
			AND s.medium = '".$data['medium']."'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
			$result_1 = array();
		}	
		else{
			$result['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Mid'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Mid'
			AND s.medium = '".$data['medium']."'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
			$result_1 = array();
		}
		foreach($result['student']as $r){
			$temp = array();
if($school_id == 1){
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
		$result['student'] = $result_1;

		
		$this->db->select('s.sub_id,s.name as sname,s.subj_type');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class_id']))->result_array();
		
		if($class_category == '1-5'){
			$subjects = array_replace(array_flip(array('31','5','9','11')), $subjects);
			$temp = array();
			$sub_seq = array('31','5','9','11','18','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		else if($class_category == '6-9'){
			$temp = array();
			$sub_seq = array('31','5','9','6','7','12','18','13','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		else if($class_category == '10th'){
			$temp = array();
			$sub_seq = array('31','5','9','6','7','12','18','13','19','20','21','22');
			$i = 0;
			foreach($sub_seq as $sub_s){
				foreach($subjects as $subject){
					if($i < count($sub_seq)){
						if($subject['sub_id'] == $sub_s){
							$temp[] = $subject;
							$i = $i + 1;
						}
					}
				}
			}
			$subjects = $temp;
		}
		
		$loop = array();
		foreach($result['student'] as $student){
			$inner_loop['student'] = $student;
			$student['dob'] = date('d-m-Y',strtotime($student['dob']));
		//////////////////marks master
			$this->db->select('*');
			$this->db->where_in('e_type',array(4,1));
			$marks_masters = $this->db->get_where('mark_master',array(
				'class_id'=> $data['class_id'],
				'section'=> $data['section_id'],
				'school_id' => $school_id,
				'status' => 1
			))->result_array();
		
			$mm_ids = array();
			foreach($marks_masters as $marks_master){
				array_push($mm_ids, $marks_master['m_id']);
			}
			
			//	/////////////student marks
			$this->db->select('*');
			$this->db->where_in('mm_id',$mm_ids);
			$student_marks = $this->db->get_where('student_mark',array('student_id'=>$student['s_id']))->result_array();
		
			/////////////////notebook
			$this->db->select('*');
			$this->db->where_in('mm_id',$mm_ids);
			$notebook_marks = $this->db->get_where('notebook_marks',array('student_id'=>$student['s_id']))->result_array();
		
		
			$scho_subj = array();
			$co_scho_subj = array();
			$internal_subj = array();
		
			foreach($subjects as $subject){
				if($subject['subj_type'] == 'Scholastic'){
					$temp['s_id'] = $subject['sub_id'];
					$temp['s_name'] = $subject['sname'];
					$scho_subj[] = $temp;
				}
				else if($subject['subj_type'] == 'Co-Scholastic'){
					$temp['s_id'] = $subject['sub_id'];
					$temp['s_name'] = $subject['sname'];
					$co_scho_subj[] = $temp;
				}
				else if($subject['subj_type'] == 'Internal_assessment'){
					$temp['s_id'] = $subject['sub_id'];
					$temp['s_name'] = $subject['sname'];
					$internal_subj[] = $temp;
				}
			}
		
			// Scholastic results //
			$scho_result = array();
			foreach($scho_subj as $scho_sub){
				foreach($student_marks as $student_mark){
					if($scho_sub['s_id'] == $student_mark['subject_id']){
						$temp['student_id']  = $student_mark['student_id'];
						$temp['sub_id'] = $scho_sub['s_id'];
						$temp['name'] = $scho_sub['s_name'];
						$temp['e_type'] = $student_mark['e_type'];
						$temp['mark'] = $student_mark['marks'];
						$scho_result[] = $temp;
					}
					else{
						continue;
					}
				}
			}
		
			$scho_notebook_result = array();
			foreach($scho_subj as $scho_sub){
				foreach($notebook_marks as $notebook_mark){
					if($scho_sub['s_id'] == $notebook_mark['subject_id']){
						$temp['student_id']  = $notebook_mark['student_id'];
						$temp['sub_id'] = $scho_sub['s_id'];
						$temp['name'] = $scho_sub['s_name'];
						$temp['e_type'] = $notebook_mark['e_type'];
						$temp['notebook_mark'] = $notebook_mark['notebook_mark'];
						$temp['subj_enrich'] = $notebook_mark['subj_enrich'];
						$scho_notebook_result[] = $temp;
					}
					else{
						continue;
					}
				}
			}
		
			$final = array();
			foreach($scho_result as $arr1){
				$f = 1;
				foreach($scho_notebook_result as $arr2){
					$temp = array();
					if($arr1['student_id'] == $arr2['student_id'] && $arr1['sub_id'] == $arr2['sub_id'] && $arr1['e_type'] == $arr2['e_type'] ){
						$temp['student_id'] = $arr1['student_id'];
						$temp['sub_id'] = $arr1['sub_id'];
						$temp['name'] = $arr1['name'];
						$temp['e_type'] = $arr1['e_type'];
						$temp['mark'] = $arr1['mark'];
						$temp['notebook_mark'] = $arr2['notebook_mark'];
						$temp['subj_enrich'] = $arr2['subj_enrich'];
						$final[] = $temp;
						$f = 0;
					}	
				}
				if($f){
					$temp['student_id'] = $arr1['student_id'];
					$temp['sub_id'] = $arr1['sub_id'];
					$temp['name'] = $arr1['name'];
					$temp['e_type'] = $arr1['e_type'];
					$temp['mark'] = $arr1['mark'];
					$temp['notebook_mark'] = 0;
					$temp['subj_enrich'] = 0;
					$final[] = $temp;
				}
			}
				
			$final_1 = array();
			foreach ($final as $arra1){
				$temp = array();
				if($arra1['e_type'] == 1){
					$temp['student_id'] = $arra1['student_id'];
					$temp['sub_id'] = $arra1['sub_id'];
					$temp['name'] = $arra1['name'];
					$temp['pre_mark'] = $arra1['mark'];
					foreach ($final as $arra2){
						if($arra1['student_id'] == $arra2['student_id'] && $arra1['sub_id'] == $arra2['sub_id'] && $arra2['e_type'] == 4){
							if($arra2['mark'] == 'A'){
								$temp['mid_mark'] = 'Abst';
							}
							else{
								$temp['mid_mark'] = $arra2['mark'];
							}
							if($arra2['notebook_mark'] == 'A'){
								$temp['notebook_mark'] = 'Abst';
							}
							else{
								$temp['notebook_mark'] = $arra2['notebook_mark'];
							}
							if($arra2['subj_enrich'] == 'A'){
								$temp['subj_enrich'] = 'Abst';
							}
							else{
								$temp['subj_enrich'] = $arra2['subj_enrich'];
							}
							$final_1[] = $temp;
							break;
						}
					}
				}
				else{
					continue;
				}
			}
		
			$co_scho_result = array();
			foreach($co_scho_subj as $co_scho_sub){
				foreach($student_marks as $student_mark){
					if($co_scho_sub['s_id'] == $student_mark['subject_id']){
						$temp = array();
						$temp['student_id']  = $student_mark['student_id'];
						$temp['sub_id'] = $co_scho_sub['s_id'];
						$temp['name'] = $co_scho_sub['s_name'];
						$temp['e_type'] = $student_mark['e_type'];
						if($student_mark['marks'] == 5){
							$temp['mark'] = 'A';
						}
						else if($student_mark['marks'] == 4){
							$temp['mark'] = 'B';
						}
						else if($student_mark['marks'] == 3){
							$temp['mark'] = 'A';
						}
						else if($student_mark['marks'] == 2){
							$temp['mark'] = 'B';
						}
						else if($student_mark['marks'] == 1){
							$temp['mark'] = 'C';
						}
						else if($student_mark['marks'] == 'A'){
							$temp['mark'] = 'Abst';
						}
						$co_scho_result[] = $temp;
					}
					else{
						continue;
					}
				}
			}
		
			$inner_loop['marks'] = $final_1;
			$inner_loop['co_marks'] = $co_scho_result;
			$loop[] = $inner_loop; 
		}
		return $loop;
	}

	function mid_result_classwise($data){
		$this->db->select('s.*,c.name as cname,sec.name as sec_name,am.working_days,sa.present as presentday');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section');
		$this->db->join('attendance_master am','1=1');
		$this->db->join('student_atttendance sa','sa.student_id = s.s_id');
		$result['student'] = $this->db->get_where('student s',array('am.session_id'=>$data['session'],'am.class_id'=>$data['class'],'section_id'=>$data['section'],'term'=>'Mid'))->result_array();
	}
	
	
	function student_deatil_high_class($data){
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
		
		$data['session'] = $this->current_session();
		$data['school_id'] = $this->session->userdata('school_id');
		
		$result['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$data['school_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'  
			AND s.s_id = '".$data['s_id']."'
			AND s.medium = '".$data['medium']."'
			AND s.subject_group = '".$data['sgroup']."'
			AND satt.school_id = ".$data['school_id']."
			AND satt.status = 1")->result_array();
		$result_1 = array();
		foreach($result['student'] as $r){
			$temp = array();
			if($data['school_id'] == 1){
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
			$result_1[] = $temp;
		}
		$result['student'] = $result_1;
		
		
		if(count($result['student']) > 0){
			$result['student'][0]['dob'] = date('d-m-Y',strtotime($result['student'][0]['dob']));
		}
		
		///////////////// for selecting elective subjects ////////////////////////
		if($result['student'][0]['elective'] == 23){
			$elective = 'CS';
		}
		if($result['student'][0]['elective'] == 26){
			$elective = 'Hindi';
		}
		if($result['student'][0]['elective'] == 27){
			$elective = 'PE';
		}
		if($result['student'][0]['elective'] == 28){
			$elective = 'Maths(opt)';
		}
		
		////////////////// for selecting subject group /////////////////////////
		if($data['sgroup'] == 'Maths'){
			$sgroup = 'maths';
		}
		if($data['sgroup'] == 'Boilogy'){
			$sgroup = 'Bio';
		}
		if($data['sgroup'] == 'Commerce'){
			$sgroup = 'commer';
		}
		
		$this->db->select('id,subject');
		$subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'type'=>'scholastic','e_type'=>1))->result_array();
		
		$this->db->select('id,subject');
		$elective_subject = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'subject'=>$elective,'type'=>'elective','e_type'=>1))->result_array();
		
		$subjects = array_merge($subjects,$elective_subject);
		
		
		$student_marks_pre = array();
		$student_marks_mid = array();
		
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$pre_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'pre',
				'sf.status' => 1,
				'hm.e_type' => 1
		))->result_array();
		
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$mid_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'mid',
				'sf.status' => 1,
				'hm.e_type' => 4
		))->result_array();
		
		$mark_master = array();
		foreach($pre_marks_masters as $m){
			array_push($mark_master, $m['id']);	
		}
		
		$mark_master_mid = array();
		foreach($mid_marks_masters as $m){
			array_push($mark_master_mid, $m['id']);
		}
			
		if(count($pre_marks_masters) > 0) {
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>1,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();
	        		
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master_mid);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks_mid = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>4,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();
			
			if(count($marks) > 0) {
				foreach($marks as $mark){
					$temp['hm_id'] =  $mark['hm_id'];
					$temp['e_type'] =  $mark['e_type'];
					$temp['student_id'] =  $mark['student_id'];
					$temp['subject_id'] =  $mark['subject_id'];
					$temp['marks'] =  $mark['marks'];
					$temp['p_marks'] =  $mark['p_marks'];
					$temp['sub_name'] = $mark['sub_name'];
					$student_marks_pre[] = $temp;
				}
			}
			
			if(count($marks_mid) > 0) {
				foreach($marks_mid as $mark_mid){
					$temp['hm_id'] = $mark_mid['hm_id'];
					$temp['e_type'] = $mark_mid['e_type'];
					$temp['student_id'] = $mark_mid['student_id'];
					$temp['subject_id'] = $mark_mid['subject_id'];
					$temp['marks'] = $mark_mid['marks'];
					$temp['p_marks'] = $mark_mid['p_marks'];
					$temp['sub_name'] = $mark_mid['sub_name'];
					$student_marks_mid[] = $temp;
				}
			}
		}
		
		$final = array_merge($student_marks_pre,$student_marks_mid);
		
		$sub = array();
		foreach($mid_marks_masters as $mid_marks_master){
			foreach($final as $f){
				if($mid_marks_master['subject'] == $f['subject_id']){
					if($f['e_type'] == 1){
						$temp['student_id'] = $f['student_id'];
						$temp['sub_id'] = $f['subject_id'];
						$temp['pre_mark'] = $f['marks'];
						$temp['sub_name'] = $f['sub_name'];
						$temp['practical'] = $mid_marks_master['practical'];
						foreach ($final as $f1){
							if($f['student_id'] == $f1['student_id'] && $f['subject_id'] == $f1['subject_id'] && $f1['e_type'] == 4){
								$temp['mid_mark'] = $f1['marks'];
								$temp['p_marks'] = $f1['p_marks'];
								$temp['max_sub_marks'] = $mid_marks_master['subj_marks'];
								$temp['max_practical_marks'] = $mid_marks_master['practical_mark'];
								$sub[] = $temp;
								break;
							}
						}
					}
				}
			}
		}
		
		$marks_final = array();
// 		$co_subjects = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
		$co_subjects = array('5','9','10','11','12','1','2','3','4','6','7','8','13','14','15','16','17');
		foreach($co_subjects as $co_subject){
			foreach($sub as $s){
				if($co_subject == $s['sub_id']){
					$marks_final[] = $s;
				}
			}
		}
		$sub = $marks_final;
		
		$co_marks = array();
		foreach($student_marks_mid as $student_co_marks){
			$temp = array();
			if($student_co_marks['subject_id'] == 13 || $student_co_marks['subject_id'] == 14 || $student_co_marks['subject_id'] == 15 || $student_co_marks['subject_id'] == 16 || $student_co_marks['subject_id'] == 17){
				$temp['student_id'] = $student_co_marks['student_id'];
				$temp['sub_id'] = $student_co_marks['subject_id'];
				$temp['mark'] = $student_co_marks['marks'];
				$temp['sub_name'] = $student_co_marks['sub_name'];
				$co_marks[] = $temp;
			}
		}
		
		
		$co_marks_final = array();
		$co_subjects = array('13','14','15','16','17');
		foreach($co_subjects as $co_subject){
			foreach($co_marks as $co_mark){
				if($co_subject == $co_mark['sub_id']){
					$co_marks_final[] = $co_mark;
				}
			}
		}
		$co_marks = $co_marks_final;
		$final_co_marks = array();
		foreach($co_marks as $co_mark){
			$temp = $co_mark;
			if($co_mark['mark'] == 5){
				$temp['mark'] = 'A';
			}
			else if($co_mark['mark'] == 4){
				$temp['mark'] = 'B';
			}
			else if($co_mark['mark'] == 3){
				$temp['mark'] = 'C';
			}
			else if($co_mark['mark'] == 2){
				$temp['mark'] = 'D';
			}
			else if($co_mark['mark'] == 1){
				$temp['mark'] = 'E';
			}
			else if($co_mark['mark'] == 'A'){
				$temp['marks'] = 'Abst';
			}
			$final_co_marks[] = $temp;
		}
		
		$result['final_marks'] = $sub;
		$result['co_marks'] = $final_co_marks;
		return $result;
	}
	
	
	function mid_result_high_class($data){
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
		$data['session'] = $this->current_session();
		$data['school_id'] = $this->session->userdata('school_id');
	
		$result_stu['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$data['school_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Mid'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Mid'
			AND s.medium = '".$data['medium']."'
			AND s.subject_group = '".$data['sgroup']."'
			AND satt.school_id = ".$data['school_id']."
			AND satt.status = 1")->result_array();
		
		$result_1 = array();
		$result_2 = array();
		foreach($result_stu['student'] as $r){
			$temp = array();
			if($data['school_id'] == 1){
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
			$result_2[] = $temp;
		}
		$result_stu['student'] = $result_2;
		
		$final_result = array();
		if(count($result_stu['student'])>0){
			foreach ($result_stu['student'] as $student){
				$student['dob'] = date('d-m-Y',strtotime($student['dob']));
				
				///////////////// for selecting elective subjects ////////////////////////
				if($student['elective'] == 23){
					$elective = 'CS';
				}
				if($student['elective'] == 26){
					$elective = 'Hindi';
				}
				if($student['elective'] == 27){
					$elective = 'PE';
				}
				if($student['elective'] == 28){
					$elective = 'Maths(opt)';
				}
				
				////////////////// for selecting subject group /////////////////////////
				if($data['sgroup'] == 'Maths'){
					$sgroup = 'maths';
				}
				if($data['sgroup'] == 'Boilogy'){
					$sgroup = 'Bio';
				}
				if($data['sgroup'] == 'Commerce'){
					$sgroup = 'commer';
				}
				
				$this->db->select('id,subject');
				$subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'type'=>'scholastic','e_type'=>1))->result_array();
				
				$this->db->select('id,subject');
				$elective_subject = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'subject'=>$elective,'type'=>'elective','e_type'=>1))->result_array();
				
				$subjects = array_merge($subjects,$elective_subject);
				
				$student_marks_pre = array();
				$student_marks_mid = array();
				
				$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
				$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
				$pre_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
						'hm.school_id' => $data['school_id'],
						'hm.class_id' => $data['class_id'],
						'hm.section_id' => $data['section_id'],
						'hm.medium' => $data['medium'],
						'sf.s_group' => $sgroup,
						'hm.s_group' => $sgroup,
						'sf.class' => $data['class_id'],
						'sf.e_type' => 'pre',
						'sf.status' => 1,
						'hm.e_type' => 1
				))->result_array();
				
				//print_r($pre_marks_masters); die;
				$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
				$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
				$mid_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
						'hm.school_id' => $data['school_id'],
						'hm.class_id' => $data['class_id'],
						'hm.section_id' => $data['section_id'],
						'hm.medium' => $data['medium'],
						'sf.s_group' => $sgroup,
						'hm.s_group' => $sgroup,
						'sf.class' => $data['class_id'],
						'sf.e_type' => 'mid',
						'sf.status' => 1,
						'hm.e_type' => 4
				))->result_array();
				
				$mark_master = array();
				foreach($pre_marks_masters as $m){
					array_push($mark_master, $m['id']);
				}
				
				$mark_master_mid = array();
				foreach($mid_marks_masters as $m){
					array_push($mark_master_mid, $m['id']);
				}
				
				if(count($pre_marks_masters) > 0) {
					$this->db->select('sm.*,s.subject as sub_name');
					$this->db->where_in('hm_id',$mark_master);
					$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
					$marks = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>1,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
				
					$this->db->select('sm.*,s.subject as sub_name');
					$this->db->where_in('hm_id',$mark_master_mid);
					$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
					$marks_mid = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>4,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
				
					if(count($marks) > 0) {
						foreach($marks as $mark){
							$temp['hm_id'] =  $mark['hm_id'];
							$temp['e_type'] =  $mark['e_type'];
							$temp['student_id'] =  $mark['student_id'];
							$temp['subject_id'] =  $mark['subject_id'];
							$temp['marks'] =  $mark['marks'];
							$temp['p_marks'] =  $mark['p_marks'];
							$temp['sub_name'] = $mark['sub_name'];
							$student_marks_pre[] = $temp;
						}
					}
				
					if(count($marks_mid) > 0) {
						foreach($marks_mid as $mark_mid){
							$temp['hm_id'] = $mark_mid['hm_id'];
							$temp['e_type'] = $mark_mid['e_type'];
							$temp['student_id'] = $mark_mid['student_id'];
							$temp['subject_id'] = $mark_mid['subject_id'];
							$temp['marks'] = $mark_mid['marks'];
							$temp['p_marks'] = $mark_mid['p_marks'];
							$temp['sub_name'] = $mark_mid['sub_name'];
							$student_marks_mid[] = $temp;
						}
					}
				}
				
				$final = array_merge($student_marks_pre,$student_marks_mid);
				$sub = array();
				foreach($mid_marks_masters as $mid_marks_master){
					foreach($final as $f){
						if($mid_marks_master['subject'] == $f['subject_id']){
							if($f['e_type'] == 1){
								$temp['student_id'] = $f['student_id'];
								$temp['sub_id'] = $f['subject_id'];
								$temp['pre_mark'] = $f['marks'];
								$temp['sub_name'] = $f['sub_name'];
								$temp['practical'] = $mid_marks_master['practical'];
								foreach ($final as $f1){
									if($f['student_id'] == $f1['student_id'] && $f['subject_id'] == $f1['subject_id'] && $f1['e_type'] == 4){
										$temp['mid_mark'] = $f1['marks'];
										$temp['p_marks'] = $f1['p_marks'];
										$temp['max_sub_marks'] = $mid_marks_master['subj_marks'];
										$temp['max_practical_marks'] = $mid_marks_master['practical_mark'];
										$sub[] = $temp;
										break;
									}
								}
							}
						}
					}
				}
				
				$marks_final = array();
				//$co_subjects = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
				$co_subjects = array('5','9','10','11','12','1','2','3','4','6','7','8','13','14','15','16','17');
				foreach($co_subjects as $co_subject){
					foreach($sub as $s){
						if($co_subject == $s['sub_id']){
							$marks_final[] = $s;
						}
					}
				}
				
				$sub = $marks_final;
				
				$co_marks = array();
				foreach($student_marks_mid as $student_co_marks){
					$temp = array();
					if($student_co_marks['subject_id'] == 13 || $student_co_marks['subject_id'] == 14 || $student_co_marks['subject_id'] == 15 || $student_co_marks['subject_id'] == 16 || $student_co_marks['subject_id'] == 17){
						$temp['student_id'] = $student_co_marks['student_id'];
						$temp['sub_id'] = $student_co_marks['subject_id'];
						$temp['mark'] = $student_co_marks['marks'];
						$temp['sub_name'] = $student_co_marks['sub_name'];
						$co_marks[] = $temp;
					}
				}
				
				$co_marks_final = array();
				$co_subjects = array('13','14','15','16','17');
				foreach($co_subjects as $co_subject){
					foreach($co_marks as $co_mark){
						if($co_subject == $co_mark['sub_id']){
							$co_marks_final[] = $co_mark;
						}
					}
				}
				
				$co_marks = $co_marks_final;
				$final_co_marks = array();
				foreach($co_marks as $co_mark){
					$temp = $co_mark;
					if($co_mark['mark'] == 5){
						$temp['mark'] = 'A';
					}
					else if($co_mark['mark'] == 4){
						$temp['mark'] = 'B';
					}
					else if($co_mark['mark'] == 3){
						$temp['mark'] = 'C';
					}
					else if($co_mark['mark'] == 2){
						$temp['mark'] = 'D';
					}
					else if($co_mark['mark'] == 1){
						$temp['mark'] = 'E';
					}
					else if($co_mark['mark'] == 'A'){
						$temp['marks'] = 'Abst';
					}
					$final_co_marks[] = $temp;
				}
				$result['student'] = $student;
				$result['final_marks'] = $sub;
				$result['co_marks'] = $final_co_marks;
				$final_result[] = $result;
			}//for
		}
		return $final_result;
	}
	
	
	
	////////////////////////////////////////////////////////////////////////
	function student_deatil_final($data){
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
	    
	    $school_id = $this->session->userdata('school_id');
	    $data['session'] = $this->current_session();
	    $result['student'] = $this->db->query("SELECT `s`.*, `c`.`name` as `cname`, `sec`.`name` as `sec_name`, `satt`.`days` as working_days, `sa`.`present` as `presentday`
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `s`.`s_id` = ".$data['s_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
	    
	    
	    if(count($result['student'])>0){
	        $result['student'][0]['dob'] = date('d-m-Y',strtotime($result['student'][0]['dob']));
	    }
	    
	    $result_1 = array();
	    foreach($result['student'] as $r){
	        $temp = array();
	        if($school_id == 1){
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
	        $result_1[] = $temp;
	}
	$result['student'] = $result_1;
	
	
	$this->db->select('s.sub_id,s.name as sname,s.subj_type');
	$this->db->join('subject s','s.sub_id = cs.subject_id');
	$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class_id']))->result_array();
	
	if($class_category == '1-5'){
	    $subjects = array_replace(array_flip(array('31','5','9','11')), $subjects);
	    $temp = array();
	    $sub_seq = array('31','5','9','11','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	else if($class_category == '6-9'){
	    $temp = array();
	    $sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	else if($class_category == '10th'){
	    $temp = array();
	    $sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	
	//////////////////marks master//////
	$this->db->select('*');
	$this->db->where_in('e_type',array(9,6));
	$marks_masters = $this->db->get_where('mark_master',array(
	    'class_id'=> $data['class_id'],
	    'section'=> $data['section_id'],
	    'school_id' => $school_id,
	    'medium' => $data['medium'],
	    'status' => 1
	))->result_array();

	$mm_ids = array();
	foreach($marks_masters as $marks_master){
	    array_push($mm_ids, $marks_master['m_id']);
	}
	
	///////////////student marks
	$this->db->select('*');
	$this->db->where_in('mm_id',$mm_ids);
	$student_marks = $this->db->get_where('student_mark',array('student_id'=>$data['s_id']))->result_array();
	
	/////////////////notebook
	$this->db->select('*');
	$this->db->where_in('mm_id',$mm_ids);
	$notebook_marks = $this->db->get_where('notebook_marks',array('student_id'=>$data['s_id']))->result_array();
	
	
	$scho_subj = array();
	$co_scho_subj = array();
	$internal_subj = array();
	
	foreach($subjects as $subject){
	    if($subject['subj_type'] == 'Scholastic'){
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $scho_subj[] = $temp;
	    }
	    else if($subject['subj_type'] == 'Co-Scholastic'){
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $co_scho_subj[] = $temp;
	    }
	    else if($subject['subj_type'] == 'Internal_assessment'){
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $internal_subj[] = $temp;
	    }
	}
	
	// Scholastic results //
	$scho_result = array();
	foreach($scho_subj as $scho_sub){
	    foreach($student_marks as $student_mark){
	        if($scho_sub['s_id'] == $student_mark['subject_id']){
	            $temp['student_id']  = $student_mark['student_id'];
	            $temp['sub_id'] = $scho_sub['s_id'];
	            $temp['name'] = $scho_sub['s_name'];
	            $temp['e_type'] = $student_mark['e_type'];
	            $temp['mark'] = $student_mark['marks'];
	            $scho_result[] = $temp;
	        }
	        else{
	            continue;
	        }
	    }
	}
	
	$scho_notebook_result = array();
	foreach($scho_subj as $scho_sub){
	    foreach($notebook_marks as $notebook_mark){
	        if($scho_sub['s_id'] == $notebook_mark['subject_id']){
	            $temp['student_id']  = $notebook_mark['student_id'];
	            $temp['sub_id'] = $scho_sub['s_id'];
	            $temp['name'] = $scho_sub['s_name'];
	            $temp['e_type'] = $notebook_mark['e_type'];
	            $temp['notebook_mark'] = $notebook_mark['notebook_mark'];
	            $temp['subj_enrich'] = $notebook_mark['subj_enrich'];
	            $scho_notebook_result[] = $temp;
	        }
	        else{
	            continue;
	        }
	    }
	}
	$final = array();
	foreach($scho_result as $arr1){
	    $f = 1;
	    foreach($scho_notebook_result as $arr2){
	        $temp = array();
	        if($arr1['student_id'] == $arr2['student_id'] && $arr1['sub_id'] == $arr2['sub_id'] && $arr1['e_type'] == $arr2['e_type'] ){
	            $temp['student_id'] = $arr1['student_id'];
	            $temp['sub_id'] = $arr1['sub_id'];
	            $temp['name'] = $arr1['name'];
	            $temp['e_type'] = $arr1['e_type'];
	            $temp['mark'] = $arr1['mark'];
	            $temp['notebook_mark'] = $arr2['notebook_mark'];
	            $temp['subj_enrich'] = $arr2['subj_enrich'];
	            $final[] = $temp;
	            $f = 0;
	        }
	    }
	    if($f){
	        $temp['student_id'] = $arr1['student_id'];
	        $temp['sub_id'] = $arr1['sub_id'];
	        $temp['name'] = $arr1['name'];
	        $temp['e_type'] = $arr1['e_type'];
	        $temp['mark'] = $arr1['mark'];
	        $temp['notebook_mark'] = 0;
	        $temp['subj_enrich'] = 0;
	        $final[] = $temp;
	    }
	}
	
	$final_1 = array();
	$f = 1;
	foreach ($final as $arra1){
	    $temp = array();
	    if($arra1['e_type'] == 6){
	        $temp['student_id'] = $arra1['student_id'];
	        $temp['sub_id'] = $arra1['sub_id'];
	        $temp['name'] = $arra1['name'];
	        $temp['pre_mark'] = $arra1['mark'];
	        $f = 1;
	        foreach ($final as $arra2){
	            if($arra1['student_id'] == $arra2['student_id'] && $arra1['sub_id'] == $arra2['sub_id'] && $arra2['e_type'] == 9){
	                if($arra2['mark'] == 'A'){
	                    $temp['mid_mark'] = 'Abst';
	                }
	                else{
	                    $temp['mid_mark'] = $arra2['mark'];
	                }
	                if($arra2['notebook_mark'] == 'A'){
	                    $temp['notebook_mark'] = 'Abst';
	                }
	                else{
	                    $temp['notebook_mark'] = $arra2['notebook_mark'];
	                }
	                if($arra2['subj_enrich'] == 'A'){
	                    $temp['subj_enrich'] = 'Abst';
	                }
	                else{
	                    $temp['subj_enrich'] = $arra2['subj_enrich'];
	                }
	                $final_1[] = $temp;
	                $f = 0;
	                break;
	            }
	        }
	    }
	    else{
	        continue;
	    }
	}
	$co_scho_result = array();
	foreach($co_scho_subj as $co_scho_sub){
	    foreach($student_marks as $student_mark){
	        if($co_scho_sub['s_id'] == $student_mark['subject_id']){
	            $temp = array();
	            $temp['student_id']  = $student_mark['student_id'];
	            $temp['sub_id'] = $co_scho_sub['s_id'];
	            $temp['name'] = $co_scho_sub['s_name'];
	            $temp['e_type'] = $student_mark['e_type'];
	            if($student_mark['marks'] == 5){
	                $temp['mark'] = 'A';
	            }
	            else if($student_mark['marks'] == 4){
	                $temp['mark'] = 'B';
	            }
	            else if($student_mark['marks'] == 3){
	                $temp['mark'] = 'A';
	            }
	            else if($student_mark['marks'] == 2){
	                $temp['mark'] = 'B';
	            }
	            else if($student_mark['marks'] == 1){
	                $temp['mark'] = 'C';
	            }
	            else if($student_mark['marks'] == 'A'){
	                $temp['mark'] = 'Abst';
	            }
	            $co_scho_result[] = $temp;
	        }
	        else{
	            continue;
	        }
	    }
	}
	$result['marks'] = $final_1;
	$result['co_marks'] = $co_scho_result;
	return $result;
}
	
	
	function student_final_result_ninth($data){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
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
	    
	    $school_id = $this->session->userdata('school_id');
	    $data['session'] = $this->current_session();
	    
	    $result['student'] = $this->db->query("SELECT `s`.*, `c`.`name` as `cname`, `sec`.`name` as `sec_name`, `satt`.`days` as working_days, `sa`.`present` as `presentday`
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$school_id."
			AND `s`.`s_id` = ".$data['s_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND satt.school_id = ".$school_id."
			AND satt.status = 1")->result_array();
	    
	    if(count($result['student'])>0){
	        $result['student'][0]['dob'] = date('d-m-Y',strtotime($result['student'][0]['dob']));
	    }
	    
	    $result_1 = array();
	    foreach($result['student'] as $r){
	        $temp = array();
	        if($school_id == 1){
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
	        $result_1[] = $temp;
	}
	$result['student'] = $result_1;
	
	
	$this->db->select('s.sub_id,s.name as sname,s.subj_type');
	$this->db->join('subject s','s.sub_id = cs.subject_id');
	$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class_id']))->result_array();
	
	if($class_category == '1-5'){
	    $subjects = array_replace(array_flip(array('31','5','9','11')), $subjects);
	    $temp = array();
	    $sub_seq = array('31','5','9','11','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	else if($class_category == '6-9'){
	    $temp = array();
	    $sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	else if($class_category == '10th'){
	    $temp = array();
	    $sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
	    $i = 0;
	    foreach($sub_seq as $sub_s){
	        foreach($subjects as $subject){
	            if($i < count($sub_seq)){
	                if($subject['sub_id'] == $sub_s){
	                    $temp[] = $subject;
	                    $i = $i + 1;
	                }
	            }
	        }
	    }
	    $subjects = $temp;
	}
	
	$scho_subj = array();
	$co_scho_subj = array();
	$internal_subj = array();
	
	foreach($subjects as $subject){
	    if($subject['subj_type'] == 'Scholastic'){
	        $temp = array();
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $scho_subj[] = $temp;
	    }
	    else if($subject['subj_type'] == 'Co-Scholastic'){
	        $temp = array();
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $co_scho_subj[] = $temp;
	    }
	    else if($subject['subj_type'] == 'Internal_assessment'){
	        $temp = array();
	        $temp['s_id'] = $subject['sub_id'];
	        $temp['s_name'] = $subject['sname'];
	        $internal_subj[] = $temp;
	    }
	}
	
	$this->db->select('*');
	$this->db->where_in('e_type',array(6,1,4));
	
	$marks_masters = $this->db->get_where('mark_master',array(
	    'class_id'=> $data['class_id'],
	    'section'=> $data['section_id'],
	    'school_id' => $school_id,
	    'medium' => $data['medium'],
	    'status' => 1
	))->result_array();
	
	$mm_ids = array();
	foreach($marks_masters as $marks_master){
	    array_push($mm_ids, $marks_master['m_id']);
	}
	
	$this->db->select('sm.*,s.name');
	$this->db->join('subject s','s.sub_id= sm.subject_id');
	$this->db->where_in('sm.mm_id',$mm_ids);
	$student_marks = $this->db->get_where('student_mark sm',array('sm.student_id'=>$data['s_id']))->result_array();
	
	$scho_notebook_result = array();
	foreach($scho_subj as $scho_sub){
		foreach($notebook_marks as $notebook_mark){
			if($scho_sub['s_id'] == $notebook_mark['subject_id']){
				$temp['student_id']  = $notebook_mark['student_id'];
				$temp['sub_id'] = $scho_sub['s_id'];
				$temp['name'] = $scho_sub['s_name'];
				$temp['e_type'] = $notebook_mark['e_type'];
				$temp['notebook_mark'] = $notebook_mark['notebook_mark'];
				$temp['subj_enrich'] = $notebook_mark['subj_enrich'];
				$scho_notebook_result[] = $temp;
			}
			else{
				continue;
			}
		}
	}
	
	$studentmarks = array();
	foreach($scho_subj as $schosubj){
    	foreach($student_marks as $student_mark){
    	    if($schosubj['s_id'] == $student_mark['subject_id']){
        	    if($student_mark['e_type'] == 1){
            	    foreach($student_marks as $student_mark2){
            	        if($student_mark2['e_type'] == 6){
            	        	foreach($student_marks as $student_mark3){
            	        		if($student_mark['subject_id'] == $student_mark2['subject_id'] && $student_mark['subject_id'] == $student_mark3['subject_id'] ){
            	        			if($student_mark3['e_type'] == 4){
	            	        			$temp = $student_mark;
	            	        			$temp['pre_mark'] = ((($student_mark['marks']*100)/50)/100)*10;
	            	        			$temp['post_mark'] = ((($student_mark2['marks']*100)/50)/100)*10;
	            	        			$temp['mid_marks'] = ((($student_mark3['marks']*100)/80)/100)*10;
	            	        			
	            	        			$numbers=array($temp['pre_mark'],$temp['post_mark'],$temp['mid_marks']);
	            	        			sort($numbers);
	            	        			
	            	        			$temp['priodic'] = round((($numbers[1] + $numbers[2])/2),2); 
	            	        			$studentmarks[] = $temp;
            	        			}
            	        		}
            	        	}
            	    	}
            	    }
        	    }
    	    }
    	}
	}
	$result['preiodic'] = $studentmarks;
	
	
	$this->db->select('*');
	$this->db->where_in('e_type',array(4,9));
	$marks_masters = $this->db->get_where('mark_master',array(
	    'class_id'=> $data['class_id'],
	    'section'=> $data['section_id'],
	    'school_id' => $school_id,
	    'medium' => $data['medium'],
	    'status' => 1
	))->result_array();
	
	$mm_ids = array();
	foreach($marks_masters as $marks_master){
	    array_push($mm_ids, $marks_master['m_id']);
	}
	
	$this->db->select('*');
	$this->db->where_in('mm_id',$mm_ids);
	$notebook_marks = $this->db->get_where('notebook_marks',array('student_id'=>$data['s_id']))->result_array();
	
	
	$studentmarks = array();
	foreach($scho_subj as $schosubj){
        foreach($notebook_marks as $notebook_mark){
            if($schosubj['s_id'] == $notebook_mark['subject_id']){
                if($notebook_mark['e_type'] == 4){
                    foreach($notebook_marks as $notebook_mark2){
                        if($notebook_mark2['e_type'] == 9){
                            if($notebook_mark['subject_id'] == $notebook_mark2['subject_id']){
                                $temp = array();
                                $temp = $notebook_mark;
                                $temp['p_marks'] = $notebook_mark2['p_marks'];
                                $temp['notebook'] = (($notebook_mark['notebook_mark'] + $notebook_mark2['notebook_mark']) / 2);
                                $temp['subjenrich'] = (($notebook_mark['subj_enrich'] + $notebook_mark2['subj_enrich']) / 2);
                                $studentmarks[] = $temp;
                            }
                        }
                    }
                }
            }
        }
	}
	$result['notebook_marks'] = $studentmarks;
	
	$this->db->select('*');
	$this->db->where_in('e_type',array(6,9));
	$marks_masters = $this->db->get_where('mark_master',array(
	    'class_id'=> $data['class_id'],
	    'section'=> $data['section_id'],
	    'school_id' => $school_id,
	    'medium' => $data['medium'],
	    'status' => 1
	))->result_array();
	
	$mm_ids = array();
	foreach($marks_masters as $marks_master){
	    array_push($mm_ids, $marks_master['m_id']);
	}
	
	$this->db->select('*');
	$this->db->where_in('mm_id',$mm_ids);
	$student_marks = $this->db->get_where('student_mark',array('student_id'=>$data['s_id']))->result_array();
	
	$final_1 = array();
	$f = 1;
	foreach($scho_subj as $schosubj){
    	foreach ($student_marks as $arra1){
    	    if($schosubj['s_id'] == $arra1['subject_id']){
        	    $temp = array();
        	    if($arra1['e_type'] == 6){
        	        $temp['student_id'] = $arra1['student_id'];
        	        $temp['sub_id'] = $arra1['subject_id'];
        	        $temp['mid_mark'] = $arra1['marks'];
        	        $f = 1;
        	        foreach ($student_marks as $arra2){
        	            if($arra1['student_id'] == $arra2['student_id'] && $arra1['subject_id'] == $arra2['subject_id'] && $arra2['e_type'] == 9){
        	                if($arra2['marks'] == 'A'){
        	                    $temp['annual_mark'] = 'Abst';
        	                }
        	                else{
        	                    $temp['annual_mark'] = $arra2['marks'];
        	                }
        	                $final_1[] = $temp;
        	                $f = 0;
        	                break;
        	            }
        	        }
        	    }
        	    else{
        	        continue;
        	    }
    	    }
    	}
	}
	$result['annual'] = $final_1;
	 
	
	
	$final_output = array();
	$final_array['marks'] = array();
	$back = array();
	$x = 5;
	$exam = 1;
	$extra_no = 0;
	$get_extra = 0;
	$extra_counter = 0;
	foreach($result['preiodic'] as $preiodic){
	    foreach($result['notebook_marks'] as $notebook){
	        foreach($result['annual'] as $annual){
	            if($preiodic['subject_id'] == $notebook['subject_id'] && $preiodic['subject_id'] == $annual['sub_id']){
	                $temp = array();
	                $temp['sub_name'] = $preiodic['name'];
	                $temp['priodic'] = $preiodic['priodic'];
	                $temp['notebook'] = $notebook['notebook'];
	                $temp['subjenrich'] = $notebook['subjenrich'];
	                $temp['annual_mark'] = $annual['annual_mark'];
	                $temp['annualsub_total'] = $preiodic['priodic'] + $notebook['notebook'] + $notebook['subjenrich'] + $annual['annual_mark'];
	                $temp['thory'] = $annual['annual_mark'];
	                $temp['practical'] = $notebook['p_marks'];
	                
	                if($preiodic['subject_id'] == 13){
	                	$min_marks = 14;
	                }
	                else{
	                	$min_marks = 27;
	                }
	                if($temp['annual_mark'] < $min_marks){
	                	$extra = $min_marks - $temp['annual_mark'];
	                	$x = 5 - $extra_no;
                		$x  = $x - ceil($extra);
                		if($x > 0){
                			$temp['annual_mark'] = $temp['annual_mark'];
                			$temp['extra'] = ceil($extra);
                			$extra_no = $extra_no + ceil($extra);
                			$temp['stars'] = '**';
                			$get_extra = 1;
                			$back['get_extra'] = 1;
                		}
                		else{
                			$temp['stars'] = '*';
                			if($exam < 2){
	                			$back['subject'] = $preiodic['name'];
	                			$back['subject_id'] = $preiodic['subject_id'];
	                			$back['category'] = 'Compartment';
	                			$final_array['back'] = $back;
	                			$temp['extra'] = 0;
	                			$exam = $exam + 1;
                			}
                			else{
                				$back['category'] = 'Detained';
                				$final_array['back'] = $back;
                				$temp['extra'] = 0;
                				$exam = $exam + 1;
                			}
	                	}
	                }
	                else{
	                	$temp['stars'] = ' ';
	                	$temp['extra'] = 0;
	                }
	                
	                if($temp['annualsub_total'] >= 91){
	                    $temp['grade'] = 'A1';
	                }
	                else if($temp['annualsub_total'] >= 81 && $temp['annualsub_total'] <= 90){
	                    $temp['grade'] = 'A2';
	                }
	                else if($temp['annualsub_total'] >= 71 && $temp['annualsub_total'] <= 80){
	                    $temp['grade'] = 'B1';
	                }
	                else if($temp['annualsub_total'] >= 61 && $temp['annualsub_total'] <= 70){
	                    $temp['grade'] = 'B2';
	                }
	                else if($temp['annualsub_total'] >= 51 && $temp['annualsub_total'] <= 60){
	                    $temp['grade'] = 'C1';
	                }
	                else if($temp['annualsub_total'] >= 41 && $temp['annualsub_total'] <= 50){
	                    $temp['grade'] = 'C2';
	                }
	                else if($temp['annualsub_total'] >= 33 && $temp['annualsub_total'] <= 40){
	                    $temp['grade'] = 'D';
	                }
	                else{
	                    $temp['grade'] = 'E';
	                }
	                $final_array['marks'][] = $temp;
	            }
	        }
	    }
	}
	$final_array['get_extra'] = $get_extra;
	
	$co_scho_result = array();
	foreach($co_scho_subj as $co_scho_sub){
		foreach($student_marks as $student_mark){
			if($co_scho_sub['s_id'] == $student_mark['subject_id']){
				$temp = array();
				$temp['student_id']  = $student_mark['student_id'];
				$temp['sub_id'] = $co_scho_sub['s_id'];
				$temp['name'] = $co_scho_sub['s_name'];
				$temp['e_type'] = $student_mark['e_type'];
				if($student_mark['marks'] == 5){
					$temp['mark'] = 'A';
				}
				else if($student_mark['marks'] == 4){
					$temp['mark'] = 'B';
				}
				else if($student_mark['marks'] == 3){
					$temp['mark'] = 'A';
				}
				else if($student_mark['marks'] == 2){
					$temp['mark'] = 'B';
				}
				else if($student_mark['marks'] == 1){
					$temp['mark'] = 'C';
				}
				else if($student_mark['marks'] == 'A'){
					$temp['mark'] = 'Abst';
				}
				$co_scho_result[] = $temp;
			}
			else{
				continue;
			}
		}
	}
	$final_array['co_marks'] = $co_scho_result;
	$final_array['student'] = $result['student'];
	if($back['get_extra']){
		
	}
	else{
		$back['get_extra'] = 0; 
	}
	return $final_array;
	}

	
	/////////////////////////////////////
	/////////////////////////////////////
	
	
	
	function final_result($data){
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
	    
	    $school_id = $this->session->userdata('school_id');
	    $data['session'] = $this->current_session();
	    
	    
	    $this->db->select('s.sub_id,s.name as sname,s.subj_type');
	    $this->db->join('subject s','s.sub_id = cs.subject_id');
	    $subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class_id']))->result_array();
	    
	    if($class_category == '1-5'){
	    	$subjects = array_replace(array_flip(array('31','5','9','11')), $subjects);
	    	$temp = array();
	    	$sub_seq = array('31','5','9','11','18','19','20','21','22');
	    	$i = 0;
	    	foreach($sub_seq as $sub_s){
	    		foreach($subjects as $subject){
	    			if($i < count($sub_seq)){
	    				if($subject['sub_id'] == $sub_s){
	    					$temp[] = $subject;
	    					$i = $i + 1;
	    				}
	    			}
	    		}
	    	}
	    	$subjects = $temp;
	    }
	    else if($class_category == '6-9'){
	    	$temp = array();
	    	$sub_seq = array('31','5','9','6','7','12','13','18','19','20','21','22');
	    	$i = 0;
	    	foreach($sub_seq as $sub_s){
	    		foreach($subjects as $subject){
	    			if($i < count($sub_seq)){
	    				if($subject['sub_id'] == $sub_s){
	    					$temp[] = $subject;
	    					$i = $i + 1;
	    				}
	    			}
	    		}
	    	}
	    	$subjects = $temp;
	    }
	    
	    $where = array(
	    		'session'=>(int)$data['session'],
	    		'school_id'=>(int)$data['school'],
	    		'class_id'=>(int)$data['class_id'],
	    		'section'=>(int)$data['section_id'],
	    		'medium'=>$data['medium']
	    		);
	    $this->db->select('*');
	    $result['students'] = $this->db->get_where('student',$where)->result_array();
	    $student_result = array();
	 	if(count($result['students']) > 0){ 
	 		foreach($result['students'] as $student){
	 			$data['s_id'] = $student['s_id'];
				$result1['student_detail'] = $this->student_deatil($data);
				$result1['student_deatil_final'] = $this->student_deatil_final($data);
				$student_result[] = $result1;
	 		}
	 	return $student_result;
		}
		
	}
	
	///////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////
	
	function student_deatil_high_class_final($data){
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
	
		$data['session'] = $this->current_session();
		$data['school_id'] = $this->session->userdata('school_id');
	
		$result['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$data['school_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND s.s_id = '".$data['s_id']."'
			AND s.medium = '".$data['medium']."'
			AND s.subject_group = '".$data['sgroup']."'
			AND satt.school_id = ".$data['school_id']."
			AND satt.status = 1")->result_array();
		
		$result_1 = array();
		foreach($result['student'] as $r){
			$temp = array();
			if($data['school_id'] == 1){
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
			$result_1[] = $temp;
		}
		$result['student'] = $result_1;
	
	
		if(count($result['student']) > 0){
			$result['student'][0]['dob'] = date('d-m-Y',strtotime($result['student'][0]['dob']));
		}
	
		///////////////// for selecting elective subjects ////////////////////////
		if($result['student'][0]['elective'] == 23){
			$elective = 'CS';
		}
		if($result['student'][0]['elective'] == 26){
			$elective = 'Hindi';
		}
		if($result['student'][0]['elective'] == 27){
			$elective = 'PE';
		}
		if($result['student'][0]['elective'] == 28){
			$elective = 'Maths(opt)';
		}
	
		////////////////// for selecting subject group /////////////////////////
		if($data['sgroup'] == 'Maths'){
			$sgroup = 'maths';
		}
		if($data['sgroup'] == 'Boilogy'){
			$sgroup = 'Bio';
		}
		if($data['sgroup'] == 'Commerce'){
			$sgroup = 'commer';
		}
	
		$this->db->select('id,subject');
		$subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'type'=>'scholastic','e_type'=>1))->result_array();
		
		$this->db->select('id,subject');
		$elective_subject = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'subject'=>$elective,'type'=>'elective','e_type'=>1))->result_array();
		
		$subjects = array_merge($subjects,$elective_subject);
	
		$student_marks_pre = array();
		$student_marks_mid = array();
		$student_marks_post = array();
		$student_marks_final = array();
	
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$pre_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'pre',
				'sf.status' => 1,
				'hm.e_type' => 1
		))->result_array();
		
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$mid_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'mid',
				'sf.status' => 1,
				'hm.e_type' => 4
		))->result_array();
		
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$post_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'post',
				'sf.status' => 1,
				'hm.e_type' => 6
		))->result_array();
		
		$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
		$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
		$final_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
				'hm.school_id' => $data['school_id'],
				'hm.class_id' => $data['class_id'],
				'hm.section_id' => $data['section_id'],
				'hm.medium' => $data['medium'],
				'sf.s_group' => $sgroup,
				'hm.s_group' => $sgroup,
				'sf.class' => $data['class_id'],
				'sf.e_type' => 'final',
				'sf.status' => 1,
				'hm.e_type' => 9
		))->result_array();
		
		$mark_master = array();
		foreach($pre_marks_masters as $m){
			array_push($mark_master, $m['id']);
		}
	
		$mark_master_mid = array();
		foreach($mid_marks_masters as $m){
			array_push($mark_master_mid, $m['id']);
		}
		
		$mark_master_post = array();
		foreach($post_marks_masters as $m){
			array_push($mark_master_post, $m['id']);
		}
		
		$mark_master_final = array();
		foreach($final_marks_masters as $m){
			array_push($mark_master_final, $m['id']);
		}
			
		if(count($pre_marks_masters) > 0) {
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>1,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();
			
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master_mid);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks_mid = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>4,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();
			
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master_post);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks_post = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>6,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();
			
			$this->db->select('sm.*,s.subject as sub_name');
			$this->db->where_in('hm_id',$mark_master_final);
			$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
			$marks_final = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>9,'sm.student_id'=>$data['s_id'],'sm.status'=>1))->result_array();

			if(count($marks) > 0) {
				foreach($marks as $mark){
					$temp = array();
					foreach($pre_marks_masters as $pmm){
						if($mark['subject_id'] == $pmm['subject']){
							$temp['hm_id'] =  $mark['hm_id'];
							$temp['e_type'] =  $mark['e_type'];
							$temp['student_id'] =  $mark['student_id'];
							$temp['subject_id'] =  $mark['subject_id'];
							$temp['subject_marks'] = 50;
							$temp['marks'] =  $mark['marks'];
							$temp['p_marks'] =  $mark['p_marks'];
							$temp['sub_name'] = $mark['sub_name'];
							$student_marks_pre[] = $temp;
						}
					}
				}
			}
				
			if(count($marks_mid) > 0) {
				foreach($marks_mid as $mark_mid){
					foreach($mid_marks_masters as $mmm){
						if($mark_mid['subject_id'] == $mmm['subject']){
							$temp = array();
							$temp['hm_id'] = $mark_mid['hm_id'];
							$temp['e_type'] = $mark_mid['e_type'];
							$temp['student_id'] = $mark_mid['student_id'];
							$temp['subject_id'] = $mark_mid['subject_id'];
							$temp['subject_marks'] = $mmm['subj_marks'];
							$temp['marks'] = $mark_mid['marks'];
							$temp['p_marks'] = $mark_mid['p_marks'];
							$temp['sub_name'] = $mark_mid['sub_name'];
							$student_marks_mid[] = $temp;
						}
					}
				}
			}
			
			
			if(count($marks_post) > 0) {
				foreach($marks_post as $mark_post){
					foreach($post_marks_masters as $pmm){
						if($mark_post['subject_id'] == $pmm['subject']){
							$temp = array();
							$temp['hm_id'] = $mark_post['hm_id'];
							$temp['e_type'] = $mark_post['e_type'];
							$temp['student_id'] = $mark_post['student_id'];
							$temp['subject_id'] = $mark_post['subject_id'];
							$temp['subject_marks'] = $pmm['subj_marks'];
							$temp['marks'] = $mark_post['marks'];
							$temp['p_marks'] = $mark_post['p_marks'];
							$temp['sub_name'] = $mark_post['sub_name'];
							$student_marks_post[] = $temp;
						}
					}
				}
			}
			
			if(count($marks_final) > 0) {
				foreach($marks_final as $mark_final){
					foreach($final_marks_masters as $fmm){
						if($mark_final['subject_id'] == $fmm['subject']){
							$temp = array();
							$temp['hm_id'] = $mark_final['hm_id'];
							$temp['e_type'] = $mark_final['e_type'];
							$temp['student_id'] = $mark_final['student_id'];
							$temp['subject_id'] = $mark_final['subject_id'];
							$temp['subject_marks'] = $fmm['subj_marks'];
							$temp['marks'] = $mark_final['marks'];
							$temp['p_marks'] = $mark_final['p_marks'];
							$temp['sub_name'] = $mark_final['sub_name'];
							$student_marks_final[] = $temp;
						}
					}
				}
			}
		}
		
		$total_obtain_marks = 0;
		$x = 5;
		$exam = 1;
		$extra_no = 0;
		$get_extra = 0;
		$extra_counter = 0;
		$final_array = array();
		foreach($student_marks_pre as $smp){
			foreach($student_marks_mid as $smm){
				foreach($student_marks_post as $smpo){
					foreach($student_marks_final as $smf){
						if($smp['subject_id'] == $smm['subject_id'] && $smm['subject_id'] == $smpo['subject_id'] && $smm['subject_id'] == $smf['subject_id']){
							$temp = array();
							$temp['subject_name'] = $smpo['sub_name'];
							$temp['sub_id'] = $smpo['subject_id'];
							$temp['post_mid_marks'] = $smpo['marks'];
							$temp['final_thory_marks_max'] = $smf['subject_marks'];
							$temp['final_thory_marks_obtain'] = $smf['marks'];
							$temp['final_practical_marks_max'] = 100 - $smf['subject_marks'];
							if($temp['final_practical_marks_max'] == 0){
								$temp['final_practical_marks_max'] = 'NA';
								$temp['final_practical_marks_obtail'] = 'NA';
							}
							else{
								$temp['final_practical_marks_obtail'] = $smf['p_marks'];
							}
							
							$temp['annual_total'] = $temp['final_thory_marks_obtain'] + $temp['final_practical_marks_obtail'];  
							$temp['pre_5'] = round((((($smp['marks']*100)/$smp['subject_marks'])*5)/100),2);
							$temp['mid_20'] = round((((($smm['marks']*100)/$smm['subject_marks'])*20)/100),2);
							$temp['post_5'] = round((((($smpo['marks']*100)/$smpo['subject_marks'])*5)/100),2);
							
							//$temp['final_thory_60'] = round((((($smf['marks']*100)/$smf['subject_marks'])*60)/100),2);
							$temp['final_thory_60'] = round((($smf['marks']*60)/100),2);
							//$temp['final_practical_60'] = round(((($smf['p_marks']*100)/$temp['final_practical_marks_max'])*60/100),2);
							if($temp['final_practical_marks_max'] == 0){
								$temp['final_practical_60'] = 'NA';
							}
							else{
								$temp['final_practical_60'] = round((($smf['p_marks']*60)/100),2);
							}
							$temp['final_thory_practical'] = round(($temp['final_practical_60'] + $temp['final_thory_60']),2);
							$temp['academic_attention'] = 9;
							$temp['grand_total'] = $temp['pre_5'] + $temp['mid_20'] + $temp['post_5'] + $temp['final_thory_practical'] + $temp['academic_attention'];
							
							//$total_obtain_marks = $total_obtain_marks + $temp['final_thory_marks_obtain'] + $temp['final_practical_marks_obtail'];
							$total_obtain_marks = $total_obtain_marks + $temp['grand_total'];
							if($temp['final_thory_marks_obtain'] < round(($temp['final_thory_marks_max']*33)/100)){
								$extra = round(($temp['final_thory_marks_max']*33)/100) - $temp['final_thory_marks_obtain'];
								$x = 5 - $extra_no;
								$x  = $x - ceil($extra);
								if($x > 0){
									$temp['extra'] = ceil($extra);
									$extra_no = $extra_no + ceil($extra);
									$temp['stars'] = '**';
									$get_extra = 1;
									$back['get_extra'] = 1;
								}
								else{
									$temp['stars'] = '*';
									if($exam < 2){
										$back['subject'] = $smpo['sub_name'];
										$back['category'] = 'Compartment';
										$result['back'] = $back;
										$temp['extra'] = 0;
										$exam = $exam + 1;
									}
									else{
										$back['category'] = 'Detained';
										$result['back'] = $back;
										$temp['extra'] = 0;
										$exam = $exam + 1;
									}
								}
							}
							else{
								$temp['stars'] = ' ';
								$temp['extra'] = 0;
							}
							$grand_total = ceil($temp['grand_total']);
							if($grand_total >= 91){
								$temp['grade'] = 'A1';
							}
							else if($grand_total >= 81 && $grand_total <= 90){
								$temp['grade'] = 'A2';
							}
							else if($grand_total >= 71 && $grand_total <= 80){
								$temp['grade'] = 'B1';
							}
							else if($grand_total >= 61 && $grand_total <= 70){
								$temp['grade'] = 'B2';
							}
							else if($grand_total >= 51 && $grand_total <= 60){
								$temp['grade'] = 'C1';
							}
							else if($grand_total >= 41 && $grand_total <= 50){
								$temp['grade'] = 'C2';
							}
							else if($grand_total >= 33 && $grand_total <= 40){
								$temp['grade'] = 'D';
							}
							else{
								$temp['grade'] = 'E';
							}
							$final_array[] = $temp;
						}
					}
				}
			}
		}
		
		
		$marks_final = array();
		// 		$co_subjects = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
		$co_subjects = array('5','9','10','11','12','1','2','3','4','6','7','8','13','14','15','16','17');
		foreach($co_subjects as $co_subject){
			foreach($final_array as $s){
				if($co_subject == $s['sub_id']){
					$marks_final[] = $s;
				}
			}
		}
		//$sub = $marks_final;
		
		$co_marks = array();
		foreach($student_marks_mid as $student_co_marks){
			foreach($student_marks_final as $student_co_marks_final){
				if($student_co_marks['subject_id'] == $student_co_marks_final['subject_id']){
					$temp = array();
					if($student_co_marks['subject_id'] == 13 || $student_co_marks['subject_id'] == 14 || $student_co_marks['subject_id'] == 15 || $student_co_marks['subject_id'] == 16 || $student_co_marks['subject_id'] == 17){
						$temp['student_id'] = $student_co_marks['student_id'];
						$temp['sub_id'] = $student_co_marks['subject_id'];
						$temp['mark_mid'] = $student_co_marks['marks'];
						$temp['mark_final'] = $student_co_marks_final['marks'];
						$temp['total'] = round(($temp['mark_mid'] + $temp['mark_final'])/2);  
						$temp['sub_name'] = $student_co_marks['sub_name'];
						$co_marks[] = $temp;
					}
				}
			}
		}
	
	
		$co_marks_final = array();
		$co_subjects = array('13','14','15','16','17');
		foreach($co_subjects as $co_subject){
			foreach($co_marks as $co_mark){
				if($co_subject == $co_mark['sub_id']){
					$co_marks_final[] = $co_mark;
				}
			}
		}
		$co_marks = $co_marks_final;
		$final_co_marks = array();
		foreach($co_marks as $co_mark){
			$temp = $co_mark;
			if($co_mark['mark_mid'] == 5){
				$temp['mark_mid'] = 'A';
			}
			else if($co_mark['mark_mid'] == 4){
				$temp['mark_mid'] = 'B';
			}
			else if($co_mark['mark_mid'] == 3){
				$temp['mark_mid'] = 'C';
			}
			else if($co_mark['mark_mid'] == 2){
				$temp['mark_mid'] = 'D';
			}
			else if($co_mark['mark_mid'] == 1){
				$temp['mark_mid'] = 'E';
			}
			else if($co_mark['mark_mid'] == 'A'){
				$temp['mark_mid'] = 'Abst';
			}
			
			if($co_mark['mark_final'] == 5){
				$temp['mark_final'] = 'A';
			}
			else if($co_mark['mark_final'] == 4){
				$temp['mark_final'] = 'B';
			}
			else if($co_mark['mark_final'] == 3){
				$temp['mark_final'] = 'C';
			}
			else if($co_mark['mark_final'] == 2){
				$temp['mark_final'] = 'D';
			}
			else if($co_mark['mark_final'] == 1){
				$temp['mark_final'] = 'E';
			}
			else if($co_mark['mark_final'] == 'A'){
				$temp['mark_final'] = 'Abst';
			}
			
			if($co_mark['total'] == 5){
				$temp['total'] = 'A';
			}
			else if($co_mark['total'] == 4){
				$temp['total'] = 'B';
			}
			else if($co_mark['total'] == 3){
				$temp['total'] = 'C';
			}
			else if($co_mark['total'] == 2){
				$temp['total'] = 'D';
			}
			else if($co_mark['total'] == 1){
				$temp['total'] = 'E';
			}
			else if($co_mark['total'] == 'A'){
				$temp['total'] = 'Abst';
			}
			$final_co_marks[] = $temp;
		}
		
		$result['final_marks'] = $marks_final;
		$result['co_marks'] = $final_co_marks;
		$result['total_obtail'] = round($total_obtain_marks);
		$result['percent'] = ($result['total_obtail'] * 100)/500;
		$result['get_extra'] = $get_extra;
		//$result['back'] = $final_array1;
		$final_array = array();
		$final_array[] = $result;
		return $final_array;
	}
	
	function student_deatil_high_class_final_loop($data){
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
	
		$data['session'] = $this->current_session();
		$data['school_id'] = $this->session->userdata('school_id');
	
		$students = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$data['school_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND s.medium = '".$data['medium']."'
			AND s.subject_group = '".$data['sgroup']."'
			AND satt.school_id = ".$data['school_id']."
			AND satt.status = 1")->result_array();
		
		$loop_array = array();
		foreach($students as $student){
			$result['student'] = $this->db->query("select s.s_id,s.admission_no,s.session,s.roll_no,s.school_id,s.class_id,s.section,s.name,s.father_name,s.mother_name,s.gender,s.cast,s.contact_no,s.email_id,s.aadhar,s.height,s.weight,s.address,s.medium,s.subject_group,s.fit,s.elective,s.house,s.hostler,s.blood_group,s.guardian,s.local_address,s.medical,s.tc,s.photo,s.admission_date,s.created_at,s.created_by,s.ip,DATE_FORMAT(s.dob,'%d-%m-%Y') as dob,c.name as cname,sec.name as sec_name,satt.days as working_days,sa.present as presentday
			FROM `student` `s`
			JOIN `class` `c` ON `c`.`c_id` = `s`.`class_id`
			JOIN `section` `sec` ON `sec`.`id` = `s`.`section`
			JOIN `attendance_master` `am` ON 1=1
			JOIN `session_attendance` `satt` ON 1=1
			JOIN `student_atttendance` `sa` ON `sa`.`student_id` = `s`.`s_id`
			WHERE `sa`.`a_master_id` = `am`.`a_id`
			AND `s`.`school_id` = ".$data['school_id']."
			AND `am`.`session_id` = ".$data['session']."
			AND `am`.`class_id` = ".$data['class_id']."
			AND `am`.`section_id` = ".$data['section_id']."
			AND `s`.`section` = ".$data['section_id']."
			AND `am`.`term` = 'Annual'
			AND `am`.`status` = 1
			AND satt.class_category = '".$class_category."'
			AND satt.term = 'Final'
			AND s.s_id = '".$student['s_id']."'
			AND s.medium = '".$data['medium']."'
			AND s.subject_group = '".$data['sgroup']."'
			AND satt.school_id = ".$data['school_id']."
			AND satt.status = 1")->result_array();
			
			$temp = array();
			if($data['school_id'] == 1){
				$school = 'shakuntala';
			}
			else{
				$school = 'sharda';
			}
	
			$path = base_url().'photos/students/'.$school.'/'.$student['admission_no'].'.jpg';
	
			if (file_get_contents($path)) {
				$temp = $student;
				$temp['photo'] =  $student['admission_no'].'.jpg';
			}
			else {
				$temp = $r;
				$temp['photo'] =  $student['admission_no'].'.JPG';
			}
			$student = $temp;;
			
			$student['dob'] = date('d-m-Y',strtotime($student['dob']));
			
			///////////////// for selecting elective subjects ////////////////////////
			if($student['elective'] == 23){
				$elective = 'CS';
			}
			if($student['elective'] == 26){
				$elective = 'Hindi';
			}
			if($student['elective'] == 27){
				$elective = 'PE';
			}
			if($student['elective'] == 28){
				$elective = 'Maths(opt)';
			}
			
			////////////////// for selecting subject group /////////////////////////
			if($data['sgroup'] == 'Maths'){
				$sgroup = 'maths';
			}
			if($data['sgroup'] == 'Boilogy'){
				$sgroup = 'Bio';
			}
			if($data['sgroup'] == 'Commerce'){
				$sgroup = 'commer';
			}
			/////////////////////////
			$this->db->select('id,subject');
			$subjects = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'type'=>'scholastic','e_type'=>1))->result_array();
			
			$this->db->select('id,subject');
			$elective_subject = $this->db->get_Where('high_class_subject hc',array('hc.class'=>$data['class_id'],'subject'=>$elective,'type'=>'elective','e_type'=>1))->result_array();
			
			$subjects = array_merge($subjects,$elective_subject);
			
			$student_marks_pre = array();
			$student_marks_mid = array();
			$student_marks_post = array();
			$student_marks_final = array();
			
			$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
			$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
			$pre_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
					'hm.school_id' => $data['school_id'],
					'hm.class_id' => $data['class_id'],
					'hm.section_id' => $data['section_id'],
					'hm.medium' => $data['medium'],
					'sf.s_group' => $sgroup,
					'hm.s_group' => $sgroup,
					'sf.class' => $data['class_id'],
					'sf.e_type' => 'pre',
					'sf.status' => 1,
					'hm.e_type' => 1
			))->result_array();

			$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
			$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
			$mid_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
					'hm.school_id' => $data['school_id'],
					'hm.class_id' => $data['class_id'],
					'hm.section_id' => $data['section_id'],
					'hm.medium' => $data['medium'],
					'sf.s_group' => $sgroup,
					'hm.s_group' => $sgroup,
					'sf.class' => $data['class_id'],
					'sf.e_type' => 'mid',
					'sf.status' => 1,
					'hm.e_type' => 4
			))->result_array();
			
			$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
			$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
			$post_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
					'hm.school_id' => $data['school_id'],
					'hm.class_id' => $data['class_id'],
					'hm.section_id' => $data['section_id'],
					'hm.medium' => $data['medium'],
					'sf.s_group' => $sgroup,
					'hm.s_group' => $sgroup,
					'sf.class' => $data['class_id'],
					'sf.e_type' => 'post',
					'sf.status' => 1,
					'hm.e_type' => 6
			))->result_array();
			
			$this->db->select('hm.*,sf.practical,sf.subj_marks,sf.practical_mark');
			$this->db->join('subject_format_11_12 sf','sf.sub_id = hm.subject');
			$final_marks_masters = $this->db->get_where('high_class_mark_master hm',array(
					'hm.school_id' => $data['school_id'],
					'hm.class_id' => $data['class_id'],
					'hm.section_id' => $data['section_id'],
					'hm.medium' => $data['medium'],
					'sf.s_group' => $sgroup,
					'hm.s_group' => $sgroup,
					'sf.class' => $data['class_id'],
					'sf.e_type' => 'final',
					'sf.status' => 1,
					'hm.e_type' => 9
			))->result_array();
			
			$mark_master = array();
			foreach($pre_marks_masters as $m){
				array_push($mark_master, $m['id']);
			}
			
			$mark_master_mid = array();
			foreach($mid_marks_masters as $m){
				array_push($mark_master_mid, $m['id']);
			}
			
			$mark_master_post = array();
			foreach($post_marks_masters as $m){
				array_push($mark_master_post, $m['id']);
			}
			
			$mark_master_final = array();
			foreach($final_marks_masters as $m){
				array_push($mark_master_final, $m['id']);
			}
			
			if(count($pre_marks_masters) > 0) {
				$this->db->select('sm.*,s.subject as sub_name');
				$this->db->where_in('hm_id',$mark_master);
				$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
				$marks = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>1,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
			
				$this->db->select('sm.*,s.subject as sub_name');
				$this->db->where_in('hm_id',$mark_master_mid);
				$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
				$marks_mid = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>4,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
			
				$this->db->select('sm.*,s.subject as sub_name');
				$this->db->where_in('hm_id',$mark_master_post);
				$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
				$marks_post = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>6,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
			
				$this->db->select('sm.*,s.subject as sub_name');
				$this->db->where_in('hm_id',$mark_master_final);
				$this->db->join('subjects_11_12 s','s.id = sm.subject_id');
				$marks_final = $this->db->get_where('student_marks_high_class sm',array('sm.e_type'=>9,'sm.student_id'=>$student['s_id'],'sm.status'=>1))->result_array();
			
				if(count($marks) > 0) {
					foreach($marks as $mark){
						$temp = array();
						foreach($pre_marks_masters as $pmm){
							if($mark['subject_id'] == $pmm['subject']){
								$temp['hm_id'] =  $mark['hm_id'];
								$temp['e_type'] =  $mark['e_type'];
								$temp['student_id'] =  $mark['student_id'];
								$temp['subject_id'] =  $mark['subject_id'];
								$temp['subject_marks'] = 50;
								$temp['marks'] =  $mark['marks'];
								$temp['p_marks'] =  $mark['p_marks'];
								$temp['sub_name'] = $mark['sub_name'];
								$student_marks_pre[] = $temp;
							}
						}
					}
				}
			
				if(count($marks_mid) > 0) {
					foreach($marks_mid as $mark_mid){
						foreach($mid_marks_masters as $mmm){
							if($mark_mid['subject_id'] == $mmm['subject']){
								$temp = array();
								$temp['hm_id'] = $mark_mid['hm_id'];
								$temp['e_type'] = $mark_mid['e_type'];
								$temp['student_id'] = $mark_mid['student_id'];
								$temp['subject_id'] = $mark_mid['subject_id'];
								$temp['subject_marks'] = $mmm['subj_marks'];
								$temp['marks'] = $mark_mid['marks'];
								$temp['p_marks'] = $mark_mid['p_marks'];
								$temp['sub_name'] = $mark_mid['sub_name'];
								$student_marks_mid[] = $temp;
							}
						}
					}
				}
			
			
				if(count($marks_post) > 0) {
					foreach($marks_post as $mark_post){
						foreach($post_marks_masters as $pmm){
							if($mark_post['subject_id'] == $pmm['subject']){
								$temp = array();
								$temp['hm_id'] = $mark_post['hm_id'];
								$temp['e_type'] = $mark_post['e_type'];
								$temp['student_id'] = $mark_post['student_id'];
								$temp['subject_id'] = $mark_post['subject_id'];
								$temp['subject_marks'] = $pmm['subj_marks'];
								$temp['marks'] = $mark_post['marks'];
								$temp['p_marks'] = $mark_post['p_marks'];
								$temp['sub_name'] = $mark_post['sub_name'];
								$student_marks_post[] = $temp;
							}
						}
					}
				}
			
				if(count($marks_final) > 0) {
					foreach($marks_final as $mark_final){
						foreach($final_marks_masters as $fmm){
							if($mark_final['subject_id'] == $fmm['subject']){
								$temp = array();
								$temp['hm_id'] = $mark_final['hm_id'];
								$temp['e_type'] = $mark_final['e_type'];
								$temp['student_id'] = $mark_final['student_id'];
								$temp['subject_id'] = $mark_final['subject_id'];
								$temp['subject_marks'] = $fmm['subj_marks'];
								$temp['marks'] = $mark_final['marks'];
								$temp['p_marks'] = $mark_final['p_marks'];
								$temp['sub_name'] = $mark_final['sub_name'];
								$student_marks_final[] = $temp;
							}
						}
					}
				}
			}
			
			$total_obtain_marks = 0;
			$x = 5;
			$exam = 1;
			$extra_no = 0;
			$get_extra = 0;
			$extra_counter = 0;
			$final_array = array();
			foreach($student_marks_pre as $smp){
				foreach($student_marks_mid as $smm){
					foreach($student_marks_post as $smpo){
						foreach($student_marks_final as $smf){
							if($smp['subject_id'] == $smm['subject_id'] && $smm['subject_id'] == $smpo['subject_id'] && $smm['subject_id'] == $smf['subject_id']){
								$temp = array();
								$temp['subject_name'] = $smpo['sub_name'];
								$temp['sub_id'] = $smpo['subject_id'];
								$temp['post_mid_marks'] = $smpo['marks'];
								$temp['final_thory_marks_max'] = $smf['subject_marks'];
								$temp['final_thory_marks_obtain'] = $smf['marks'];
								$temp['final_practical_marks_max'] = 100 - $smf['subject_marks'];
								if($temp['final_practical_marks_max'] == 0){
									$temp['final_practical_marks_max'] = 'NA';
									$temp['final_practical_marks_obtail'] = 'NA';
								}
								else{
									$temp['final_practical_marks_obtail'] = $smf['p_marks'];
								}
			
								$temp['annual_total'] = $temp['final_thory_marks_obtain'] + $temp['final_practical_marks_obtail'];
								$temp['pre_5'] = round((((($smp['marks']*100)/$smp['subject_marks'])*5)/100),2);
								$temp['mid_20'] = round((((($smm['marks']*100)/$smm['subject_marks'])*20)/100),2);
								$temp['post_5'] = round((((($smpo['marks']*100)/$smpo['subject_marks'])*5)/100),2);
			
								//$temp['final_thory_60'] = round((((($smf['marks']*100)/$smf['subject_marks'])*60)/100),2);
								$temp['final_thory_60'] = round((($smf['marks']*60)/100),2);
								//$temp['final_practical_60'] = round(((($smf['p_marks']*100)/$temp['final_practical_marks_max'])*60/100),2);
								if($temp['final_practical_marks_max'] == 0){
									$temp['final_practical_60'] = 'NA';
								}
								else{
									$temp['final_practical_60'] = round((($smf['p_marks']*60)/100),2);
								}
								$temp['final_thory_practical'] = round(($temp['final_practical_60'] + $temp['final_thory_60']),2);
								$temp['academic_attention'] = 9;
								$temp['grand_total'] = $temp['pre_5'] + $temp['mid_20'] + $temp['post_5'] + $temp['final_thory_practical'] + $temp['academic_attention'];
			
								//$total_obtain_marks = $total_obtain_marks + $temp['final_thory_marks_obtain'] + $temp['final_practical_marks_obtail'];
								$total_obtain_marks = $total_obtain_marks + $temp['grand_total'];
								if($temp['final_thory_marks_obtain'] < round(($temp['final_thory_marks_max']*33)/100)){
									$extra = round(($temp['final_thory_marks_max']*33)/100) - $temp['final_thory_marks_obtain'];
									$x = 5 - $extra_no;
									$x  = $x - ceil($extra);
									if($x > 0){
										$temp['extra'] = ceil($extra);
										$extra_no = $extra_no + ceil($extra);
										$temp['stars'] = '**';
										$get_extra = 1;
										$back['get_extra'] = 1;
									}
									else{
										$temp['stars'] = '*';
										if($exam < 2){
											$back['subject'] = $smpo['sub_name'];
											$back['category'] = 'Compartment';
											$result['back'] = $back;
											$temp['extra'] = 0;
											$exam = $exam + 1;
										}
										else{
											$back['category'] = 'Detained';
											$result['back'] = $back;
											$temp['extra'] = 0;
											$exam = $exam + 1;
										}
									}
								}
								else{
									$temp['stars'] = ' ';
									$temp['extra'] = 0;
								}
								$grand_total = ceil($temp['grand_total']);
								if($grand_total >= 91){
									$temp['grade'] = 'A1';
								}
								else if($grand_total >= 81 && $grand_total <= 90){
									$temp['grade'] = 'A2';
								}
								else if($grand_total >= 71 && $grand_total <= 80){
									$temp['grade'] = 'B1';
								}
								else if($grand_total >= 61 && $grand_total <= 70){
									$temp['grade'] = 'B2';
								}
								else if($grand_total >= 51 && $grand_total <= 60){
									$temp['grade'] = 'C1';
								}
								else if($grand_total >= 41 && $grand_total <= 50){
									$temp['grade'] = 'C2';
								}
								else if($grand_total >= 33 && $grand_total <= 40){
									$temp['grade'] = 'D';
								}
								else{
									$temp['grade'] = 'E';
								}
								$final_array[] = $temp;
							}
						}
					}
				}
			}
			
			$marks_final = array();
			// 		$co_subjects = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
			$co_subjects = array('5','9','10','11','12','1','2','3','4','6','7','8','13','14','15','16','17');
			foreach($co_subjects as $co_subject){
				foreach($final_array as $s){
					if($co_subject == $s['sub_id']){
						$marks_final[] = $s;
					}
				}
			}
			//$sub = $marks_final;
			
			$co_marks = array();
			foreach($student_marks_mid as $student_co_marks){
				foreach($student_marks_final as $student_co_marks_final){
					if($student_co_marks['subject_id'] == $student_co_marks_final['subject_id']){
						$temp = array();
						if($student_co_marks['subject_id'] == 13 || $student_co_marks['subject_id'] == 14 || $student_co_marks['subject_id'] == 15 || $student_co_marks['subject_id'] == 16 || $student_co_marks['subject_id'] == 17){
							$temp['student_id'] = $student_co_marks['student_id'];
							$temp['sub_id'] = $student_co_marks['subject_id'];
							$temp['mark_mid'] = $student_co_marks['marks'];
							$temp['mark_final'] = $student_co_marks_final['marks'];
							$temp['total'] = round(($temp['mark_mid'] + $temp['mark_final'])/2);
							$temp['sub_name'] = $student_co_marks['sub_name'];
							$co_marks[] = $temp;
						}
					}
				}
			}
			
			$co_marks_final = array();
			$co_subjects = array('13','14','15','16','17');
			foreach($co_subjects as $co_subject){
				foreach($co_marks as $co_mark){
					if($co_subject == $co_mark['sub_id']){
						$co_marks_final[] = $co_mark;
					}
				}
			}

			$co_marks = $co_marks_final;
			$final_co_marks = array();
			foreach($co_marks as $co_mark){
				$temp = $co_mark;
				if($co_mark['mark_mid'] == 5){
					$temp['mark_mid'] = 'A';
				}
				else if($co_mark['mark_mid'] == 4){
					$temp['mark_mid'] = 'B';
				}
				else if($co_mark['mark_mid'] == 3){
					$temp['mark_mid'] = 'C';
				}
				else if($co_mark['mark_mid'] == 2){
					$temp['mark_mid'] = 'D';
				}
				else if($co_mark['mark_mid'] == 1){
					$temp['mark_mid'] = 'E';
				}
				else if($co_mark['mark_mid'] == 'A'){
					$temp['mark_mid'] = 'Abst';
				}
			
				if($co_mark['mark_final'] == 5){
					$temp['mark_final'] = 'A';
				}
				else if($co_mark['mark_final'] == 4){
					$temp['mark_final'] = 'B';
				}
				else if($co_mark['mark_final'] == 3){
					$temp['mark_final'] = 'C';
				}
				else if($co_mark['mark_final'] == 2){
					$temp['mark_final'] = 'D';
				}
				else if($co_mark['mark_final'] == 1){
					$temp['mark_final'] = 'E';
				}
				else if($co_mark['mark_final'] == 'A'){
					$temp['mark_final'] = 'Abst';
				}
			
				if($co_mark['total'] == 5){
					$temp['total'] = 'A';
				}
				else if($co_mark['total'] == 4){
					$temp['total'] = 'B';
				}
				else if($co_mark['total'] == 3){
					$temp['total'] = 'C';
				}
				else if($co_mark['total'] == 2){
					$temp['total'] = 'D';
				}
				else if($co_mark['total'] == 1){
					$temp['total'] = 'E';
				}
				else if($co_mark['total'] == 'A'){
					$temp['total'] = 'Abst';
				}
				$final_co_marks[] = $temp;
			}
			
			$result['final_marks'] = $marks_final;
			$result['co_marks'] = $final_co_marks;
			$result['total_obtail'] = round($total_obtain_marks);
			$result['percent'] = ($result['total_obtail'] * 100)/500;
			$result['get_extra'] = $get_extra;
			//$result['back'] = $final_array1;

			$final_array = array();
			$final_array[] = $result;
			$loop_array[] = $result; 
		} //main for loop
		$sort_list = $loop_array;
		$toppers = array();
		foreach ($sort_list as $key => $row){
			if(isset($row['total_obtail'])){
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
					if(isset($la['back'])){
						if($la['back']['category'] == 'Detained'){
							$la['rank'] = '-';
							$la['percent'] = '-';
						}
						else{
							$la['rank'] = '-';
							$la['percent'] = '-';
						}
					}
					else{
						if(isset($la['get_extra'])){
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
						else{
							echo "sdf12"; die;
							$rank = $rank + 1;
							$la['rank'] = $rank;
						}
					}
					$final_sorted_array[] = $la;
				}
			}
		}
		return $final_sorted_array;
	}
}
