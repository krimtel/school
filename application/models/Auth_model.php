<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	
	function login($data){
		$this->db->select('u.*,s.name s_name,s.sid');
		$this->db->join('school s','s.sid = u.school_id');
		$result = $this->db->get_where('users u',array('u.uname'=>$data['uname'],'u.password'=>$data['password'],'status'=>1))->result_array();
		if(count($result) == 1){
			return $result;
		}
	}
}