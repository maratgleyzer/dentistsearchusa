<?php
class Dashboard extends Controller{

	function Dashboard(){
		parent::Controller();
		$this->load->model('Personal_Info_Model');
		$this->load->model('Company_Info_Model');
		$this->load->model('Dashboard_Info_Model');
		$this->load->model('Accounts_Model');
		$this->load->model('Files_Model');
		$this->load->model('Images_Model');
		$this->load->model('Certifications_Model');
		$this->load->model('Appointment_model');
		$this->load->model('Event_scheduler_model');
		$this->load->model('Reviews_Model');
		$this->load->model('Statistics_Model');
		$this->load->model('Specialty_Model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Advertisements_Model');
		$this->load->model('Promotionals_Model');
	
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('string');
		$this->load->helper('security');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->helper('my_image');
		
		$this->load->library('form_validation');
		$this->load->library('googlemaps');
		
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('logged_in')){
				redirect('/');
			}
		}
	}
	function index(){
		$this->personal_information();
	}
	function personal_information(){
		
		$logged_in = $this->session->userdata('logged_in');
		$logged_id = $this->session->userdata('logged_id');
		$data = $this->Personal_Info_Model->get_data($logged_id);
		$data['video_page'] = TRUE;
		$data['reviews'] = $this->Reviews_Model->get_all_reviews('id',$logged_id);
		$data['specialties'] =  $this->Specialty_Model->specialties();
		$data['user_specialties'] =  $this->Specialty_Model->user_specialties($logged_id);
		$data['page_views'] =  $this->Statistics_Model->get_page_view($logged_id);
		$data['rating'] =  $this->Reviews_Model->get_user_rating($logged_id);
		$data['reviews_count'] =  $this->Reviews_Model->count_reviews($logged_id);
		$data['dashboard_info'] = $this->Dashboard_Info_Model->get_dashboard_info($logged_id);
		$data['logged_key'] = $logged_id;
		$data['logged_in'] = $logged_in;
		$data['video_page'] = TRUE;
		$header['includes_section'] = $this->load->view('common/header/header_includes_view',$data,TRUE);
		$header['menu_section'] = $this->load->view('common/header/header_menu_view',$data,TRUE);
		
		$events = $this->Event_scheduler_model->get_events($logged_id);
		$apps = $this->Appointment_model->get_apps($logged_id);
		$count_unread = $this->Appointment_model->count_unread($logged_id);
		$testi_unread = $this->Reviews_Model->count_unread($logged_id);
		
		$data['total_apps'] = count($count_unread) + count($testi_unread);
		$data['unread_testi'] = count($testi_unread);
		$data['unread_app'] = count($count_unread);
		
		$header['search_section'] = $this->load->view('common/header/searchbar/header_dashboard_search_view',$data,TRUE);
		$header['seo'] = array(
			'title' => 'DSUSA ',
			'keywords' => '',
			'description' => 'Dentist Dashboard'
		);
		$this->load->view('common/header_view',$header);

		$data['payment_plans'] = '';
		$data['promotionals'] = $this->Promotionals_Model->get_promos($logged_id);
		$data['promotional_tab'] = $this->load->view('dashboard/promotional_view',$data,TRUE);
		$data['personal_informations_tab'] = $this->load->view('dashboard/personal_informations_view',$data,TRUE);
		$data['images'] = $this->Images_Model->get_images($logged_id);
		$data['gallery_tab'] = $this->load->view('dashboard/gallery_view',$data,TRUE);
		$data['specialty_tab'] = $this->load->view('dashboard/specialty_view',$data,TRUE);
		$data['documents'] = $this->Files_Model->get_documents($logged_id);
		$data['groups'] = $this->Files_Model->get_groups($logged_id);
		$data['documents_tab'] = $this->load->view('dashboard/documents_view',$data,TRUE);
		$data['certifications'] = $this->Certifications_Model->get_certifications($logged_id);
		$data['certifications_tab'] = $this->load->view('dashboard/certifications_view',$data,TRUE);
		$data['events'] = $events;
		$data['appointments'] = $apps;
		$data['dashboard_tab'] = $this->load->view('dashboard/dashboard_tab_view',$data,TRUE);
		$data['inbox_tab'] = $this->load->view('dashboard/inbox_view',$data,TRUE);
		$data['help_content'] = $this->Seo_Model->get(5);
		$data['help_tab'] = $this->load->view('dashboard/help_view',$data,TRUE);
		
		$data['footer_ads'] = $this->Advertisements_Model->get_footer_ads(); $allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['analytics_id'] = $this->Seo_Model->get_analytics_id();
		
		$this->load->view('dashboard/dashboard_view',$data);
		$this->load->view('popup/contact_us_view');
		$data['footer_tags'] = $this->Seo_Model->get_footer_tags();
		$data['has_cities'] = FALSE;
		$this->load->view('common/footer_view',$data);
	}
	function save_personal_info(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'company_name',
						'label'   => 'Company / Clinic Name',
						'rules'   => 'required'
					),
					array(
						'field'   => 'address',
						'label'   => 'Address',
						'rules'   => 'required'
					),
					array(
						'field'   => 'city',
						'label'   => 'City',
						'rules'   => 'required'
					),
					array(
						'field'   => 'state',
						'label'   => 'State',
						'rules'   => 'required'
					),
					array(
						'field'   => 'zip',
						'label'   => 'Zip',
						'rules'   => 'required'
					),
					array(
						'field'   => 'telephone',
						'label'   => 'Telephone Number',
						'rules'   => 'required'
					),
					array(
						'field'   => 'company_email',
						'label'   => 'Company Email',
						'rules'   => 'required|valid_email'
					),
					array(
						'field'   => 'first_name',
						'label'   => 'First Name',
						'rules'   => 'required'
					),
					array(
						'field'   => 'last_name',
						'label'   => 'Last Name',
						'rules'   => 'required'
					)
				);
				if($this->input->post('is_admin')){
					if($this->input->post('change_pass')){
						$config[] = array(
							'field'   => 'new_password',
							'label'   => 'New Password',
							'rules'   => 'required|alpha_numeric'
						);
					}
				}else{
					if($this->input->post('change_pass')){
						$config[] = array(
							'field'   => 'old_password',
							'label'   => 'Old Password',
							'rules'   => 'required|callback_check_old_password'
						);
						$config[] = array(
							'field'   => 'new_password',
							'label'   => 'New Password',
							'rules'   => 'required|alpha_numeric'
						);
						$config[] = array(
							'field'   => 'confirm_password',
							'label'   => 'Confirm Password',
							'rules'   => 'required|matches[new_password]'
						);
					}
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$dentist = $this->Personal_Info_Model->get_data($logged_id);
					if ((($dentist['latitude'] == '0') && ($dentist['longitude'] == '0')) ||
						(($dentist['address'] != $this->input->post('address')) ||
						 ($dentist['city'] != $this->input->post('city')) ||
						 ($dentist['state'] != $this->input->post('state')) ||
						 ($dentist['zip'] != $this->input->post('zip')))) {
						$lat_lon = $this->googlemaps->get_lat_long_from_address("{$this->input->post('address')}, {$this->input->post('city')}, {$this->input->post('state')} {$this->input->post('zip')}, USA");
						$dentist['latitude'] = $lat_lon[0]; $dentist['longitude'] = $lat_lon[1];
					}
					if($this->input->post('change_pass')){
						$this->Accounts_Model->change_password($logged_id);
					}
					if($this->input->post('payment_plan')){
						$this->Accounts_Model->change_payment_plan($logged_id);
					}
					if($this->input->post('is_admin')){
						$this->Accounts_Model->change_status($logged_id);
					}
					$_POST['latitude'] = $dentist['latitude'];
					$_POST['longitude'] = $dentist['longitude'];
					$this->Personal_Info_Model->save_data($logged_id);
					if ($this->Company_Info_Model->save_data($logged_id)) $res = array('success' => TRUE,'message' => '<div class="form_success">Changes succesfully saved.</div>');
					else $res = array('success' => FALSE,'message' => '<div class="form_error">Your edits have been saved, but the system was not able to geocode your address for mapping coordinates. Please verify and possibly simplify your address information so the correct latitude and longitude can be determined.</div>');
				}else{
					$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
				}
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
	function save_specialties(){
		$this->Specialty_Model->save_user_specialties();
		$res = array(
			'success' => TRUE,
			'message' => '<div class="form_success">Changes succesfully saved.</div>'
		);
		print json_encode($res);
	}
	function save_dashboard_info(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'content',
						'label'   => 'Content',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Dashboard_Info_Model->save_dashboard_info($logged_id);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Changes succesfully saved.</div>'
					);
				}else{
					$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
				}
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
	function upload_image(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->input->post('up_key');
			if($logged_id){
				$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/user_assets/images/';
				$config['allowed_types'] = 'png|jpeg|jpg';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('Filedata')){
					$res = array('success' => false,'message' => $this->upload->display_errors());
				}else{
					$file_data = $this->upload->data();
					$file_id = $this->Images_Model->save_image($file_data,$logged_id);
					$file_data['file_id'] = $file_id;
					$res = array('success' => TRUE, 'file' => $file_data);
				}
				print json_encode($res);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<p>Your session has ended. Please click <a href="#" style="color:red;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.<p>'
				);
				print json_encode($res);
			}
		}
	}
	function delete_image($id){
		$file = $this->Images_Model->get_image_details($id);
		$this->Images_Model->delete($id);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_assets/images/'.$file['path']);
	}
	function upload_certification(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->input->post('up_key');
			if($logged_id){
				$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/user_assets/certifications/';
				$config['allowed_types'] = 'png|jpeg|jpg';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('Filedata')){
					$res = array('success' => false,'message' => $this->upload->display_errors());
				}else{
					$file_data = $this->upload->data();
					$file_id = $this->Certifications_Model->save_certification($file_data,$logged_id);
					$file_data['file_id'] = $file_id;
					$res = array('success' => TRUE, 'file' => $file_data);
				}
				print json_encode($res);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<p>Your session has ended. Please click <a href="#" style="color:red;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.<p>'
				);
				print json_encode($res);
			}
		}
	}
	function delete_certification($id){
		$file = $this->Certifications_Model->get_certification_details($id);
		$this->Certifications_Model->delete($id);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_assets/certifications/'.$file['path']);
	}
	function upload_document_file(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){	
			$logged_id = $this->input->post('up_key');
			if($logged_id){
				$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
				$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/user_assets/files/';
				$config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
				$config['max_size']	= '5000';
				$config['encrypt_name']	= TRUE;
				$this->load->library('upload', $config);
				$group_name = $this->input->post('group_name');
				if(!$group_name){
					$res = array('success' => false,'message' => 'Invalid group name');
					print json_encode($res);
					return;
				}
				if(!$this->upload->do_upload('Filedata')){
					$res = array('success' => false,'message' => $this->upload->display_errors());
				}else{
					$file_data = $this->upload->data();
					$file_data['group'] = $group_name;
					$file_id = $this->Files_Model->save_document_files($file_data,$group_name,$logged_id);
					$file_data['file_id'] = $file_id;
					$res = array('success' => TRUE, 'file' => $file_data);
				}
				print json_encode($res);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<p>Your session has ended. Please click <a href="#" style="color:red;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.<p>'
				);
				print json_encode($res);
			}
		}
	}
	function delete_document_file($id){
		$file = $this->Files_Model->get_file_details($id);
		$this->Files_Model->delete($id);
		unlink($_SERVER['DOCUMENT_ROOT'].'/user_assets/files/'.$file['path']);
	}
	function download_document_file($id){
		$file = $this->Files_Model->get_file_details($id);
		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/user_assets/files/'.$file['path']);
		$name = $file['filename'];
		force_download($name, $data); 
	}
	function delete_app($id){
		$this->Appointment_model->delete_app($id);
	}
	function delete_testi($id){
		$this->Reviews_Model->delete_testi($id);
	}
	function is_read($id){
		$this->Appointment_model->is_read($id);
	}
	function is_read_testi($id){
		$this->Reviews_Model->is_read($id);
	}
	function upload_picvid(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->input->post('up_key');
			if($logged_id){
				$root = $_SERVER['DOCUMENT_ROOT'];
				$this->Images_Model->create_account($logged_id);
				$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
				$filename = explode('.', $_FILES['Filedata']['name']);
				$extension = $filename[count($filename)-1];
				$dir = ($logged_id < 100 ? 'zero' : round($logged_id, -2));
				$config['upload_path'] = $root.'/user_assets/prof_images/'.$dir.'/'.$logged_id.'/';
				$config['file_name'] = ($extension == 'flv' ? 'flash.' : 'photo.').$extension;
				$config['allowed_types'] = 'png|jpeg|jpg|flv';
				$config['overwrite'] = TRUE;
				$config['max_size']	= '50000';
				$this->load->library('upload', $config);
				$res = array('success' => false,'message' => 'there was an error');
				if(!$this->upload->do_upload('Filedata')){
					$res = array('success' => false,'message' => $this->upload->display_errors());
				}else{
					$file_data = $this->upload->data();
					$file_id = $this->Personal_Info_Model->save_picvid(array('file_name' => $config['file_name']), $logged_id);
					if ($extension != 'flv') {
						fopen(base_url().'assets/phpthumb/save_thumb.php?src='.base_url().'user_assets/prof_images/'.$dir.'/'.$logged_id.'/photo.'.$extension.'&width=85&height=85&path='.$root.'/user_assets/prof_images/'.$dir.'/'.$logged_id.'/thumb.jpg', 'r');
						fopen(base_url().'assets/phpthumb/save_thumb.php?src='.base_url().'user_assets/prof_images/'.$dir.'/'.$logged_id.'/photo.'.$extension.'&width=540&height=540&path='.$root.'/user_assets/prof_images/'.$dir.'/'.$logged_id.'/photo.jpg', 'r');
					}
					$file_data['file_id'] = $file_id;
					$res = array('success' => TRUE,'file' => $file_data);
				}
				print json_encode($res);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<p>Your session has ended. Please click <a href="#" style="color:red;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.<p>'
				);
				print json_encode($res);
			}
		}
	}
	function upload_promo_file(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/user_assets/files/';
			$config['allowed_types'] = 'doc|docx|xls|xlsx|ppt|pptx|pdf';
			$config['max_size']	= '5000';
			$config['encrypt_name']	= TRUE;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('Filedata')){
				$res = array('success' => false,'message' => $this->upload->display_errors());
			}else{
				$file_data = $this->upload->data();
				$res = array('success' => TRUE, 'file' => $file_data);
			}
			print json_encode($res);
		}
	}
	function save_promo(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'promo_name',
						'label'   => 'Promo Name',
						'rules'   => 'required'
					),
					array(
						'field'   => 'content',
						'label'   => 'Content',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$saved_id = $this->Promotionals_Model->save_promo($logged_id);
					
					$type = explode('.',$this->input->post('file_path'));
					$type = '.'.end($type);
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Promo succesfully saved.</div>',
						'promo_id' => $saved_id,
						'promo_name' => $this->input->post('promo_name'),
						'promo_code' => $this->input->post('code'),
						'file' => $this->input->post('file'),
						'file_path' => $this->input->post('file_path'),
						'file_type' => $type,
						'short_desc' => character_limiter(strip_tags($this->input->post('content')),25),
						'full_desc' => $this->input->post('content')
					);
				}else{
					$res = array('success' => FALSE,'message' => validation_errors('<div class="form_error"> - ','</div>'));
				}
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
	function delete_promo($id){
		$this->Promotionals_Model->delete_promo($id);
	}
	function download_promo_file($id){
		$file = $this->Promotionals_Model->get_file_details($id);
		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/user_assets/files/'.$file['file_path']);
		$name = $file['file'];
		force_download($name, $data); 
	}
	function check_old_password($str){
		$logged_id = $this->session->userdata('logged_id');
		if(!$this->Accounts_Model->check_old_password($str,$logged_id)){
			$this->form_validation->set_message('check_old_password', "Incorrect Old Password");
			return FALSE;
		}
	}
}
/* End of file */