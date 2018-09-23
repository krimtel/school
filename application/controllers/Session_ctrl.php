<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_ctrl extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
    
    public function session_create(){
    	$data['name'] = $this->input->post('text');
    	$data['created_by'] = $this->session->userdata('user_id');
    	$data['created_at'] = date('Y-m-d h:i:sa');
    	$data['ip'] = $this->input->ip_address();
    	 
    	$this->db->trans_begin();
    	$this->db->insert('session',$data);
    
    	$x = $this->db->insert_id();
    	$this->db->select('*');
    	$result = $this->db->get_where('session',array('session_id'=>$x))->result_Array();
    
    	if ($this->db->trans_status() === FALSE){
    		$this->db->trans_rollback();
    		echo json_encode(array('msg'=>'something went wrong.','status'=>500));
    	}
    	else{
    		$this->db->trans_commit();
    		echo json_encode(array('data'=>$result,'msg'=>'something went wrong.','status'=>200));
    	}
    }
    
    function Session_status(){
    	$data['session_id'] = $this->input->post('sid');
    	$data1['status'] = $this->input->post('val');
    	 
		$this->db->update('session',array('status'=>0));
		
    	$this->db->where('session_id',$data['session_id']);
    	$this->db->update('session',$data1);
		echo json_encode(array('status'=>200));
    }
    
    function Session_delete(){
    	$data['session_id'] = $this->input->post('sid');
    	 
    	$this->db->where('session_id',$data['session_id']);
    	$this->db->delete('session');
    	echo json_encode(array('msg'=>'Session Deleted Successfully.','status'=>200));
    }
}