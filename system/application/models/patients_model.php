<?php

class Patients_Model extends Model {
	function patients_model(){
		parent::Model();
		$this->load->database();		
	}
	function save_patient($id,$notes,$file){
		$data = array(
			'caller_name' => $this->input->post('caller_name'),
			'dental_emergency' => $this->input->post('dental_emergency'),
			'phone' => $this->input->post('phone'),
			'pain_level' => $this->input->post('pain_level'),
			'patient_name' => $this->input->post('patient_name'),
			'dentist_assigned_to' => $this->input->post('dentist_assigned_to'),
			'fear_of_dentist' => $this->input->post('fear_of_dentist'),
			'last_appointment_date' => $this->input->post('last_appointment_date'),
			'birth_day' => $this->input->post('birth_day'),
			'address' => $this->input->post('address'),
			'city' => $this->input->post('city'),
			'state' => $this->input->post('state'),
			'zip' => $this->input->post('zip'),
			'email' => $this->input->post('email'),
			'notes' => $notes,
			'office_contact' => $this->input->post('office_contact'),
			'pdf_file' => $this->input->post('pdf_file'),
			'appointment_date' => $this->input->post('appointment_date'),
			'appointment_time' => $this->input->post('appointment_time'),
			'pdf_file' => $file
		);
		if($id){
			$data['author_updated'] = $this->session->userdata('cmsuser_logged_id');
			$data['updated'] = date('Y-m-d H:i:s');
			$this->db->update('cms_patients', $data, array('id' => $id));
			return $id;
		}else{
			$data['author_added'] = $this->session->userdata('cmsuser_logged_id');;
			$data['added'] = date('Y-m-d H:i:s');
			$this->db->insert('cms_patients',$data);
			return $this->db->insert_id();
		}
	}
	function delete_patient($id){
		$this->db->where(array('id' => $id));
		$this->db->delete('cms_patients');
	}
	function get_patients($sort){
		$this->db->cache_off();
		$order = 'ASC';
		if($sort == 'added'){
			$order = 'DESC';
		}
		$res = $this->db->query('
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,c.telephone,p.last_name,p.post_nominal,p.first_name 
			FROM cms_patients AS pa, cms_users AS u, user_personal_info AS p, user_company_info AS c 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = p.user_id AND p.user_id = c.user_id
			UNION
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,\'\',\'\',\'\',\'\' 
			FROM cms_patients AS pa, cms_users AS u 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = 0 ORDER BY '.$sort.' '.$order
		);
		return $res->result_array();
	}
	function get_patient($id){
		$this->db->cache_off();
		$res = $this->db->get_where('cms_patients',array('id' => $id));
		return $res->row_array();
	}
	function get_patients_monthly_by_dentist($dentist){
		$this->db->cache_off();
		$res = $this->db->query('
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,c.telephone,p.last_name,p.post_nominal,p.first_name 
			FROM cms_patients AS pa, cms_users AS u, user_personal_info AS p, user_company_info AS c 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = p.user_id AND p.user_id = c.user_id AND p.user_id = '.$dentist.' AND DATE_FORMAT(added,\'%Y-%m\') = DATE_FORMAT(NOW(),\'%Y-%m\')
		');
		return $res->result_array();
	}
	function get_patients_monthly(){
		$this->db->cache_off();
		$res = $this->db->query('
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,c.telephone,p.last_name,p.post_nominal,p.first_name 
			FROM cms_patients AS pa, cms_users AS u, user_personal_info AS p, user_company_info AS c 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = p.user_id AND p.user_id = c.user_id AND DATE_FORMAT(added,\'%Y-%m\') = DATE_FORMAT(NOW(),\'%Y-%m\')
			UNION
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,\'\',\'\',\'\',\'\' 
			FROM cms_patients AS pa, cms_users AS u 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = 0 AND DATE_FORMAT(added,\'%Y-%m\') = DATE_FORMAT(NOW(),\'%Y-%m\') ORDER BY added DESC'
		);
		return $res->result_array();
	}
	function get_patients_date_range_by_dentist($dentist,$start,$end){
		$this->db->cache_off();
		$res = $this->db->query('
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,c.telephone,p.last_name,p.post_nominal,p.first_name 
			FROM cms_patients AS pa, cms_users AS u, user_personal_info AS p, user_company_info AS c 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = p.user_id AND p.user_id = c.user_id AND p.user_id = '.$dentist.' AND DATE_FORMAT(added,\'%Y-%m-%d\') BETWEEN \''.$start.'\' AND \''.$end.'\' ORDER BY added DESC
		');
		return $res->result_array();
	}
	function get_patients_date_range($start,$end){
		$this->db->cache_off();
		$res = $this->db->query('
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,c.telephone,p.last_name,p.post_nominal,p.first_name 
			FROM cms_patients AS pa, cms_users AS u, user_personal_info AS p, user_company_info AS c 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = p.user_id AND p.user_id = c.user_id AND DATE_FORMAT(added,\'%Y-%m-%d\') BETWEEN \''.$start.'\' AND \''.$end.'\'
			UNION
			SELECT pa.*, pa.id AS pa_id,u.id AS u_id,u.login,u.name,\'\',\'\',\'\',\'\' 
			FROM cms_patients AS pa, cms_users AS u 
			WHERE pa.author_added = u.id AND pa.dentist_assigned_to = 0 AND DATE_FORMAT(added,\'%Y-%m-%d\') BETWEEN \''.$start.'\' AND \''.$end.'\' ORDER BY added DESC'
		);
		return $res->result_array();
	}
}