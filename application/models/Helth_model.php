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
        
        $this->db->select('s.*, c.name as class_name, sec.name as section_name');
        $this->db->join('class c','c.c_id=s.class_id','innor');
        $this->db->join('section sec','sec.id=s.section','innor');
        if($data['sub_group'] != NULL){
            $this->db->where('s.subject_group',$data['sub_group']);
        }
        $result = $this->db->get_where('student s', array('s.session'=>$data['session'],'s.school_id'=>$data['school'],'s.class_id'=>$data['class_id'],'s.section'=>$data['section'],'s.medium'=>$data['medium'],'s.status'=>1))->result_array();
        
        return $result;
    }
    
}//end of class..........