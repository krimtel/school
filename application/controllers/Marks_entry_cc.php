<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry_cc extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url','download'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
		$this->load->model(array('Admin_model','Result_model','Student_model'));
		$this->load->model('student_model_cc','std_model');	
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
    public function index(){
        $data['power'] = $this->power();
        if($this->session->userdata('utype') == 'Teacher'){
            $data['class_teacher'] = $this->is_class_teacher();
            $data['entry_11_12'] = $this->entry_11_12();
            $data['entry_1_10'] = $this->entry_1_10();
            $data['medium'] = $this->teacher_medium();
        }
        else{
            $data['class_teacher'] = 1;
            $data['entry_11_12'] = 1;
            $data['entry_1_10'] = 1;
        }
        $data['title'] = $this->session->userdata('school') .' | Marks Entry';
        $data['header'] = $this->load->view('pages/common/header',$data,true);
        $data['topbar'] = $this->load->view('pages/common/topbar','',true);
        $data['aside'] = $this->load->view('pages/common/aside','',true);
        $data['footer'] = $this->load->view('pages/common/footer','',true);        
        
		
		$this->load->model('student_model_cc','std_model');	
		$data['medium_list']=$this->std_model->medium_list();
        $data['exam_type_list']=$this->std_model->exam_type_list();
        $data['class_list']=$this->std_model->class_list();
        $data['section_list']=$this->std_model->section_list();
		
        $data['page'] = $this->load->view('pages/transaction/marks_entry_cc',$data,true);
        $this->load->view('pages/index',$data);
    }

	
	
	public function select_box(){
		$class_id=$this->input->post('class_id');
		$medium_id=$this->input->post('medium_id');
		
		$data['subject_list']=$this->std_model->subject_list($class_id, $medium_id);
		
		$data['page'] = $this->load->view('pages/transaction/marks_entry_cc',$data,true);
		echo json_encode(array('data'=>$data['subject_list']));
		}


    public function search_list(){ 
        $session_id= (int)$this->Admin_model->current_session();
		$school_id= (int)$this->session->userdata('school_id');
    	$medium=(int)$this->input->post('medium');
    	$e_type=(int)$this->input->post('e_type');
    	$class=(int)$this->input->post('class');
    	$section=(int)$this->input->post('section');
    	$subject=(int)$this->input->post('subject');
		 
    	//---------input box validation -------------------------------------------
    	$this->db->select('*');
		$this->db->from('cc_exam_type');
		$this->db->where('exam_type_id', $e_type);
		$result=$this->db->get()->result_array();
    	$e_type_name=$result[0]['et_name'];
		
		$this->db->select('*');
		$this->db->from('cc_subject');
		$this->db->where('sub_id', $subject);
		$result=$this->db->get()->result_array();
    	$sub_type=$result[0]['sub_type'];
		
		$this->db->select('*');
		$this->db->from('class');
		$this->db->where('c_id', $class);
		$result=$this->db->get()->result_array();
    	$class_name=$result[0]['name'];
		//print_r($class_name); die;
		
		$max='';	
    	if(($e_type_name == 'FA1' || $e_type_name =='FA2' || $e_type_name =='FA3' || $e_type_name =='FA4') && ($sub_type=='1'))
    	{ $max="20"; }
    	elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='NURSERY' || $class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V '))
    	{ $max="3"; }
    	elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
    	{ $max="5"; }
    	elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='1'))
    	{ $max="80"; }	
    	elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='2') && ($class_name=='NURSERY') || ($class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V '))
    	{ $max="3"; }
    	elseif(($e_type_name=='SA1' || $e_type_name=='SA2')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
    	{ $max="5"; }
        //-----------------------end of input box validation------------------------------------------------------
    	
    	
    	
    	$result = $this->std_model->search_list($session_id, $school_id, $medium, $e_type, $class, $section, $subject);
    	
    	if(count($result)>0){
    	    echo json_encode(array('data'=>$result,'max'=>$max,'msg'=>'student records','status'=>200));
    	}else{
    	    echo json_encode(array('msg'=>'No record found..','status'=>500));
    	}
        //----------------------end not selected file proccess -----------------------------------------------------------------------
    }

    public function search_csv(){
            $session_id= (int)$this->Admin_model->current_session();
            $school_id= (int)$this->session->userdata('school_id');
            $medium=(int)$this->input->post('medium');
            $e_type=(int)$this->input->post('e_type');
            $class=(int)$this->input->post('class');
            $section=(int)$this->input->post('section');
            $subject=(int)$this->input->post('subject');
            
            $config['upload_path'] = './csv/';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '10000';
            
            $this->upload->initialize($config);
            
            
            // If upload failed, display error
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                echo json_encode(array('msg'=>$data['error'],'status'=>500));
               // print_r ($data['error']); die;
            } else {
                $file_data = $this->upload->data();
                $file_path =  './csv/'.$file_data['file_name'];
                
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    
                    $class_name = $csv_array[0]['Class'];
                    
                    $this->db->select('c_id');
                    $this->db->from('class');
                    $this->db->where('name LIKE', $class_name);
                    $this->db->where('status',1);
                    $result=$this->db->get()->result_array();
                    $csv_class = (int)$result[0]['c_id'];
                    
                    $section_name = $csv_array[0]['Section'];
                    $this->db->select('id');
                    $this->db->from('section');
                    $this->db->where('name LIKE', $section_name);
                    $this->db->where('status',1);
                    $result=$this->db->get()->result_array();
                    $csv_section = (int)$result[0]['id'];
                    
                    $medium_name = $csv_array[0]['Medium'];
                    $this->db->select('medium_id');
                    $this->db->from('cc_medium');
                    $this->db->where('m_name LIKE', $medium_name);
                    $this->db->where('status',1);
                    $result=$this->db->get()->result_array();
                    $csv_medium = (int)$result[0]['medium_id'];
                    
                    $exam_type = $csv_array[0]['Exam_Type'];
                    $this->db->select('exam_type_id');
                    $this->db->from('cc_exam_type');
                    $this->db->where('et_name LIKE', $exam_type);
                    $this->db->where('status',1);
                    $result=$this->db->get()->result_array();
                    $csv_e_type = (int)$result[0]['exam_type_id'];
                    
                    
                    $subject_type = $csv_array[0]['Subject_Type'];
                    $this->db->select('id');
                    $this->db->from('cc_subject_type');
                    $this->db->where('sub_type LIKE', $subject_type);
                    $this->db->where('status', 1);
                    $result=$this->db->get()->result_array();
                    $csv_sub_type = (int)$result[0]['id'];
                    
                    
                    $subject_name = $csv_array[0]['Subject'];
                    $this->db->select('sub_id');
                    $this->db->where('sub_name LIKE', $subject_name);
                    $result = $this->db->get_where('cc_subject',array('class_id'=>$csv_class,'medium_id'=>$csv_medium,'sub_type'=>$csv_sub_type))->result_array();
                    $csv_subject = (int)$result[0]['sub_id'];
                    
                    
                    //------------------------input box validation------------------------------------------
                    $this->db->select('*');
                    $this->db->from('cc_exam_type');
                    $this->db->where('exam_type_id', $e_type);
                    $result=$this->db->get()->result_array();
                    $e_type_name=$result[0]['et_name'];
                    
                    $this->db->select('*');
                    $this->db->from('cc_subject');
                    $this->db->where('sub_id', $subject);
                    $result=$this->db->get()->result_array();
                    $sub_type=$result[0]['sub_type'];
                    
                    $this->db->select('*');
                    $this->db->from('class');
                    $this->db->where('c_id', $class);
                    $result=$this->db->get()->result_array();
                    $class_name=$result[0]['name'];
                    //print_r($class_name); die;
                    $max='';
                    if(($e_type_name == 'FA1' || $e_type_name =='FA2' || $e_type_name =='FA3' || $e_type_name =='FA4') && ($sub_type=='1'))
                    { $max="20"; }
                    elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='NURSERY' || $class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V '))
                    { $max="3"; }
                    elseif(($e_type_name=='FA1' || $e_type_name=='FA2' || $e_type_name=='FA3' || $e_type_name=='FA4')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
                    { $max="5"; }
                    elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='1'))
                    { $max="80"; }
                    elseif(($e_type_name=='SA1' || $e_type_name=='SA2') && ($sub_type=='2') && ($class_name=='NURSERY') || ($class_name=='LKG' || $class_name=='UKG' || $class_name=='I' ||$class_name=='II' || $class_name=='III' || $class_name=='IV' || $class_name=='V '))
                    { $max="3"; }
                    elseif(($e_type_name=='SA1' || $e_type_name=='SA2')&& ($sub_type=='2') && ($class_name=='VI' || $class_name=='VII' || $class_name=='VIII'))
                    { $max="5"; }
                    //--------------end of input box validation--------------------------------------------------------------------
                    
                    if($csv_class==$class){
                        
                        if($csv_e_type==$e_type){
                            
                            if($csv_medium==$medium){
                                
                                if($csv_section==$section){
                                    
                                    if($csv_subject==$subject){
                           
                                       
                                        $result = $this->std_model->search_list($session_id, $school_id, $medium, $e_type, $class, $section, $subject);
                                        
                                        
                                        if(count($csv_array)==count($result))
                                        {
                                        
                                            $students = array();
                                            foreach($result as $resultdata){
                                                $temp = $resultdata;
                                                foreach($csv_array as $csv){
                                                    if($resultdata['admission_no'] == $csv['Admission_No']){
                                                        $temp['s_id'] = $resultdata['s_id'];
                                                        $temp['roll_no'] = $resultdata['roll_no'];
                                                        $temp['marks'] = $csv['Marks'];
                                                        $students[] = $temp;
                                                    }
                                                    else{
                                                        continue;
                                                    } //end else condition
                                                }//end second foreach loop
                                            }//end first foreach loop
                                            
                                            if(count($students)>0){
                                                        echo json_encode(array('data'=>$students, 'msg'=>'student records','status'=>200));
                                                    }else{
                                                        echo json_encode(array('msg'=>'No record found..','status'=>500));
                                                    }
                                        }else{ 
                                            $not_recod=count($result)-(count($csv_array));
                                            echo json_encode(array('msg'=>$not_recod.' Students record not found..','status'=>500));
                                        }
                                    }else{
                                        echo json_encode(array('msg'=>'subject miss match...','status'=>500));
                                    }
                                }else{
                                    echo json_encode(array('msg'=>'section miss match...','status'=>500));
                                }
                            }else{
                                echo json_encode(array('msg'=>'medium miss match...','status'=>500));
                            }
                        }else{
                            echo json_encode(array('msg'=>'Exam type miss match...','status'=>500));
                        }
                    }else{
                        echo json_encode(array('msg'=>'Class miss match...','status'=>500));
                    }
                    
                } // end of csv import..
            } //end of else condition.
    }
    
    
	public function marks_entry(){
		//print_r($this->input->post()); die;
		$session_id= (int)$this->Admin_model->current_session(); 
		$school_id= (int)$this->session->userdata('school_id');
		$medium=(int)$this->input->post('medium');
    	$e_type=(int)$this->input->post('e_type');
    	$class=(int)$this->input->post('class');
    	$section=(int)$this->input->post('section');
    	$subject=(int)$this->input->post('subject');
 		$created_by = $this->session->userdata('user_id');
		$created_at = date('Y-m-d H:i:s');
		$marks=$this->input->post('marks');
		
		$this->db->select('*');
		$this->db->from('cc_exam_type');
		$this->db->where('exam_type_id', $subject);
		$result=$this->db->get()->result_array();
    	$max_mark=$result[0]['max_marks'];
		$con_mark=$result[0]['con_marks'];
		
		
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
				$status = 1;
				$marks_master_id=$result[0]['id'];
		}else{
				$status= 0;
				$marks_master_id= 0;
			}
		
		
    	$std_marks = array();
    	foreach($marks as $mark){
    		$temp=$mark;
    		$temp['con_marks']=($mark['val'] * $con_mark) / $max_mark;
    		$temp['session_id']=$session_id;
    		$temp['school_id']=$school_id;
    		$temp['medium']=$medium;
    		$temp['e_type']=$e_type;
    		$temp['class']=$class;
    		$temp['section']=$section;
    		$temp['subject']=$subject;
			$temp['student_id'] = $mark['s_id'];
			$temp['created_by']=$created_by;
			$temp['created_at']=$created_at;
			$temp['status']=$status;
			$temp['m_tbl_id']=$marks_master_id;
			
    		$std_marks[]=$temp;
    	}

    	
    	$result = $this->std_model->marks_entry($std_marks);
		if($result){
			echo json_encode(array('status'=>200));	
			}else{
			echo json_encode(array('status'=>500));
		}
	}
	
	function csv_export()
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
		$prestasi->setCellValue('H1', 'Student_Name');
		$prestasi->setCellValue('I1', 'Admission_No');
		$prestasi->setCellValue('J1', 'Roll_No');
		$prestasi->setCellValue('K1', 'Marks');
		$prestasi->setCellValue('L1', 'Converted_Marks');

	    
	    //----------------data coming from model -------------------------------------
	    $data['query'] = $this->std_model->csv_export_model();
	    //-------------------------------------------------------------------------
	    
	    $no=0;
	    $rowexcel = 1;
	    foreach($data['query'] as $row)
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
	        $prestasi->setCellValue('K'.$rowexcel, $row["Marks"]);
	        $prestasi->setCellValue('L'.$rowexcel, $row["Converted_Mark"]);
	       }
	    //$prestasi->setTitle('Customer Report');
	    
	    $date =date('U');
	    //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	   $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
	   
	    //ob_end_clean();
	    if(!is_dir('./backup_marks')){
	        mkdir('./backup_marks');
	    }
	    
	    $filename = "backup_marks/StudentMarksRecord_".$data['query'][0]['Class']."_".$data['query'][0]['Section']."_".$date.".xlsx";
	   
	    $objWriter->save($filename);
	       $result = array(
    	        'file_name' => $filename,
    	        'file_path' =>$filename
	       );
	       //print_r($filename); die;
	       $this->load->helper('download');
	       force_download('./'.$filename, NULL);
	           
	}
	
	
}


