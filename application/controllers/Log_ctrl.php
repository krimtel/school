<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_ctrl extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('form_validation','session','Csvimport','upload'));
		$this->load->database();
		$this->load->model(array('Admin_model'));
    }

    function log_report(){
    	$data['user_id'] = $this->input->post('user_id');
    	$data['from'] = $this->input->post('from');
    	$data['to'] = date('Y-m-d', strtotime(' +1 day'));
    	$result = $this->db->query("SELECT l.logid,t.name,stu.admission_no,sub.name sname,sub.subj_type,et.event_name,s.name school,c.name as cname,l.term,sec.name secname,sub.name subject,l.medium,l.logtime,l.status,l.student_id FROM log_tab l
			LEFT JOIN class c on c.c_id = l.class_id
			JOIN school s on s.sid = l.school_id
			LEFT JOIN section sec on sec.id = l.section_id
			LEFT JOIN subject sub on sub.sub_id = l.subject_id
			JOIN event_tab et on et.eid = l.eventid
			JOIN users u on u.uid = l.event_by
			LEFT JOIN teacher t on t.t_id = u.t_id
    		LEFT JOIN student stu on stu.s_id = l.student_id
			where l.logtime BETWEEN '".$data['from']."' AND '".$data['to']."'
			AND l.event_by = ".$data['user_id']."")->result_array();

    	if(count($result)>0){
    		echo json_encode(array('data'=>$result,'status'=>200));
    	}
    	else{
    		echo json_encode(array('status'=>500));
    	}
    }
}
