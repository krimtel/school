<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_hook extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	function pre_ctrl(){
		$this->load->library('session');
		if($this->session->userdata('user_id')){
			echo "sesion exist";
		}
		else{
			echo "session not exist"; 
		}
	}
	
}