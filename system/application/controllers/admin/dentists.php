<?php

class Dentists extends Controller {

	function Dentists(){
		parent::Controller();
		if(!$this->session->userdata('admin_logged_in')){
			header('location: '.base_url().'_admin_console/login');
		}
		$this->load->model('Accounts_Model');
		$this->load->model('Specialty_Model');
		$this->load->model('Appointment_model');
		$this->load->model('Certifications_Model');
		$this->load->model('Company_Info_Model');		
		$this->load->model('Dashboard_Info_Model');
		$this->load->model('Event_scheduler_model');
		$this->load->model('Files_Model');
		$this->load->model('Images_Model');
		$this->load->model('Personal_Info_Model');
		$this->load->model('Reviews_Model');
		$this->load->model('Events_model');
		$this->load->model('Payments_Model');
		$this->load->model('Statistics_Model');
		$this->load->model('Promotionals_Model');
		$this->load->model('Pre_Registrations_Model');
		$this->load->model('Email_Model');
		$this->load->model('Seo_Model');
		
		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->helper('security');
		$this->load->helper('text');
		$this->load->helper('string');
		
		$this->load->library('form_validation');
		$this->load->library('pagination');
	}
	function index(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');
	}
	function add_dentist(){
		$data['payment_plans'] = $this->Payments_Model->get_payment_options();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/dentists/add_dentist_view', $data);
		$this->load->view('admin/common/footer_view');
	}
	function edit_dentist($id){
	//	$logged_in = $this->session->userdata('logged_in');
	//	$logged_id = $this->session->userdata('logged_id');
		$dummy_login = array(
			'logged_id' => $id,
			'logged_in' => TRUE
		);
		$this->session->set_userdata($dummy_login);
		$logged_id = $id;
		$logged_in = 1;
		
		$data = $this->Personal_Info_Model->get_data($logged_id);
		$data['is_admin'] = TRUE; 
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

		$apps = $this->Appointment_model->get_apps($logged_id);
		$count_unread = $this->Appointment_model->count_unread($logged_id);
		$testi_unread = $this->Reviews_Model->count_unread($logged_id);

		$data['total_apps'] = count($count_unread) + count($testi_unread);
		$data['unread_testi'] = count($testi_unread);
		$data['unread_app'] = count($count_unread);
		
		$events = $this->Event_scheduler_model->get_events($logged_id);
		
		$data['payment_plans'] = $this->Payments_Model->get_payment_options();
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
		$data['dashboard_tab'] = $this->load->view('dashboard/dashboard_tab_view',$data,TRUE);
			
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/dentists/edit_dentist_view',$data);
		$this->load->view('admin/common/footer_view');	
	}
	function save_dentist(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'email',
						'label'   => 'Email (Username)',
						'rules'   => 'required|valid_email|callback_check_unique_email'
					),
					array(
						'field'   => 'password',
						'label'   => 'Password',
						'rules'   => 'required|alpha_numeric'
					),array(
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
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$user_id = $this->Accounts_Model->create_account();
					$this->Personal_Info_Model->create_account($user_id);
					$this->Company_Info_Model->create_account($user_id);
					$this->Dashboard_Info_Model->create_account($user_id);
					$this->Statistics_Model->create_account($user_id);
					$this->Images_Model->create_account($user_id);

					$this->Personal_Info_Model->save_data($user_id);
					$this->Company_Info_Model->save_data($user_id);
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Dentist succesfully saved.</div>'
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
	function manage_dentists($page=0){
		$pagelimit = 20;
		$search = array();
		$sort = $this->input->post('sort');
		$city_zip = ltrim(rtrim($this->input->post('city_zip')));
		$first_last = ltrim(rtrim($this->input->post('first_last')));
		if (!$sort)
			$sort = 'date';		
		if ($city_zip) {
			if (is_numeric($city_zip)) {
				$search['zip'] = $city_zip;
			} elseif (preg_match('/^([A-Z \s\.\'\`\-]+), ([A-Z]{2})$/i', $city_zip, $match)) {
				$search['city'] = $match[1]; $search['state'] = $match[2];
			} elseif (preg_match('/^([A-Z]{2})$/i', $city_zip, $match)) {
				$search['state'] = $match[1];
			} else { $search['city'] = $city_zip; }
		}
		if ($first_last) {
			if (preg_match('/^([A-Z\'\`\-]+) ([A-Z\'\`\-]+)$/i', $first_last, $match)) {
				$search['first'] = $match[1]; $search['last'] = $match[2];
			} elseif (preg_match('/^([A-Z\'\`\-]+)$/i', $first_last, $match)) {
				$search['name'] = $match[1];
			} else { $search['name'] = $first_last; }
		}
		$ret = $this->Company_Info_Model->get_dentists($sort,$page,$pagelimit,$search);
		$alldents = $ret['result'];
		
		$config['base_url'] = base_url().'_admin_console/dentists/manage_dentists/';
		$config['total_rows'] = $ret['count'];
		$config['per_page'] = $pagelimit; 
		$config['num_links'] = 10;
		$config['uri_segment'] = 4;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config); 
		$data['paging'] = $this->pagination->create_links();

		$data['sort'] = $sort;
		$data['city_zip'] = $city_zip;
		$data['first_last'] = $first_last;
		$data['alldents'] = $alldents;
		$data['table'] = $this->createManageTable($sort,$alldents);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_dentists_view',$data);
		$this->load->view('admin/common/footer_view');
		
		
	}
	function manage_reviews($sort='date',$id=NULL){
		$alldents = $this->Reviews_Model->get_all_reviews($sort,$id);
		$data['sort'] = $sort;
		$data['id'] = $id;
		$data['alldents'] = $alldents;
		$data['table'] = $this->createManageTableReviews($sort,$alldents);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/dentists/manage_reviews_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_files($id=NULL){
		$allfiles = $this->Files_Model->get_all_files($id);
		$data['allfiles'] = $allfiles;
		$data['table'] = $this->createManageTableFiles($allfiles);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_files_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_images($id=NULL){
		$allimages = $this->Images_Model->get_all_images($id);
		$data['allimages'] = $allimages;
		$data['table'] = $this->createManageTableImages($allimages,'images');
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_images_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_certificates($id=NULL){
		$allimages = $this->Certifications_Model->get_all_images($id);
		$data['allimages'] = $allimages;
		$data['table'] = $this->createManageTableImages($allimages,'certifications');
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_certificates_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_promotionals($sort='id',$id=NULL){
		$allpromo = $this->Promotionals_Model->get_dentist_promos($sort,$id);
		$data['allpromo'] = $allpromo;
		$data['sort'] = $sort;
		$data['id'] = $id;
		$data['table'] = $this->createManageTablePromotionals($allpromo);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_promotionals_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_pre_registered($sort='id'){
		$alluser = $this->Pre_Registrations_Model->get_users($sort);
		$data['alluser'] = $alluser;
		$data['sort'] = $sort;
		$data['table'] = $this->createManageTablePreRegistrations($alluser);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_pre_registrations_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function delete($user_id){
		$this->Seo_Model->purge_php_cache();
		$this->Accounts_Model->delete_by_users($user_id);
		$this->Appointment_model->delete_by_users($user_id);
		$this->Certifications_Model->delete_by_users($user_id);
		$this->Company_Info_Model->delete_by_users($user_id);	
		$this->Dashboard_Info_Model->delete_by_users($user_id);
		$this->Event_scheduler_model->delete_by_users($user_id);
		$this->Files_Model->delete_by_users($user_id);
		$this->Images_Model->delete_by_users($user_id);
		$this->Personal_Info_Model->delete_by_users($user_id);
		$this->Reviews_Model->delete_by_users($user_id);
		$this->Events_model->delete_by_users($user_id);
		$this->Statistics_Model->delete_by_users($user_id);
		print TRUE;
	}
	function delete_specialty($id){
		$this->Seo_Model->purge_php_cache();
		$this->Specialty_Model->delete_specialty($id);
	}
	function add_specialty(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/dentists/add_specialty_view');
		$this->load->view('admin/common/footer_view');
	}
	function edit_specialty($id){
		$data['specialty'] = $this->Specialty_Model->get_specialty($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/dentists/edit_specialty_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_specialty($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'specialty_title',
						'label'   => 'Specialty Title',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Specialty_Model->save_specialty($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Dentist specialty succesfully saved.</div>'
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
	function manage_specialties(){
		$specialties = $this->Specialty_Model->specialties_and_count();
		$data['specialties'] =  $specialties;
		$data['table'] = $this->createManageTableSpecialties($specialties);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/dentists/manage_specialties_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTable($sort,$alldents){
		$table = '<tr class="header">
			<td>Avatar</td>
			<td>Name</td>
			<td>Address</td>
			<td>Contact Info</td>
			<td>Payment Plan</td>
			<td>Rating</td>
			<td>Views</td>
			<td>Actions</td>
			<td>F</td>
			<td>S</td>
		</tr>';
		$i = 0;
		if(!$alldents){
			$table .= '<tr><td colspan="9" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($alldents as $dent){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$prof_pic = $dent['prof_pic'];
				if($prof_pic){
					$dir = ($dent['user_id'] < 100 ? 'zero' : round($dent['user_id'], -2));
					$picvid = explode(".",$prof_pic);
					if($picvid[count($picvid)-1]=="flv"){
						$avatar = '<a href="'.base_url().'user_assets/prof_images/'.$dir.'/'.$dent['user_id'].'/flash.flv" rel="shadowbox;width=600;height=450"><img style="border:1px solid #A6A6A6;" src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/playvid_small.gif&width=50&height=50" /></a>';
					}else{
						$avatar = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/'.$dir.'/'.$dent['user_id'].'/thumb.jpg&width=50&height=50" alt="image" />';
					}
				}else{
					$avatar = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'assets/themes/default/images/no_photo_small.png&width=50&height=50" alt="image" />';
				}
				$action_options = NULL;
				$action_width = '8%';
				if($this->session->userdata('admin_level') == 1){
					$action_width = '25%';
					$action_options = '<a title="Dentist Ratings" href="'.base_url().'_admin_console/dentists/manage_reviews/date/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/star.png"/>
						</a>
						<a title="Dentist Promotionals" href="'.base_url().'_admin_console/dentists/manage_promotionals/id/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/bell.png"/>
						</a>
						<a title="Dentist Files" href="'.base_url().'_admin_console/dentists/manage_files/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_word.png"/>
						</a>
						<a title="Dentist Certificates" href="'.base_url().'_admin_console/dentists/manage_certificates/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_text.png"/>
						</a>
						<a title="Dentist Images" href="'.base_url().'_admin_console/dentists/manage_images/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/pictures.png"/>
						</a>';
				}
				$table .= '<tr '.$rowbg.'>
					<td width="5%">'.$avatar.'</td>
					<td width="14%"><label style="color:#078579;">'.$dent['last_name'].', '.$dent['first_name'].' '.$dent['post_nominal'].'</label> <br> '.ret_alt_echo($dent['company_name'],'','(',')').'</td>
					<td width="14%" style="font-size:11px;">'.$dent['address'].'<br/> '.ret_alt_echo($dent['city'],'','',', ').$dent['state'].' '.$dent['zip'].'</td>
					<td width="10%" style="font-size:10px;">DSUSA: '.ret_alt_echo($dent['dsusa_telephone'],'NA','<label style="color:#05887b;font-size:11px;">','</label>').'<br/> USER: '.ret_alt_echo($dent['telephone'],'NA','<label style="color:#05887b;font-size:11px;">','</label>').'<br><a title="'.$dent['email'].'" style="font-size:11px;" href="mailto:'.$dent['email'].'">'.my_character_limiter($dent['email'],25).'</a></td>
					<td width="14%" style="font-size:10px;">'.$dent['payment_plan'].'</td>
					<td width="10%">'.get_star_rating($dent['the_rating'],true).'</td>
					<td width="5%">'.$dent['page_view'].'</td>
					<td width="'.$action_width.'">
						'.$action_options.'
						<a title="View Profile" target="_blank" href="'.base_url().'dentist/profile/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/user.png"/>
						</a>
						<a title="Edit" href="'.base_url().'_admin_console/dentists/edit_dentist/'.$dent['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						<a title="Delete" onClick="confirmDelete(this,'.$dent['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
					<td width="1%">'.($dent['featured'] > 0 ? '<img src="/assets/images/admin/green_check.gif" alt="Featured" />' : '&nbsp;').'</td>
					<td width="1%">'.($dent['status'] > 0 ? '<img src="/assets/images/admin/green_check.gif" alt="Activated" />' : '<img src="/assets/images/admin/red_x.gif" alt="De-Activated" />').'</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTableReviews($sort,$alldents){
		$table = '<tr class="header">
			<td>Dentist Name</td>
			<td>Message</td>
			<td>Rating</td>
			<td>Reviewer</td>
			<td>Date</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$alldents){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($alldents as $dent){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$table .= '<tr '.$rowbg.'>
					<td width="19%">'.$dent['owner'].'</td>
					<td width="40%" style="font-size:10px;">'.$dent['message'].'</td>
					<td width="8%">'.get_star_rating($dent['rating'],true).'</td>
					<td width="20%" style="font-size:11px;">~'.$dent['name'].' ('.$dent['email'].') <br>'.$dent['website'].'</td>
					<td width="7%">'.$dent['date'].'</td>
					<td width="6%">
						<a target="_blank" href="'.base_url().'dentist/profile/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/user.png"/>
						</a>
						<a onClick="confirmDelete(this,'.$dent['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTableImages($alldents,$path){
		$table = '<tr class="header">
			<td>Preview</td>
			<td>Owner</td>
			<td>Filename</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$alldents){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($alldents as $dent){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$avatar = '<a style="cursor:pointer;" rel="images" class="previewImage" href="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/'.$path.'/'.$dent['path'].'&width=800&height=600"><img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/'.$path.'/'.$dent['path'].'&width=50&height=50" alt="image" /></a>';
				$table .= '<tr '.$rowbg.'>
					<td width="10%">'.$avatar.'</td>
					<td width="20%">'.$dent['owner'].'</td>
					<td width="62%">'.$dent['filename'].'</td>
					<td width="8%" style="text-align:center;">
						<a style="cursor:pointer;" rel="images" class="previewImage" href="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/'.$path.'/'.$dent['path'].'&width=800&height=600">
							<img src="'.base_url().'assets/images/admin/magnifier.png" alt="image" />
						</a>&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$dent['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
						
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTableFiles($allfiles){
		$table = '<tr class="header">
			<td>Type</td>
			<td>Owner</td>
			<td>Filename</td>
			<td>Group</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allfiles){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allfiles as $dent){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$avatar = '<img alt="type" src="'.base_url().'assets/themes/default/images/ico'.$dent['type'].'.gif" />';
				$table .= '<tr '.$rowbg.'>
					<td width="6%">'.$avatar.'</td>
					<td width="20%">'.$dent['owner'].'</td>
					<td width="46%">'.$dent['filename'].'</td>
					<td width="20%">'.$dent['group'].'</td>
					<td width="8%" style="text-align:center;">
						<a href="'.base_url().'dentist/download_document_file/'.$dent['id'].'">
							<img alt="download" class="icons" src="'.base_url().'assets/themes/default/images/page_white_put.png" />
						</a>&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$dent['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTablePromotionals($allpromo){
		$table = '<tr class="header">
			<td>Owner</td>
			<td>Promo Name</td>
			<td>Description</td>
			<td>Promo Code</td>
			<td>File</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allpromo){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allpromo as $promo){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				if($promo['file_path']){
					$type = explode('.',$promo['file_path']);
					$type = '.'.end($type);
					$avatar = '<a href="'.base_url().'dashboard/download_promo_file/'.$promo['id'].'"><img alt="type" src="'.base_url().'assets/themes/default/images/ico'.$type.'.gif" /></a>';
				}else{
					$avatar = 'N/A';
				}
				$table .= '<tr '.$rowbg.'>
					<td width="20%">'.$promo['owner'].'</td>
					<td width="15%">'.$promo['name'].'</td>
					<td width="37%">'.character_limiter(strip_tags($promo['description']),100).'</td>
					<td width="15%">'.$promo['code'].'</td>
					<td width="5%">'.$avatar.'</td>
					<td width="8%" style="text-align:center;">
						<a onClick="confirmDelete(this,'.$promo['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTablePreRegistrations($alluser){
		$table = '<tr class="header">
			<td>Name</td>
			<td>Phone</td>
			<td>Email</td>
			<td>Interested In</td>
			<td>Status</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$alluser){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($alluser as $user){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				if(!$user['status']){
					$status = 'Incomplete';
				}else{
					$status = '<label style="color:#078579;">Completed</label>';
				}
				$table .= '<tr '.$rowbg.'>
					<td width="29%">'.$user['name'].'</td>
					<td width="18%">'.$user['phone'].'</td>
					<td width="20%">'.$user['email'].'</td>
					<td width="15%">'.$user['interested_in_text'].'</td>
					<td width="10%">'.$status.'</td>
					<td width="8%" style="text-align:center;">
						<a title="Resend Pre-Registration Email" href="#" the_name="'.form_prep($user['name']).'" onClick="confirmResendEmail(this,\''.$user['email'].'\');return false;">
							<img src="'.base_url().'assets/images/admin/email_go.png"/>
						</a> &nbsp;&nbsp;
						<a title="Delete" onClick="confirmDelete(this,'.$user['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function resend_pre_registration(){
		$email = $this->Email_Model->get_template(1);
		$subject = $email['subject'];
		$message = str_replace('%recipient_name%',$this->input->post('name'),$email['content']);
		$message = str_replace('%registration_link%',base_url().'registration_details',$message);
		
		$emailconf = array('mailtype' => 'html');
		$this->email->initialize($emailconf);
		$this->email->from('no-reply@dentistsearchusa.com', 'NO REPLY - DSUSA');
		$this->email->to($this->input->post('email')); 
		$this->email->subject($subject);
		$this->email->message($message);	
		$this->email->send();
	}
	function delete_registration($id){
		$this->Seo_Model->purge_php_cache();
		$this->Pre_Registrations_Model->delete_pre_registration($id);
	}
	function delete_promo($id){
		$this->Seo_Model->purge_php_cache();
		$this->Promotionals_Model->delete_promo($id);
	}
	function createManageTableSpecialties($allspecialty){
		$table = '<tr class="header">
			<td>Specialty Title</td>
			<td>Description</td>
			<td>Dentists</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allspecialty){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allspecialty as $specialty){
				if($specialty['dent_count']){
					$delete = '<img src="'.base_url().'assets/images/admin/bin_closed.png"/>';
					$count_color = 'style="color:#057f73; font-weight:bold;"';
				}else{
					$delete = '<a onClick="confirmDelete(this,'.$specialty['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>';
					$count_color = 'style="color:red;"';
				}
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="25%">'.$specialty['specialty_title'].'</td>
					<td width="63%">'.$specialty['description'].'</td>
					<td width="4%" align="center" '.$count_color.'>'.$specialty['dent_count'].'</td>
					<td width="8%">
						<a href="'.base_url().'_admin_console/dentists/edit_specialty/'.$specialty['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;&nbsp;
						'.$delete.'
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function check_unique_email($str){
		if($this->Accounts_Model->check_unique_email($str)){
			$this->form_validation->set_message('check_unique_email', "$str is already used");
			return FALSE;
		}
	}
}