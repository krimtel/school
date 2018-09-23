<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_webmodel extends CI_Model {
	
	function all_buses_stoppages($data){
		$this->db->select('*');
		$this->db->order_by($data['stoppege_name'], $data['direc']);
		$result = $this->db->get_where('bus_master',array('status'=>1))->result_array();
		return $result;
	}
	
	function add_buses_stoppages($data){
		$data1 = array(
			'stoppege_name' => $data['stoppege_name'],
			'price'			=> $data['price']				
		);
		$this->db->select('*');
		$bus = $this->db->get_where('bus_master',array('b_id'=>$data['b_id']))->result_array();
		if(count($bus) > 0){
			$this->db->where('b_id',$data['b_id']);
			$this->db->update('bus_master',$data1);
		}
		else{
			$this->db->insert('bus_master',$data1);
		}
		return true; 
	}
	
	function bus_delete($data){
		$this->db->where('b_id',$data['b_id']);
		$this->db->update('bus_master',array('status'=>0));
		return true;
	}
}