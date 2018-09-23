<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model(array('Admin_model'));
    }
    
    public function subject_create(){
    	$data['name'] = $this->input->post('text');
    	$data['subj_type'] = $this->input->post('type'); 
    	$data['sub_id'] = $this->input->post('s_id');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d h:i:sa');
    	$data['ip'] = $this->input->ip_address();
    	
    	$this->db->trans_begin();
    		if($data['sub_id'] == '0'){
    			$this->db->insert('subject',$data);
    			$x = $this->db->insert_id();
    			
    			$this->db->select('*');
    			$result = $this->db->get_where('subject',array('sub_id'=>$x))->result_Array();
    		}
    		else{
    			$this->db->where('sub_id',$data['sub_id']);
    			$data1['name'] = $data['name'];
    			$data1['subj_type'] = $data['subj_type'];
    			$this->db->update('subject',$data1);
    		}
    	
    	if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'something went wrong.','status'=>500));
    	}
    	else{
    		$this->db->trans_commit();
    		if($data['sub_id'] == ''){
    			echo json_encode(array('data'=>$result,'msg'=>'recentally add class.','status'=>200));
    		}
    		else{
    			echo json_encode(array('msg'=>'class updated.','status'=>300));
    		}
    	}
    }
    
    function subject_status(){
    	$data['class_id'] = $this->input->post('cid');
    	$data1['status'] = $this->input->post('val');
    	 
    	$this->db->where('c_id',$data['class_id']);
    	$this->db->update('class',$data1);
    }
    
    function subject_delete(){
    	$data['sub_id'] = $this->input->post('sid');
    	 
    	$this->db->where('sub_id',$data['sub_id']);
    	$this->db->delete('subject');
    	echo json_encode(array('msg'=>'Subject Deleted Successfully.','status'=>200));
    }
    
    function subject_detail(){
    	$data['sub_id'] = $this->input->post('sid');
    	
    	$result = $this->db->get_where('subject',array('sub_id'=>$data['sub_id']))->result_array();
    	echo json_encode(array('data'=>$result,'msg'=>'subject detail.','status'=>200));
    }
    
    function subject_list(){
    	$school_id = $this->session->userdata('school_id');
    	$data['c_id'] = $this->input->post('c_id');
    	$data['e_type'] = $this->input->post('e_type');
    	$data['section'] = $this->input->post('section');
    	
    	if($this->session->userdata('utype') == 'Teacher'){
    		$result = $this->db->get_where('users',array('uid'=>$this->session->userdata('user_id')))->result_array();
    		$t_id = $result[0]['t_id'];
    		
    		$this->db->select('*');
    		$class_teacher = $this->db->get_where('class_teachers',array('class_id'=>$data['c_id'],'section'=>$data['section'],'school_id'=>1,'teacher_id'=>$t_id,'status'=>1))->result_array();
    		
    		if(count($class_teacher)>0){
    			$this->db->select('subject_id');
    			//$subjects = $this->db->get_where('class_sujects',array('class_id'=>$data['c_id'],'status'=>1))->result_array();
    			$subjects = $this->db->get_where('subject_allocation',array('teacher_id'=>$t_id,'class_id'=>$data['c_id'],'section_id'=>$data['section'],'status'=>1))->result_array();
    		}
    		else{
	    		$this->db->select('subject_id');
	    		$subjects = $this->db->get_where('subject_allocation',array('teacher_id'=>$t_id,'class_id'=>$data['c_id'],'section_id'=>$data['section'],'status'=>1))->result_array();
    		}
    		
    		$t_sub = array();
    		foreach($subjects as $subject){
    			array_push($t_sub, $subject['subject_id']);
    		}
    		
	    		$this->db->select('cs.*,s.sub_id,s.name,s.subj_type');
	    		$this->db->join('subject s','s.sub_id = cs.subject_id');
	    		$this->db->where_in('cs.subject_id',$t_sub);
	    		if($data['e_type'] == 4 || $data['e_type'] == 9){
	    			$result = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['c_id']))->result_array();
	    		}
	    		else{
	    			$this->db->where_not_in('s.subj_type','Co-Scholastic');
	    			$result = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['c_id']))->result_array();
	    		}
	    		
    	}
    	else{
    		$this->db->select('cs.*,s.sub_id,s.name,s.subj_type');
    		$this->db->join('subject s','s.sub_id = cs.subject_id');
    		if($data['e_type'] == 4 || $data['e_type'] == 9){
    			$this->db->where_not_in('s.subj_type');
    			$result = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['c_id']))->result_array();
    		}
    		else{
    			$this->db->where_not_in('s.subj_type','Co-Scholastic');
    			$result = $this->db->get_where('class_sujects cs',array('cs.class_id'=>$data['c_id']))->result_array();
    		}
    		
    	}
    	$sch_sub = array();
    	$cosch_sub = array();
    	foreach($result as $r){
    		if($r['subj_type'] == 'Scholastic'){
    			array_push($sch_sub, $r);
    		}
    		else{
    			array_push($cosch_sub, $r);
    		}
    	}
    	$merge = array_merge($sch_sub,$cosch_sub);
    	if(count($result)>0){
    		echo json_encode(array('data'=>$merge,'msg'=>'Subject List','status'=>200));
    	}
    	else{
    		echo json_encode(array('msg'=>'No Record Found.','status'=>500));
    	}
    }
    
    function marks_entry(){
    	$data['session_id'] = $this->Admin_model->current_session();
    	$data['medium'] = $this->input->post('medium');
    	$data['class_id'] = $this->input->post('class');
    	$data['section_id'] = $this->input->post('section');
    	$data['subject_id'] = $this->input->post('subject');
    	$data['e_type'] = $this->input->post('e_type');
    	$data1['marks'] = $this->input->post('marks');
    	$data1['notebook'] = $this->input->post('notebook_mark');
    	$data1['subj_anrich'] = $this->input->post('subj_anric_mark');
    	$data1['practical'] = $this->input->post('p_marks');
    	$data['school_id'] = $this->session->userdata('school_id');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d H:i:s');
    	$data['ip'] =  $this->input->ip_address();
    	$update = 0;
    	
    	
    	$this->db->trans_begin();
    	$this->db->select('*');
    	$result = $this->db->get_where('mark_master',array('school_id'=>$data['school_id'],
    			'e_type'=>$data['e_type'],
    			'class_id'=>$data['class_id'],
    			'section'=>$data['section_id'],
    			'medium'=>$data['medium'],
    			'sub_id'=>$data['subject_id'],
    			'status' => 1
    	))->result_array();
    	//print_r($this->db->last_query()); die;
    	if(count($result) > 0){
    		$update = 1;
	    	$this->db->where('m_id',$result[0]['m_id']);
	    	$update_array = array('status' => 0);
	    	$this->db->update('mark_master',$update_array);
	    	//$this->db->delete('mark_master');
    	}
    	
    	$mark_master = array(
    			'session_id'=> $data['session_id'],
    			'e_type'=> $data['e_type'],
    			'class_id' => $data['class_id'],
    			'section' => $data['section_id'],
    			'medium'=> $data['medium'],
    			'school_id' => $data['school_id'],
    			'created_by' => $data['created_by'],
    			'sub_id' => $data['subject_id'],
    			'created_at' => $data['created_at'],
    			'status' => 1
    	);
    	
    	$final_entry = array();
    	$this->db->insert('mark_master',$mark_master);
    	$x = $this->db->insert_id();
    	foreach($data1['marks'] as $mark){
    		$temp = array();
    		$temp = $data;
    		unset($temp['school_id']);
    		$temp['student_id'] = $mark['s_id'];
    		$temp['marks'] = $mark['val'];
    		$temp['mm_id'] = $x;
    		$final_entry[] = $temp;
    	}
    	
    	$notebook_entry = array();
    	if(count($data1['notebook'])>0){
	    	foreach($data1['notebook'] as $notebook){
	    		foreach($data1['subj_anrich'] as $anrich){
	    		    if(count($data1['notebook'])>0)
	    			$temp = array();
	    			if(count($data1['practical'])>0){
	    			    foreach($data1['practical'] as $practical){
	    			        if($notebook['s_id'] == $anrich['s_id'] && $notebook['s_id'] == $practical['s_id']){
	    			            $temp['s_id'] = $notebook['s_id'];
	    			            $temp['n_mark'] = $notebook['val'];
	    			            $temp['a_mark'] = $anrich['val'];
	    			            $temp['p_mark'] = $practical['val'];
	    			            $notebook_entry[] = $temp;
	    			        }
	    			        else{
	    			            continue;
	    			        }
	    			    }
	    			}
	    			else{
    	    			if($notebook['s_id'] == $anrich['s_id']){
    	    				$temp['s_id'] = $notebook['s_id'];
    	    				$temp['n_mark'] = $notebook['val'];
    	    				$temp['a_mark'] = $anrich['val'];
    	    				$notebook_entry[] = $temp;
    	    			}
    	    			else{
    	    				continue;
    	    			}
	    			}
	    		}
	    	}
    	}
    	else{
    		if(count($data1['practical'])>0){
	    		foreach($data1['practical'] as $p_marks){	
	    			$temp = array();
	    			$temp['s_id'] = $p_marks['s_id'];
	    			$temp['p_mark'] = $p_marks['val'];
	    			$notebook_entry[] = $temp;
	    		}
    		}
    	}
    	
    	$notebook_db_entry = array();
    	if(count($notebook_entry)>0){
	    	foreach($notebook_entry as $notebook){
	    		$temp = array();
	    		$temp = $data;
	    		unset($temp['school_id']);
	    		$temp['student_id'] = $notebook['s_id'];
	    		if(count($data1['notebook'])>0){
	    			$temp['notebook_mark'] = $notebook['n_mark'];
	    			$temp['subj_enrich'] = $notebook['a_mark'];
	    			if(count($data1['practical'])>0){
	    			    $temp['p_marks'] = $notebook['p_mark'];
	    			}
	    		}
	    		else{
	    			$temp['p_marks'] = $notebook['p_mark'];
	    		}
	    		$temp['mm_id'] = $x;
	    		$notebook_db_entry[] = $temp;
	    	}
    	}
 
    	 $this->db->insert_batch('student_mark',$final_entry);
    	 if(count($notebook_entry)>0){
    	 	$this->db->insert_batch('notebook_marks',$notebook_db_entry);
    	 }
    	 
    	 if($update){
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
    	 }

    	 $this->db->insert('log_tab',$log_info);
    	 if ($this->db->trans_status() === FALSE){
    	 	$this->db->trans_rollback();
    	 	echo json_encode(array('status'=>500));
    	 }
    	 else{
    	 	$this->db->trans_commit();
    	 	$csv_download = $this->csv_download($data, $data1);
    	 	echo json_encode(array('csv_download'=>$csv_download, 'status'=>200));
    	 }
    }//end of marks entry function..
    
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
        if(!is_dir('./marks_entry')){
            mkdir('./marks_entry');
        }
        
        $filename = "marks_entry/StudentMarksRecord_".$csv_data['query'][0]['Class']."_".$csv_data['query'][0]['Section']."_".$date.".xlsx";
        
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
    

    function subject_allocation(){
    	$data['teacher_id'] =  $this->input->post('teacher');
    	$data['class_id'] = $this->input->post('class');
    	$data1['section_id'] = $this->input->post('section');
    	$data['s_group'] = $this->input->post('s_group');
    	$data1['subject_id'] = $this->input->post('subject');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['school_id'] = $this->session->userdata('school_id');
    	$data['created_at'] = date('Y-m-d H:i:s');
    	$data['medium'] = $this->input->post('medium');
    	
    	
    	$final_entry = array();
    	foreach($data1['section_id'] as $section){
    	    foreach($data1['subject_id'] as $subject){
    	        $temp = $data;
    	        $temp['subject_id'] = $subject;
    	        $temp['section_id'] = $section; 
    	        $final_entry[]=$temp;
    	    } 
    	}
    	
    	$data['s_entry'] = $this->input->post('student-entry');
    	$data['m_entry'] = $this->input->post('marks-entry');
    	
    	$permission = array();
    	$text = '0';
    	if($data['s_entry'] || $data['m_entry']){
    		if($data['s_entry']){
    			$text  =  $text.','.'1';
    		}
    		if($data['m_entry']){
    			$text  =  $text.','.'2';
    		}
    		
    		$permission['permission'] = $text;
    		$permission['teacher_id'] = $data['teacher_id'];
    		
    		$this->db->where('teacher_id',$data['teacher_id']);
    		$this->db->delete('user_permission');
    		$this->db->insert('user_permission',$permission);
    	}
    	else{
    		$result = $this->db->get_where('user_permission',array('teacher_id'=>$data['teacher_id']));
    		if(count($result) > 0){ 
    			$this->db->where('teacher_id',$data['teacher_id']);
    			$this->db->delete('user_permission');
    		}
    	}
		if($data['class_id'] > 13){
			$this->db->where('s_group',$data['s_group']);
		}

		    
		  $section = implode(",",$data1['section_id']);
		    
		  $this->db->where(array('teacher_id'=>$data['teacher_id'],'medium'=>$data['medium'],'school_id'=>$data['school_id'],'class_id'=>$data['class_id']));
		  $this->db->where_in('section_id', $section); 
		  $this->db->delete('subject_allocation'); 
    	
    	$this->db->insert_batch('subject_allocation', $final_entry);
    	echo json_encode(array('status'=>200));
    }
	
	function elective_subject(){
		$result = $this->db->get_where('subject',array('subj_type'=>'Elective'))->result_array();
		echo json_encode(array('data'=>$result,'status'=>200));
	}
	
	function class_subject_fetch(){
		$data['class_id'] = $this->input->post('c_id');
		$this->db->select('subject_id');
		$result = $this->db->get_where('class_sujects',array('class_id'=>$data['class_id']))->result_array();
		if(count($result) > 0){
			echo json_encode(array('data'=>$result,'msg'=>'all subjeect in this subject','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'no record found.','status'=>500));
		}
	}
	
	function subject_entry_check(){
		$data['medium'] = $this->input->post('medium');
		$data['class'] = $this->input->post('class');
		$data['section'] = $this->input->post('section');
		$data['e_type'] = $this->input->post('e_type');
		$data['subject'] = $this->input->post('subject');
		$data['session_id'] = $this->Admin_model->current_session();
		
		$this->db->select('*');
		$result = $this->db->get_where('mark_master',array('session_id'=>$data['session_id'],'e_type'=>$data['e_type'],
				'class_id'=>$data['class'],
				'section'=>$data['section'],
				'sub_id'=>$data['subject'],
				'status'=>1
		))->result_array();
		
		
		if(count($result)>0){
			echo json_encode(array('msg'=>'Already submitted','status'=>500));
		}
		else{
			echo json_encode(array('msg'=>'okk','status'=>200));
		}
	}
	
// 	function subject_list_high_class(){
// 		$data['e_type'] = (int)$this->input->post('e_type');
// 		$data['s_group'] = $this->input->post('s_group');
// 		$data['class'] = (int)$this->input->post('class');
// 		$data['school_id'] = $this->session->userdata('school_id');
// 		$this->db->select('subf.id ,subf.sub_id,sub11.subject');
// 		$this->db->join('subjects_11_12 sub11','sub11.id = subf.sub_id');
// 		$result = $this->db->get_where('subject_format_11_12 subf',array('subf.class'=>$data['class'],'s_group'=>$data['s_group'],'subf.e_type'=>$data['e_type'],'subf.status'=>1))->result_array();
// 		if(count($result)>0){
// 			echo json_encode(array('data'=>$result,'status'=>200));
// 		}
// 		else{
// 			echo json_encode(array('status'=>500));
// 		}
// 	}
	
	
	function subject_list_high_class(){
		$school_id = $this->session->userdata('school_id');
		$data['class'] = $this->input->post('class');
		$data['e_type'] = $this->input->post('e_type');
		$data['section'] = $this->input->post('section');
		$data['s_group'] = $this->input->post('s_group');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['medium']  = $this->input->post('medium');
		 
		if($this->session->userdata('utype') == 'Teacher'){
			$result = $this->db->get_where('users',array('uid'=>$this->session->userdata('user_id')))->result_array();
			$t_id = $result[0]['t_id'];
	
			$this->db->select('*');
			$class_teacher = $this->db->get_where('class_teachers',array('class_id'=>$data['class'],'section'=>$data['section'],'medium'=>$data['medium'],'school_id'=>$data['school_id'],'teacher_id'=>$t_id,'status'=>1))->result_array();
			
			if(count($class_teacher) > 0){
				if($data['e_type'] == 4){
					$data['e_type'] = 'mid';
				}
				if($data['e_type'] == 1){
					$data['e_type'] = 'pre';
					$this->db->where_not_in('subject_id',array('13','14','15','16','17'));
				}
				if($data['e_type'] == 6){
					$data['e_type'] = 'post';
					$this->db->where_not_in('subject_id',array('13','14','15','16','17'));
				}
				if($data['e_type'] == 9){
					$data['e_type'] = 'final';
				}
				$subjects = $this->db->get_where('subject_allocation',array('teacher_id'=>$t_id,'class_id'=>$data['class'],'section_id'=>$data['section'],'status'=>1))->result_array();
			}
			else{
				if($data['e_type'] == 4){
					$data['e_type'] = 'mid';
				}
				if($data['e_type'] == 1){
					$data['e_type'] = 'pre';
					$this->db->where_not_in('subject_id',array('13','14','15','16','17'));
				}
				if($data['e_type'] == 6){
					$data['e_type'] = 'post';
					$this->db->where_not_in('subject_id',array('13','14','15','16','17'));
				}
				if($data['e_type'] == 9){
					$data['e_type'] = 'final';
				}
				$subjects = $this->db->get_where('subject_allocation',array('teacher_id'=>$t_id,'class_id'=>$data['class'],'section_id'=>$data['section'],'status'=>1))->result_array();
			}
			
			$t_sub = array();
			foreach($subjects as $subject){
				array_push($t_sub, $subject['subject_id']);
			}
	
			$this->db->select('id as sub_id,subject,type,status');
			$this->db->where_in('sub11.id',$t_sub);
			$result = $this->db->get('subjects_11_12 sub11')->result_array();
		}
		else{
		    
			$this->db->select('subf.id ,subf.sub_id,sub11.subject,sub11.type');
			if($data['e_type'] == 4){
				$data['e_type'] = 'mid';
			}
			if($data['e_type'] == 1){
				$data['e_type'] = 'pre';
			}
			if($data['e_type'] == 6){
				$data['e_type'] = 'post';
			}
			if($data['e_type'] == 9){
				$data['e_type'] = 'final';
			}
			$this->db->join('subjects_11_12 sub11','sub11.id = subf.sub_id');
			$result = $this->db->get_where('subject_format_11_12 subf',array('subf.class'=>$data['class'],'s_group'=>$data['s_group'],'subf.e_type'=>$data['e_type'],'subf.status'=>1))->result_array();
		
		}
		
		if(count($result)>0){
			echo json_encode(array('data'=>$result,'msg'=>'Subject List','status'=>200));
		}
		else{
			echo json_encode(array('msg'=>'No Record Found.','status'=>500));
		}
	}
	
	function compart_marks_entry(){
		$data['session_id'] = $this->Admin_model->current_session();
		$data['medium'] = $this->input->post('medium');
		$data['class_id'] = $this->input->post('class');
		$data['section_id'] = $this->input->post('section');
		$data['subject_id'] = $this->input->post('subject');
		$data['e_type'] = $this->input->post('e_type');
		$data1['marks'] = $this->input->post('marks');
		$data['school_id'] = $this->session->userdata('school_id');
		$data['created_by'] = $this->session->userdata('user_id');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['ip'] =  $this->input->ip_address();
		$update = 0;
		 
		$this->db->trans_begin();
		
		foreach($data1['marks'] as $mrk){
			$this->db->where(array('medium'=>$data['medium'],
									'class'=>$data['class_id'],
									'section'=>$data['section_id'],
									'school'=>$data['school_id'],
									'student_id'=>$mrk['s_id'],
									'subject' => $data['subject_id']
			));
			$this->db->update('class_ix_compartment',array('n_marks'=>$mrk['val']));
		}
	
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