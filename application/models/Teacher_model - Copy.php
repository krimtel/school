<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {	
	
	function teacher_abstract($data){
		$e_marks;
		switch($data['type']){
			case 1 :
				$e_marks = 50;
				break;
			case 4 :
				$e_marks = 80;
				break;
			case 6 :
				$e_marks = 50;
				break;
			case 9 :
				$e_marks = 80;
		}
		$this->db->select('cs.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class'],'s.subj_type'=>'Scholastic','cs.status'=>1))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['subject_id']);	
		}
		$final = array();
		foreach($sub_lists as $sub_list){
			$temp = array();
			$this->db->select('teacher_id');
			$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'medium'=>$data['medium'],'status'=>1))->result_array();

			if(count($result)>0){
				$this->db->select('name');
				$teacher_name = $this->db->get_where('teacher',array('t_id'=>$result[0]['teacher_id']))->result_array();
				$teacher_name = $teacher_name[0]['name'];
			}
			else{
				$teacher_name = '';
			}
			
			$this->db->select('name');
			$subject_name = $this->db->get_where('subject',array('sub_id'=>$sub_list))->result_array();
			$subject_name = $subject_name[0]['name'];
			
			$this->db->select('count(*) as total');
			$no_of_students = $this->db->get_where('student',array('session'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section'=>$data['section'],'school_id'=>$data['school_id'],'status'=>1))->result_array();
			$no_of_students = $no_of_students[0]['total'];
			
			$this->db->select('*');
			$mark_masters = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section'=>$data['section'],'sub_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
			
			$this->db->select('*');
			$mark_master = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'class_id'=>$data['class'],'section'=>$data['section'],'session_id'=>$data['session'],'e_type'=>$data['type'],'medium'=>$data['medium'],'sub_id'=>$sub_list))->result_Array();
			if(count($mark_master)>0){
				$this->db->select('*');
				$results = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'marks<>'=>'A','medium'=>$data['medium'],'class_id'=>$data['class'],'mm_id'=>$mark_master[0]['m_id'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				 	
				$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
				$result = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
				
				$this->db->select('count(*) as notapper');
				$notapper = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'marks'=>'A','medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
				
				$this->db->select('count(*) as get_max');
				$result_1 = $this->db->get_where('student_mark',array('marks'=>$result[0]['max'],'session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
				
				$max_marks_get = $result_1[0]['get_max']; 
				$max = $result[0]['max'];
				$notapper = $notapper[0]['notapper'];
				$total =  $result[0]['total'];
				
				$fail = 0;
				$firstdiv = 0;
				$seconddiv = 0;
				$thirddiv = 0;
				
				foreach($results as $result){
					$result['marks'] = ($result['marks'] /$e_marks)* 100 ;
                                       if($data['type'] == 4 || $data['type'] == 9){
						$min = 28;
					}else{
						$min = 18;
					}
					if($result['marks'] <= $min){
						$fail = $fail + 1;
					}
					else if($result['marks'] >= $min && $result['marks'] <= 44){
						$thirddiv = $thirddiv + 1;
					}
					else if($result['marks'] > 45 && $result['marks'] <= 59){
						$seconddiv = $seconddiv + 1;
					}
					else{
						$firstdiv = $firstdiv + 1;
					}
				}
			
				$pass = ($no_of_students - $notapper) - $fail;
				if($pass < 0 ){
					$pass = 0;
				}
					
				if($pass < 10){
					$pass = '0'.$pass;
				}
				if($firstdiv < 10){
					$firstdiv = '0'.$firstdiv;
				}
				if($seconddiv < 10){
					$seconddiv = '0'.$seconddiv;
				}
				if($thirddiv < 10){
					$thirddiv = '0'.$thirddiv;
				}
				if($max < 10){
					$max = '0'.$max;
				}
				if($max_marks_get < 10){
					$max_marks_get = '0'.$max_marks_get;
				}
				
				$temp['teacher'] = $teacher_name;	//teacher name
				$temp['subject'] = $subject_name;	//subject name
				$temp['total_student'] = $no_of_students;	//total student
				$temp['total_pass'] = $pass;		//pass
				$temp['pass_percent'] = round(($pass * 100)/($no_of_students - $notapper));	//pass
				$temp['first_div'] = $firstdiv;		//1st div
				if($pass > 0){
					$temp['first_percent'] = round(($firstdiv * 100)/$pass);	//pass
				}
				else{
					$temp['first_percent'] = 0;
				}
				$temp['second_div'] = $seconddiv;	//2nd div
				$temp['third_div'] = $thirddiv;;	//3rd div
				$temp['fail'] = ($no_of_students - $notapper) - $pass;	//3rd div
				if($temp['fail'] < 10){
					$temp['fail'] = '0'.$temp['fail'];
				}
				$temp['max'] = $max;
				$temp['notapper'] = $no_of_students - $notapper;
				$temp['get_max'] = $max_marks_get; 
				$temp['pi'] = round(($total / (($no_of_students - $notapper) *$e_marks))*100,2);
				//$temp['pi'] = round($total / $no_of_students);
				$final[] = $temp;
			}
		}
		return $final;
	}
	
	
	function teacher_abstract_teacher($data){
		$this->db->select('cs.*');
		$this->db->join('subject s','s.sub_id = cs.subject_id');
		$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$data['class'],'s.subj_type'=>'Scholastic','cs.status'=>1))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['subject_id']);
		}
		$final = array();
		foreach($sub_lists as $sub_list){
			$temp = array();
			$this->db->select('teacher_id');
			$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'medium'=>$data['medium'],'teacher_id'=>$data['teacher_id']))->result_array();
				
			if(count($result)>0){
				$this->db->select('name');
				$teacher_name = $this->db->get_where('teacher',array('t_id'=>$result[0]['teacher_id']))->result_array();
				$teacher_name = $teacher_name[0]['name'];
			}
			else{
				continue;
			}
				
			$this->db->select('name');
			$subject_name = $this->db->get_where('subject',array('sub_id'=>$sub_list))->result_array();
			$subject_name = $subject_name[0]['name'];
				
			$this->db->select('count(*) as total');
			$no_of_students = $this->db->get_where('student',array('session'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section'=>$data['section'],'school_id'=>$data['school_id'],'status'=>1))->result_array();
			$no_of_students = $no_of_students[0]['total'];
			
			$this->db->select('*');
			$results = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				
			$this->db->select('max(marks) as max ,sum(marks) as total');
			$result = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
			
			$max = $result[0]['max'];
			$total =  $result[0]['total'];
				
			$fail = 0;
			$firstdiv = 0;
			$seconddiv = 0;
			$thirddiv = 0;
				
			foreach($results as $result){
                        if($data['type'] == 4 || $data['type'] == 9){
			    $min = 28;
			}else{
			    $min = 18;
			}
				if($result['marks'] <= $min){
					$fail = $fail + 1;
				}
				else if($result['marks'] > $min && $result['marks'] <= 30){
					$thirddiv = $thirddiv + 1;
				}
				else if($result['marks'] > 30 && $result['marks'] <= 50){
					$seconddiv = $seconddiv + 1;
				}
				else{
					$firstdiv = $firstdiv + 1;
				}
			}
		
			$pass = $no_of_students - $fail;
			if($pass < 0 ){
				$pass = 0;
			}
				
			$temp['teacher'] = $teacher_name;	//teacher name
			$temp['subject'] = $subject_name;	//subject name
			$temp['total_student'] = $no_of_students;	//total student
			$temp['total_pass'] = $pass;		//pass
			$temp['pass_percent'] = round(($pass * 100)/$no_of_students);	//pass
			$temp['first_div'] = $firstdiv;		//1st div
			if($pass > 0){
				$temp['first_percent'] = round(($firstdiv * 100)/$pass);	//pass
			}
			else{
				$temp['first_percent'] = 0;
			}
			$temp['second_div'] = $seconddiv;	//2nd div
			$temp['third_div'] = $thirddiv;;	//3rd div
			$temp['fail'] = $no_of_students - $pass;	//3rd div
			$temp['max'] = $max;
			$temp['pi'] = round($total / $no_of_students);
			$final[] = $temp;
		}
		return $final;
	}
	
	
	function teacher_abstract_new($data){
		$this->db->select('s.class_id,s.section_id,c.name as cname,sec.name as secname,s.subject_id');
		$this->db->group_by('s.class_id,s.section_id');
		$this->db->join('class c','c.c_id = s.class_id');
		$this->db->join('section sec','sec.id = s.section_id');
		$classes = $this->db->get_where('subject_allocation s',array('s.teacher_id'=>$data['t_id'],'s.school_id'=>$data['school_id'],'s.medium'=>$data['medium'],'s.status'=>1))->result_array();
		
		$e_marks;
		switch($data['e_type']){
			case 1 :
				$e_marks = 50;
				break;
			case 4 :
				$e_marks = 80;
				break;
			case 6 :
				$e_marks = 50;
				break;
			case 9 :
				$e_marks = 80;
		}
		$new_final = array();
		foreach($classes as $class){
			$this->db->select('cs.*');
			$this->db->join('subject s','s.sub_id = cs.subject_id');
			$this->db->join('subject_allocation sa','sa.subject_id = s.sub_id');
			$subjects = $this->db->get_Where('class_sujects cs',array('cs.class_id'=>$class['class_id'],'s.subj_type'=>'Scholastic','cs.status'=>1,'sa.teacher_id'=>$data['t_id'],'sa.class_id'=>$class['class_id'],'sa.section_id'=>$class['section_id'],'sa.medium'=>$data['medium'],'sa.status'=>1))->result_array();
			
			$sub_lists = array();
			foreach($subjects as $subject){
				array_push($sub_lists, $subject['subject_id']);
			}
			$final = array();
			foreach($sub_lists as $sub_list){
				$temp = array();
				$this->db->select('teacher_id');
				$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'class_id'=>$class['class_id'],'teacher_id'=>$data['t_id'],'section_id'=>$class['section_id'],'subject_id'=>$sub_list,'medium'=>$data['medium']))->result_array();
				
				if(count($result)>0){
					$this->db->select('name');
					$teacher_name = $this->db->get_where('teacher',array('t_id'=>$data['t_id']))->result_array();
					$teacher_name = $teacher_name[0]['name'];
				}
				else{
					$teacher_name = '';
				}
					
				$this->db->select('name');
				$subject_name = $this->db->get_where('subject',array('sub_id'=>$sub_list))->result_array();
				$subject_name = $subject_name[0]['name'];
					
				$this->db->select('count(*) as total');
				$no_of_students = $this->db->get_where('student',array('session'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section'=>$class['section_id'],'school_id'=>$data['school_id'],'status'=>1))->result_array();
				$no_of_students = $no_of_students[0]['total'];
					
				$this->db->select('*');
				$mark_masters = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section'=>$class['section_id'],'sub_id'=>$sub_list,'e_type'=>$data['e_type']))->result_array();
					
				$this->db->select('*');
				$mark_master = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'class_id'=>$class['class_id'],'section'=>$class['section_id'],'session_id'=>$data['session'],'e_type'=>$data['e_type'],'medium'=>$data['medium'],'sub_id'=>$sub_list))->result_Array();
				
				if(count($mark_master)>0){
					$this->db->select('*');
					$results = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'marks<>'=>'A','medium'=>$data['medium'],'class_id'=>$class['class_id'],'mm_id'=>$mark_master[0]['m_id'],'section_id'=>$class['section_id'],'subject_id'=>$sub_list,'e_type'=>$data['e_type']))->result_array();
						
					$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
					$result = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section_id'=>$class['section_id'],'subject_id'=>$sub_list,'e_type'=>$data['e_type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
		
					$this->db->select('count(*) as notapper');
					$notapper = $this->db->get_where('student_mark',array('session_id'=>$data['session'],'marks'=>'A','medium'=>$data['medium'],'class_id'=>$class['class_id'],'section_id'=>$class['section_id'],'subject_id'=>$sub_list,'e_type'=>$data['e_type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
					
					$this->db->select('count(*) as get_max');
					$result_1 = $this->db->get_where('student_mark',array('marks'=>$result[0]['max'],'session_id'=>$data['session'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section_id'=>$class['section_id'],'subject_id'=>$sub_list,'e_type'=>$data['e_type'],'mm_id'=>$mark_masters[0]['m_id']))->result_array();
		
					$max_marks_get = $result_1[0]['get_max'];
					$max = $result[0]['max'];
					$notapper = $notapper[0]['notapper'];
					$total =  $result[0]['total'];
		
					$fail = 0;
					$firstdiv = 0;
					$seconddiv = 0;
					$thirddiv = 0;
					
					foreach($results as $result){
						$result['marks'] = ($result['marks'] /$e_marks)* 100 ;
						if($result['marks'] <= 32){
							$fail = $fail + 1;
						}
						else if($result['marks'] >= 33 && $result['marks'] <= 44){
							$thirddiv = $thirddiv + 1;
						}
						else if($result['marks'] > 45 && $result['marks'] <= 59){
							$seconddiv = $seconddiv + 1;
						}
						else{
							$firstdiv = $firstdiv + 1;
						}
					}
	
					$pass = ($no_of_students - $notapper) - $fail;
					if($pass < 0 ){
						$pass = 0;
					}
						
					if($pass < 10){
						$pass = '0'.$pass;
					}
					if($firstdiv < 10){
						$firstdiv = '0'.$firstdiv;
					}
					if($seconddiv < 10){
						$seconddiv = '0'.$seconddiv;
					}
					if($thirddiv < 10){
						$thirddiv = '0'.$thirddiv;
					}
					if($max < 10){
						$max = '0'.$max;
					}
					if($max_marks_get < 10){
						$max_marks_get = '0'.$max_marks_get;
					}
		
					$temp['teacher'] = $teacher_name;	//teacher name
					$temp['subject'] = $subject_name;	//subject name
					$temp['total_student'] = $no_of_students;	//total student
					$temp['total_pass'] = $pass;		//pass
					$temp['pass_percent'] = round(($pass * 100)/($no_of_students - $notapper));	//pass
					$temp['first_div'] = $firstdiv;		//1st div
					if($pass > 0){
						$temp['first_percent'] = round(($firstdiv * 100)/$pass);	//pass
					}
					else{
						$temp['first_percent'] = 0;
					}
					$temp['second_div'] = $seconddiv;	//2nd div
					$temp['third_div'] = $thirddiv;;	//3rd div
					$temp['fail'] = ($no_of_students - $notapper) - $pass;	//3rd div
					if($temp['fail'] < 10){
						$temp['fail'] = '0'.$temp['fail'];
					}
					$temp['max'] = $max;
					$temp['get_max'] = $max_marks_get;
					$temp['pi'] = round(($total / (($no_of_students - $notapper) *$e_marks))*100,2);
					$temp['class_id'] = $class['cname'];
					$temp['section'] = $class['secname'];
                                        $temp['notapper'] = $no_of_students - $notapper;
					//	$temp['pi'] = round($total / $no_of_students);
					$final[] = $temp;
				}
			}
			if(count($final)>0){
				$new_final[] = $final;
			}
			else{
				$this->db->select('name');
				$subject_name = $this->db->get_where('subject',array('sub_id'=>$class['subject_id']))->result_array();
				$subject_name = $subject_name[0]['name'];
				$temp = array();
				$final = array();
				$final['class_id'] = $class['cname'];
				$final['section'] = $class['secname'];
				$final['pi'] = 0;
				$final['max'] = 00;
				$final['get_max'] = 00;
				$final['second_div'] = 00;
				$final['third_div'] = 00;
				$final['fail'] = 00;
				$final['first_percent'] = 00;
				$final['total_student'] = 00;
				$final['total_pass'] = 00;
				$final['pass_percent'] = 00;
				$final['first_div'] = 00;
				$final['teacher'] = '';
				$final['subject'] = $subject_name;
                                $final['notapper'] = 00;
				$temp[] = $final;

				$new_final[] = $temp;
			}
		}
		return $new_final;
	}
	
	
	function teacher_abstract_high_class($data){
		$this->db->select('hcs.id,hcs.subject,hcs.type');
		$this->db->join('high_class_subject hcs','hcs.id = sf.sub_id');
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>$data['type'],'sf.class'=>$data['class'],'sf.s_group'=>$data['s_group']))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['id']);
		}
		
		$final = array();
		foreach($sub_lists as $sub_list){
			$temp = array();
			$this->db->select('teacher_id');
			$result = $this->db->get_where('subject_allocation',array('school_id'=>$data['school_id'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'medium'=>$data['medium'],'status'=>1))->result_array();
			
			if(count($result)>0){
				$this->db->select('name');
				$teacher_name = $this->db->get_where('teacher',array('t_id'=>$result[0]['teacher_id']))->result_array();
				$teacher_name = $teacher_name[0]['name'];
			}
			else{
				$teacher_name = '';
			}
			
			$this->db->select('subject as name');
			$subject_name = $this->db->get_where('high_class_subject',array('id'=>$sub_list))->result_array();
			$subject_name = $subject_name[0]['name'];
			
			if($sub_list == 9 || $sub_list == 10 || $sub_list == 11 || $sub_list == 12){
				if($sub_list == 9){
					$elective = 23;
				}
				if($sub_list == 10){
					$elective = 27;
				}
				if($sub_list == 11){
					$elective = 26;
				}
				if($sub_list == 12){
					$elective = 28;
				}
				$this->db->select('count(*) as total');
				$no_of_students = $this->db->get_where('student',array(
						'session'=>$data['session'],
						'medium'=>$data['medium'],
						'class_id'=>$data['class'],
						'section'=>$data['section'],
						'school_id'=>$data['school_id'],
						'elective' => $elective,
						'status'=>1
				))->result_array();
			}
			else{
				$this->db->select('count(*) as total');
				$no_of_students = $this->db->get_where('student',array(
						'session'=>$data['session'],
						'medium'=>$data['medium'],
						'class_id'=>$data['class'],
						'section'=>$data['section'],
						'school_id'=>$data['school_id'],
						'status'=>1
				))->result_array();
			}
			$no_of_students = $no_of_students[0]['total'];
			  		
			$this->db->select('*');
			$mark_masters = $this->db->get_where('high_class_mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject'=>$sub_list,'e_type'=>$data['type']))->result_array();
			
			if(count($mark_masters) > 0){
				$this->db->select('*');
				$results = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks<>'=>'A','class_id'=>$data['class'],'hm_id'=>$mark_masters[0]['id'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				
				$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
				$result = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'hm_id'=>$mark_masters[0]['id']))->result_array();

				$this->db->select('count(*) as notapper');
				$notapper = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'hm_id'=>$mark_masters[0]['id']))->result_array();
								
				$this->db->select('count(*) as get_max');
				$result_1 = $this->db->get_where('student_marks_high_class',array('marks'=>$result[0]['max'],'session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type'],'hm_id'=>$mark_masters[0]['id']))->result_array();
				
				$max_marks_get = $result_1[0]['get_max'];
				$max = $result[0]['max'];
				$notapper = $notapper[0]['notapper'];
				$total =  $result[0]['total'];
	
				$fail = 0;
				$firstdiv = 0;
				$seconddiv = 0;
				$thirddiv = 0;
	
				foreach($results as $result){
					$result['marks'] = ($result['marks'] / 50 )* 100 ;
					$min = 18;
					
					if($result['marks'] <= $min){
						$fail = $fail + 1;
					}
					else if($result['marks'] >= $min && $result['marks'] <= 44){
						$thirddiv = $thirddiv + 1;
					}
					else if($result['marks'] > 45 && $result['marks'] <= 59){
						$seconddiv = $seconddiv + 1;
					}
					else{
						$firstdiv = $firstdiv + 1;
					}
				}
					
				$pass = ($no_of_students - $notapper) - $fail;
				if($pass < 0 ){
					$pass = 0;
				}
					
				if($pass < 10){
					$pass = '0'.$pass;
				}
				if($firstdiv < 10){
					$firstdiv = '0'.$firstdiv;
				}
				if($seconddiv < 10){
					$seconddiv = '0'.$seconddiv;
				}
				if($thirddiv < 10){
					$thirddiv = '0'.$thirddiv;
				}
				if($max < 10){
					$max = '0'.$max;
				}
				if($max_marks_get < 10){
					$max_marks_get = '0'.$max_marks_get;
				}
	
				$temp['teacher'] = $teacher_name;	//teacher name
				$temp['subject'] = $subject_name;	//subject name
				$temp['total_student'] = $no_of_students;	//total student
				$temp['total_pass'] = $pass;		//pass
				if(($no_of_students - $notapper) > 0){
					$temp['pass_percent'] = round(($pass * 100)/($no_of_students - $notapper));	//pass
				}
				else{
					$temp['pass_percent'] = 00;
				}
				$temp['first_div'] = $firstdiv;		//1st div
				if($pass > 0){
					$temp['first_percent'] = round(($firstdiv * 100)/$pass);	//pass
				}
				else{
					$temp['first_percent'] = 0;
				}
				$temp['second_div'] = $seconddiv;	//2nd div
				$temp['third_div'] = $thirddiv;;	//3rd div
				$temp['fail'] = ($no_of_students - $notapper) - $pass;	//3rd div
				if($temp['fail'] < 10){
					$temp['fail'] = '0'.$temp['fail'];
				}
				$temp['max'] = $max;
				$temp['notapper'] = $no_of_students - $notapper;
				$temp['get_max'] = $max_marks_get;
				$temp['pi'] = round(($total / (($no_of_students - $notapper) * 50))*100,2);
				$final[] = $temp;
				//print_r($final); 
			}
		}
		return $final;
	}
}