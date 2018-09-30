<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helth_model extends CI_Model {
    
    public function select_box_data(){
        $this->db->select('*');
        $data['session']  = $this->db->get_where('session', array('status'=>1))->result_array();
        
        $this->db->select('*');
        $data['class'] = $this->db->get_where('class',array('status'=>1))->result_array();
        
        $this->db->select('*');
        $data['section'] = $this->db->get_where('section', array('status'=>1))->result_array();
        
        return $data;
    }
    
    public function search_data($data){
        if($data['sub_group'] == 'bio'){
            $data['sub_group'] = 'Boilogy';
        }else if($data['sub_group'] == 'maths'){
            $data['sub_group'] = 'Maths';
        }else if($data['sub_group'] == 'commer'){
            $data['sub_group'] = 'Commerce';
        }else if($data['sub_group'] == 'art'){
            $data['sub_group'] = 'Arts';
        }
        
        $this->db->select('*');
        $result = $this->db->get_where('student', array('session'=>$data['session'],'school_id'=>$data['school'],'class_id'=>$data['class_id'],'section'=>$data['section'],'medium'=>$data['medium'],'status'=>1))->result_array();
        
        if($data['sub_group'] != NULL){
            $result = $this->db->get_where('student', array('session'=>$data['session'],'school_id'=>$data['school'],'class_id'=>$data['class_id'],'section'=>$data['section'],'medium'=>$data['medium'],'subject_group'=>$data['sub_group'],'status'=>1))->result_array();
        }
        return $result;
    }
    
}//end of class..........