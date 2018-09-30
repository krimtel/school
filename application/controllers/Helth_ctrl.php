<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helth_ctrl extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation','session'));
        $this->load->database();
        $this->load->model('helth_model');
    }
    
    
    public function select_box_data(){
        $result = $this->helth_model->select_box_data();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function search_data(){
        $data['school'] = $this->session->userdata('school_id');
        $data['session'] = $this->input->post('session');
        $data['medium'] = $this->input->post('medium');
        $data['class_id'] = $this->input->post('class_id');
        $data['section'] = $this->input->post('section');
        $data['sub_group'] = $this->input->post('sub_group');
        
        $result = $this->helth_model->search_data($data);
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));            
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
}//end of class..........



