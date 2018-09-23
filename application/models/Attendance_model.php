<?php
class Attendance_model extends CI_Model {
	
	function add_attendance($data){
		$data['school_id'] = $this->session->userdata('school_id');
		$master = array(
				'session_id' 	=> $data['session_id'],
				'medium' 		=> $data['medium'],
				'school_id'		=> $data['school_id'],
				'class_id' 		=> $data['class_id'],
				'section_id' 	=> $data['section_id'],
				'term' 			=> $data['term'],
				'working_days' 	=> $data['working_days'],
				'created_by' => $data['created_by']
		);
		$update = 0;
		$this->db->trans_begin();
			$this->db->select('*');
			$result = $this->db->get_where('attendance_master',array(
					'class_id'=>$data['class_id'],
					'school_id'=>$data['school_id'],
					'section_id'=>$data['section_id'],
					'term'=>$data['term'],
					'medium' => $data['medium'],
					'session_id'=>$data['session_id']))->result_array();
			if(count($result)>0){
				$this->db->where('a_id',$result[0]['a_id']);
				$update = 1;
				$this->db->delete('attendance_master');
			}
			
			$this->db->insert('attendance_master',$master);
			$x = $this->db->insert_id();
			
			$final_entry = array();
			foreach($data['s_record'] as $record){
				$temp = array();
				$temp['a_master_id'] = $x;
				$temp['student_id'] = $record['s_id'];
				$temp['present'] = $record['val'];
				$temp['created_at'] = $data['created_at'];
				$temp['created_by'] = $data['created_by'];
				$temp['created_ip'] = $data['ip'];
				array_push($final_entry, $temp);
			}
			$this->db->insert_batch('student_atttendance',$final_entry);
			if($update){
				if($data['term'] == 'Mid'){
					$data['term'] = 'mid';
				}
				$log_info = array(
						'eventid' => 20, //event id
						'event_by' => $this->session->userdata('user_id'),
						'school_id' => $this->session->userdata('school_id'),
						'session_id' => $this->Admin_model->current_session(),
						'class_id' => $data['class_id'],
						'section_id' => $data['section_id'],
						'term' => $data['term'],
						'medium' => $data['medium'],
						'ip'=> $this->input->ip_address(),
						'logtime'=>date('Y-m-d H:i:s')
				);
			}
			else{
				if($data['term'] == 'Mid'){
					$data['term'] = 'mid';
				}
				$log_info = array(
						'eventid' => 7, //event id
						'event_by' => $this->session->userdata('user_id'),
						'school_id' => $this->session->userdata('school_id'),
						'session_id' => $this->Admin_model->current_session(),
						'class_id' => $data['class_id'],
						'section_id' => $data['section_id'],
						'term' => $data['term'],
						'medium' => $data['medium'],
						'ip'=> $this->input->ip_address(),
						'logtime'=>date('Y-m-d H:i:s')
				);
			}
			$this->db->insert('log_tab',$log_info);
			//print_r($this->db->last_query()); die;
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	function attendance_check($data){
		$this->db->select('*');
		$result = $this->db->get_where('attendance_master',array('session_id'=>$data['session_id'],'medium'=>$data['medium'],'class_id'=>$data['class_id'],'section_id'=>$data['section_id'],'status'=>1))->result_array();
		return $result;
	}
}