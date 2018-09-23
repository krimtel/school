<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ravi_student_model extends CI_Model {

    public function classwise_pre($data){
        $class_id  = $data['class_id'];
        $section   = $data['section'];
        $medium    = $data['medium'];
        $school_id = $data['school_id'];
        $session   = $data['session'];
        $type      = $data['type'];
        $fit       = $data['fit'];

        if($type == 'pre'){
            $type = 1;
        }
        if($type == 'mid'){
            $type = 4;
        }
        if($type == 'post_mid'){
            $type = 6;
        }
        if($type == 'post_mid'){
            $type = 9;
        }
        
        //-----------------list of students---------------------------------------------
        $this->db->select('s_id');
        $student_list = $this->db->get_where('student', array(
                        'session'=>$session,
                        'class_id'=>$class_id,
                        'section'=>$section,
                        'medium'=>$medium,
                        'school_id'=>$school_id,
                        'status'=>1))->result_array();
        
       
        $students = array();
        foreach($student_list as $student){
            $temp = array();
            $temp['s_id'] = $student['s_id'];
            $students[] = $temp;
        }
        
        $data = array_column($students,'s_id'); //-----convert to single array----------
        $std_id = implode(', ', $data); // ------ convert to string-----
        
//---------------list of subjects----------------------------------------------
        $this->db->select('s.*');
        $this->db->join('subject s','s.sub_id = cs.subject_id');
        $subject_lists = $this->db->get_where('class_sujects cs',array(
                         'cs.class_id'=>$class_id,
                         's.subj_type'=>'Scholastic',
                         'cs.status'=>1))->result_array();
        //---------get subject id--------------------------------
        $sub_ids = array();
        foreach($subject_lists as $sub){
            $temp = array();
            $temp['sub_id'] = $sub['sub_id'];
            $sub_ids[] = $temp;
        }
        
        $data = array_column($sub_ids,'sub_id'); //-----convert to single array----------     
        $sub_id = implode(', ', $data); // ------ convert to string-----
        
        
//---------------list of marks master table----------------------------------------------
        $this->db->select('*');
        $this->db->where('sub_id IN('.$sub_id.')');
        $mark_master = $this->db->get_where('mark_master',array(
            'session_id'=>$session,
            'school_id'=>$school_id,
            'medium'=>$medium,
            'e_type'=>$type,
            'class_id'=>$class_id,
            'section'=>$section,
            'status'=>1))->result_array();
       
        $master_id = array();
        foreach($mark_master as $m_master){
            $temp = array();
            $temp['m_id'] = $m_master['m_id'];
            $master_id[] = $temp;
        }
        $data = array_column($master_id,'m_id'); //-----convert to single array----------
        $m_id = implode(', ', $data); // ------ convert to string-----        
        //--------------------------------------------------------------------------------------
        
        $this->db->select('sm.student_id,sm.marks, s.name as student_name, ses.name as session, sm.medium as medium, cl.name as class, sec.name as section, sub.name as subject, et.e_name as exam_type');
        $this->db->join('student s','s.s_id=sm.student_id','inner');
        $this->db->join('session ses','ses.session_id=sm.session_id','inner');
        $this->db->join('class cl','cl.c_id=sm.class_id','inner');
        $this->db->join('section sec','sec.id=sm.section_id','inner');
        $this->db->join('subject sub','sub.sub_id=sm.subject_id','inner');
        $this->db->join('exam_type et','et.e_id=sm.e_type','inner');
        $this->db->where('sm.mm_id IN('.$m_id.')');
        $this->db->where('sm.subject_id IN('.$sub_id.')');
       $student_marks =  $this->db->get_where('student_mark sm',array(
            'sm.session_id'=>$session,
            'sm.medium'=>$medium,
            'sm.class_id'=>$class_id,
            'sm.section_id'=>$section,
            'sm.e_type'=>$type,
        ))->result_array();
       
        $final = array();
        foreach($student_marks as $smarks){
            $key = $smarks['student_id'];
            $final[$key][] = $smarks;
        }
        
        $final_data = array_values($final);
//        // print_r($final_data); die;
//         $data = array();
//         foreach($final_data[0] as $smarks){
//             $temp = array();
//             $temp['result']['subject'] = $smarks['subject'];
//             $temp['result']['marks'] = $smarks['marks'];
//             $data[] = $temp;
//         }
//         print_r($data); die;
        
        $marks = array();
        foreach($student_marks as $smarks){
            $temp = array();
            $temp['student_id'] = $smarks['student_id'];
            $temp['subject'] = $smarks['subject'];
            $temp['marks'] = $smarks['marks'];
            $marks[] = $temp;
        }
        
        $s_list = array();
        foreach($final_data as $final){   
                $temp = array();
                $temp['student_id'] = $final[0]['student_id'];
                $temp['student_name'] = $final[0]['student_name'];
                $temp['session'] = $final[0]['session'];
                $temp['medium'] = $final[0]['medium'];
                $temp['class'] = $final[0]['class'];
                $temp['section'] = $final[0]['class'];
                $temp['exam_type'] = $final[0]['exam_type'];        
                $s_list[] = $temp;
           }   
           //print_r($s_list); die;
           
            
           $student = array();
           $student_marks = array();
           foreach($s_list as $students){
               $temp = array();
               $temp['student_id'] = $students['student_id'];
               $temp['student_name'] = $students['student_name'];
               $temp['session'] = $students['session'];
               $temp['medium'] = $students['medium'];
               $temp['class'] = $students['class'];
               $temp['section'] = $students['class'];
               $temp['exam_type'] = $students['exam_type']; 
               $student[] = $temp;
               foreach($marks as $mark){
                   if($mark['student_id'] == $temp['student_id']){
                       $temp1 = array();
                       $temp1['subject'] = $mark['subject'];
                       $temp1['marks'] = $mark['marks']; 
                       $student[] = $temp1;
                       
                   } 
               }
           }
           print_r($student); die;
        
    }//----end of function-------
}//---end of class-----------