<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {	
	
    function teacher_abstract($data){
		$e_marks;
		switch($data['type']){
			case 1 :
				$e_marks = 20;
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
			$mark_masters = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section'=>$data['section'],'sub_id'=>$sub_list,'e_type'=>$data['type'],'status'=>1))->result_array();
			
			$this->db->select('*');
			$mark_master = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'class_id'=>$data['class'],'section'=>$data['section'],'session_id'=>$data['session'],'e_type'=>$data['type'],'medium'=>$data['medium'],'sub_id'=>$sub_list, 'status'=>1))->result_Array();
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
				
				if($sub_list == 13){
				    if($data['type'] == 6){
				        $e_marks = 50;
				    }
				    else{
				        $e_marks = 40;
				    }
				}
				foreach($results as $result){
					//$result['marks'] = ($result['marks'] /$e_marks)* 100 ;
                    if($data['type'] == 4 || $data['type'] == 9){
						$min = 27;
					}else{
						$min = 7;
					}
					
					if($data['type'] == 1 || $data['type'] == 6){
					    if($result['marks'] < $min){
					        $fail = $fail + 1;
					    }
					    else if($result['marks'] >= $min && $result['marks'] <= 8){
					        $thirddiv = $thirddiv + 1;
					    }
					    else if($result['marks'] > 8 && $result['marks'] <= 11){
					        $seconddiv = $seconddiv + 1;
					    }
					    else{
					        $firstdiv = $firstdiv + 1;
					    }
					}
					else{
    					if($result['marks'] < $min){
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
			    $min = 27;
			}else{
			    $min = 17;
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
		$classes = $this->db->get_where('subject_allocation s',array('s.class_id <'=>14,'s.teacher_id'=>$data['t_id'],'s.school_id'=>$data['school_id'],'s.medium'=>$data['medium'],'s.status'=>1))->result_array();
		
		$e_marks;
		switch($data['e_type']){
			case 1 :
				$e_marks = 20;
				break;
			case 4 :
				$e_marks = 80;
				break;
			case 6 :
				$e_marks = 20;
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
				$mark_masters = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section'=>$class['section_id'],'sub_id'=>$sub_list,'e_type'=>$data['e_type'], 'status'=>1))->result_array();
					
				$this->db->select('*');
				$mark_master = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],'class_id'=>$class['class_id'],'section'=>$class['section_id'],'session_id'=>$data['session'],'e_type'=>$data['e_type'],'medium'=>$data['medium'],'sub_id'=>$sub_list, 'status'=>1))->result_Array();
				
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
					
					if($sub_list == 13){
					    if($data['e_type'] == 6){
					        $e_marks = 50;
					    }
					    else{
					        $e_marks = 40;
					    }
					}
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
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>$data['type'],'sf.class'=>$data['class']))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['id']);
		}
		$sub_lists = array_unique($sub_lists);
		
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
			if($data['type']==3){
			    $data['type']= 6;
			}
			$this->db->select('*');
			$mark_masters = $this->db->get_where('high_class_mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject'=>$sub_list,'e_type'=>$data['type']))->result_array();
			
			$mark_master_ids = array();
			foreach($mark_masters as $mark_master){
			    array_push($mark_master_ids, $mark_master['id']);
			}
			
			if(count($mark_masters) > 0){
				$this->db->select('*');
				$this->db->where_in('hm_id',$mark_master_ids);
				$results = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks<>'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				
				$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();

				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$notapper = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				
				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$no_of_students = $this->db->get_where('student_marks_high_class',array())->result_array();
				$no_of_students = $no_of_students[0]['notapper'];
						
				$this->db->select('count(*) as get_max');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result_1 = $this->db->get_where('student_marks_high_class',array('marks'=>$result[0]['max'],'session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
				
				$max_marks_get = $result_1[0]['get_max'];
				$max = $result[0]['max'];
				$notapper = $notapper[0]['notapper'];
				$total =  $result[0]['total'];
	
				$fail = 0;
				$firstdiv = 0;
				$seconddiv = 0;
				$thirddiv = 0;
	
				foreach($results as $result){
					//$result['marks'] = ($result['marks'] / 50 )* 100 ;

					    $min = 7;
					    $third_min = 7;
					    $sec_min = 9;
					
					if($result['marks'] <= $min){
						$fail = $fail + 1;
					}
					else if($result['marks'] >= $min && $result['marks'] <= $third_min){
						$thirddiv = $thirddiv + 1;
					}
					else if($result['marks'] > $third_min && $result['marks'] <= $sec_min){
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
				$temp['pi'] = round(($total / (($no_of_students - $notapper) * 20))*100,2);
				$final[] = $temp;
			}
		}
		return $final;
	}
	
	function teacher_abstract_high_class_mid($data){
		$this->db->select('hcs.id,hcs.subject,hcs.type');
		$this->db->join('subjects_11_12 hcs','hcs.id = sf.sub_id');
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>$data['type'],'sf.class'=>$data['class']))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['id']);
		}
		$sub_lists = array_unique($sub_lists);
		
		$final = array();
		foreach($sub_lists as $sub_list){
			if($sub_list == 13 || $sub_list == 14 || $sub_list == 15 || $sub_list == 16 || $sub_list == 17){
				continue;
			}
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
			$subject_name = $this->db->get_where('subjects_11_12',array('id'=>$sub_list))->result_array();
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
			
			$mark_master_ids = array();
			foreach($mark_masters as $mark_master){
			    array_push($mark_master_ids, $mark_master['id']);
			}
			
			if(count($mark_masters) > 0){
				$this->db->select('*');
				$this->db->where_in('hm_id',$mark_master_ids);
				$results = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks<>'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$notapper = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$no_of_students = $this->db->get_where('student_marks_high_class',array())->result_array();
				$no_of_students = $no_of_students[0]['notapper'];
				
				$this->db->select('count(*) as get_max');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result_1 = $this->db->get_where('student_marks_high_class',array('marks'=>$result[0]['max'],'session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$max_marks_get = $result_1[0]['get_max'];
				$max = $result[0]['max'];
				$notapper = $notapper[0]['notapper'];
				$total =  $result[0]['total'];
	
				$fail = 0;
				$firstdiv = 0;
				$seconddiv = 0;
				$thirddiv = 0;
				
				$this->db->select('*');
				$hight_mark = $this->db->get_where('subject_format_11_12',array('sub_id'=>$sub_list,'class'=>$data['class'],'e_type'=>'mid'))->result_array();
				$hight_mark = $hight_mark[0]['subj_marks'];
				
				$fail = 0;
				$thirddiv = 0;
				$seconddiv = 0;
				$firstdiv = 0;
				foreach($results as $result){
					$result['marks'] = ($result['marks'] / $hight_mark )* 100 ;
					if($hight_mark == 100){
						$min = 32;
						$third_min = 44;
						$sec_min = 59;
					}
					else if($hight_mark == 90){
						$min = 30;
						$third_min = 40;
						$sec_min = 53;
					}
					else if($hight_mark == 80){
						$min = 27;
						$third_min = 35;
						$sec_min = 47;
					}
					else if($hight_mark == 70){
						$min = 23;
						$third_min = 31;
						$sec_min = 41;
					}
					else if($hight_mark == 50){
						$min = 17;
						$third_min = 22;
						$sec_min = 29;
					}
					
					if($result['marks'] <= $min){
						$fail = $fail + 1;
					}
					else if($result['marks'] >= $min && $result['marks'] <= $third_min){
						$thirddiv = $thirddiv + 1;
					}
					else if($result['marks'] > $third_min && $result['marks'] <= $sec_min){
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
				$temp['total'] =  $total;
				$temp['high_marks'] = $hight_mark;
				$temp['pi'] = round(($total / (($temp['notapper']) * $hight_mark))*100,2);
				$final[] = $temp;
			}
		}
		return $final;
	}
	
	function teacher_abstract_new_high_class($data){
	    $this->db->select('s.alloc_id,s.class_id,s.section_id,c.name as cname,sec.name as secname,s.subject_id');
	    $this->db->group_by('s.class_id,s.section_id,s.s_group');
	    $this->db->join('class c','c.c_id = s.class_id');
	    $this->db->join('section sec','sec.id = s.section_id');
	    $classes = $this->db->get_where('subject_allocation s',array('s.class_id >'=>13,'s.teacher_id'=>$data['t_id'],'s.school_id'=>$data['school_id'],'s.medium'=>$data['medium'],'s.status'=>1))->result_array();
	    
	    $e_marks;
	    $new_final = array();
	    foreach($classes as $class){
	       $this->db->select('sa.*,t.name as teacher_name,s.subject as subject_name,s.type');
	       $this->db->join('teacher t','t.t_id = sa.teacher_id');
	       $this->db->join('subjects_11_12 s','s.id = sa.subject_id');
	       $this->db->order_by('sa.section_id');
	       $subjects = $this->db->get_where('subject_allocation sa',array('sa.medium'=>$data['medium'],'sa.school_id'=>$data['school_id'],'sa.class_id'=>$class['class_id'],'sa.section_id'=>$class['section_id'],'sa.teacher_id'=>$data['t_id'],'s.type'=>'scholastic'))->result_array();
	       
	       $SUBJECTS = array();
	       foreach($subjects as $subject){
	           $temp = array();
	           $temp = $subject;
	           if($temp['s_group'] == 'bio'){
	               $temp['s_group'] = 'Boilogy';
	           }
	           else if($temp['s_group'] == 'maths'){
	               $temp['s_group'] = 'Maths';
	           }
	           else if($temp['s_group'] == 'comm'){
	               $temp['s_group'] = 'Commerce';
	           }
	           $SUBJECTS[] = $temp;
	       }
	       
	        $final = array();
	        foreach($SUBJECTS as $sub_list){
	            $temp = array();
	            $this->db->select('count(*) as total');
	            $no_of_students = $this->db->get_where('student',array(
	                'school_id' => $sub_list['school_id'],
	                'class_id' => $sub_list['class_id'],
	                'section' => $sub_list['section_id'],
	                'subject_group' => $sub_list['s_group'],
	                'medium' => $data['medium'] 
	            ))->result_array();
	            
	            $no_of_students = $no_of_students[0]['total'];
	            
	            $this->db->select('*');
	            $mark_master = $this->db->get_where('high_class_mark_master',array('school_id'=>$data['school_id'],'medium'=>$data['medium'],'class_id'=>$class['class_id'],'section_id'=>$class['section_id'],'subject'=>$sub_list['subject_id'],'e_type'=>$data['e_type']))->result_array();
	            
	            if(count($mark_master)>0){
	                $this->db->select('*');
	                $results = $this->db->get_where('student_marks_high_class',array(
	                    'session'=>$data['session'],
	                    'marks<>'=>'A',
	                    'class_id'=>$class['class_id'],
	                    'hm_id'=>$mark_master[0]['id'],
	                    'section_id'=>$class['section_id'],
	                    'subject_id'=>$sub_list['subject_id'],
	                    'e_type'=>$data['e_type']))->result_array();
	                
	                $this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
	                $result = $this->db->get_where('student_marks_high_class',array(
	                    'session'=>$data['session'],
	                    'class_id'=>$class['class_id'],
	                    'section_id'=>$class['section_id'],
	                    'subject_id'=>$sub_list['subject_id'],
	                    'e_type'=>$data['e_type'],
	                    'hm_id'=>$mark_master[0]['id']))->result_array();
	                
	                $this->db->select('count(*) as notapper');
	                $notapper = $this->db->get_where('student_marks_high_class',array(
	                    'session'=>$data['session'],
	                    'marks'=>'A',
	                    'class_id'=>$class['class_id'],
	                    'section_id'=>$class['section_id'],
	                    'subject_id'=>$sub_list['subject_id'],
	                    'e_type'=>$data['e_type'],
	                    'hm_id'=>$mark_master[0]['id']))->result_array();
	                
	                $this->db->select('count(*) as notapper');
	                $no_of_students = $this->db->get_where('student_marks_high_class',array(
	                    'hm_id'=>$mark_master[0]['id']))->result_array();
	                $no_of_students = $no_of_students[0]['notapper'];
	                
	                $this->db->select('count(*) as get_max');
	                $result_1 = $this->db->get_where('student_marks_high_class',array(
	                    'marks'=>$result[0]['max'],
	                    'session'=>$data['session'],
	                    'class_id'=>$class['class_id'],
	                    'section_id'=>$class['section_id'],
	                    'subject_id'=>$sub_list['subject_id'],
	                    'e_type'=>$data['e_type'],
	                    'hm_id'=>$mark_master[0]['id']))->result_array();
	                
	                $max_marks_get = $result_1[0]['get_max'];
	                $max = $result[0]['max'];
	                $notapper = $notapper[0]['notapper'];
	                $total =  $result[0]['total'];
	                
	                $fail = 0;
	                $firstdiv = 0;
	                $seconddiv = 0;
	                $thirddiv = 0;
	                $s_group ='';
	                
	                if($data['e_type'] == 1) {
	                   $e_type = 'pre';   
	                }
	                else if($data['e_type'] == 4) {
	                    $e_type = 'mid';
	                }
	                elseif($data['e_type'] == 6){
	                    $e_type = 'post';
	                }
                    if($sub_list['s_group'] == 'Boilogy'){
                        $s_group = 'bio';
                    }
                    
                    else if($sub_list['s_group'] == 'Maths'){
                        $s_group = 'maths';
                    }
                    else if($sub_list['s_group'] == 'Commerce'){
                        $s_group = 'commer';
                    }
                    
	                $this->db->select('*');
	                $subject_mark = $this->db->get_where('subject_format_11_12',array(
	                    'sub_id' => $sub_list['subject_id'],
	                    'e_type' => $e_type,
	                    'class' => $class['class_id'],
	                    'status' => 1,
	                    's_group' => $s_group 
	                ))->result_array();
	                
	                $e_marks = $subject_mark[0]['subj_marks'];
	                foreach($results as $result){
	                    //$result['marks'] = ($result['marks'] / $e_marks)* 100 ;
	                    ////
	                    if($e_marks == 100){
	                        $min = 32;
	                        $third_min = 44;
	                        $sec_min = 59;
	                    }
	                    else if($e_marks == 90){
	                        $min = 30;
	                        $third_min = 40;
	                        $sec_min = 53;
	                    }
	                    else if($e_marks == 80){
	                        $min = 27;
	                        $third_min = 35;
	                        $sec_min = 47;
	                    }
	                    else if($e_marks == 70){
	                        $min = 23;
	                        $third_min = 31;
	                        $sec_min = 41;
	                    }
	                    else if($e_marks == 50){
	                        $min = 17;
	                        $third_min = 22;
	                        $sec_min = 29;
	                    }
        
	                    if($result['marks'] <= $min){
	                        $fail = $fail + 1;
	                    }
	                    else if($result['marks'] >= $min && $result['marks'] <= $third_min){
	                        $thirddiv = $thirddiv + 1;
	                    }
	                    else if($result['marks'] > $third_min && $result['marks'] <= $sec_min){
	                        
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
	                
	                $temp['teacher'] = $sub_list['teacher_name'];	//teacher name
	                $temp['subject'] = $sub_list['subject_name'].'['.$sub_list['s_group'].']';	//subject name
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
	    }
	    $new_final = array_map("unserialize", array_unique(array_map("serialize", $new_final)));
	    return $new_final;
	}
	
	function teacher_abstract_final_class_mid($data){
		$this->db->select('hcs.id,hcs.subject,hcs.type');
		$this->db->join('subjects_11_12 hcs','hcs.id = sf.sub_id');
		$subjects = $this->db->get_where('subject_format_11_12 sf',array('sf.e_type'=>'final','sf.class'=>$data['class']))->result_array();
		
		$sub_lists = array();
		foreach($subjects as $subject){
			array_push($sub_lists, $subject['id']);
		}
		$sub_lists = array_unique($sub_lists);
	
		$final = array();
		foreach($sub_lists as $sub_list){
			if($sub_list == 13 || $sub_list == 14 || $sub_list == 15 || $sub_list == 16 || $sub_list == 17){
				continue;
			}
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
			$subject_name = $this->db->get_where('subjects_11_12',array('id'=>$sub_list))->result_array();
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
				
			$mark_master_ids = array();
			foreach($mark_masters as $mark_master){
				array_push($mark_master_ids, $mark_master['id']);
			}
				
			if(count($mark_masters) > 0){
				$this->db->select('*');
				$this->db->where_in('hm_id',$mark_master_ids);
				$results = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks<>'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('max(cast(marks as UNSIGNED)) as max ,sum(marks) as total');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$notapper = $this->db->get_where('student_marks_high_class',array('session'=>$data['session'],'marks'=>'A','class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$this->db->select('count(*) as notapper');
				$this->db->where_in('hm_id',$mark_master_ids);
				$no_of_students = $this->db->get_where('student_marks_high_class',array())->result_array();
				$no_of_students = $no_of_students[0]['notapper'];
	
				$this->db->select('count(*) as get_max');
				$this->db->where_in('hm_id',$mark_master_ids);
				$result_1 = $this->db->get_where('student_marks_high_class',array('marks'=>$result[0]['max'],'session'=>$data['session'],'class_id'=>$data['class'],'section_id'=>$data['section'],'subject_id'=>$sub_list,'e_type'=>$data['type']))->result_array();
	
				$max_marks_get = $result_1[0]['get_max'];
				$max = $result[0]['max'];
				$notapper = $notapper[0]['notapper'];
				$total =  $result[0]['total'];
	
				$fail = 0;
				$firstdiv = 0;
				$seconddiv = 0;
				$thirddiv = 0;
	
				$this->db->select('*');
				$hight_mark = $this->db->get_where('subject_format_11_12',array('sub_id'=>$sub_list,'class'=>$data['class'],'e_type'=>'mid'))->result_array();
				$hight_mark = $hight_mark[0]['subj_marks'];
	
				$fail = 0;
				$thirddiv = 0;
				$seconddiv = 0;
				$firstdiv = 0;
				foreach($results as $result){
					$result['marks'] = ($result['marks'] / $hight_mark )* 100 ;
					if($hight_mark == 100){
						$min = 32;
						$third_min = 44;
						$sec_min = 59;
					}
					else if($hight_mark == 90){
						$min = 30;
						$third_min = 40;
						$sec_min = 53;
					}
					else if($hight_mark == 80){
						$min = 27;
						$third_min = 35;
						$sec_min = 47;
					}
					else if($hight_mark == 70){
						$min = 23;
						$third_min = 31;
						$sec_min = 41;
					}
					else if($hight_mark == 50){
						$min = 17;
						$third_min = 22;
						$sec_min = 29;
					}
						
					if($result['marks'] <= $min){
						$fail = $fail + 1;
					}
					else if($result['marks'] >= $min && $result['marks'] <= $third_min){
						$thirddiv = $thirddiv + 1;
					}
					else if($result['marks'] > $third_min && $result['marks'] <= $sec_min){
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
				$temp['total'] =  $total;
				$temp['high_marks'] = $hight_mark;
				$temp['pi'] = round(($total / (($temp['notapper']) * $hight_mark))*100,2);
				$final[] = $temp;
			}
		}
		return $final;
	}
}