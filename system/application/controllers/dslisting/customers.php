<?php

class Customers extends Controller {

	function Customers(){
		parent::Controller();
		if(!$this->session->userdata('cmsuser_logged_in')){
			header('location: '.base_url().'dslisting/login');
		}
		$this->load->model('CMS_Model');
		
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
		$this->load->model('Statistics_Model');
		$this->load->model('Promotionals_Model');
		$this->load->model('Pre_Registrations_Model');
		$this->load->model('Email_Model');
		
		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->helper('security');
		$this->load->helper('text');
		$this->load->helper('string');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/home_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function add_customer(){
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('admin/dentists/add_dentist_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function edit_customer($id){
	//	$logged_in = $this->session->userdata('logged_in');
	//	$logged_id = $this->session->userdata('logged_id');
		$dummy_login = array(
			'logged_id' => $id,
			'logged_in' => 1
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
		
		$events = $this->Event_scheduler_model->get_events($logged_id);
		
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
			
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('admin/dentists/edit_dentist_view',$data);
		$this->load->view('dslisting/common/footer_view');	
	}
	function manage_customers($sort='date',$message=null){
		$alldents = $this->Company_Info_Model->get_dentists($sort);
		$data['sort'] = $sort;
		$data['alldents'] = $alldents;
		$data['table'] = $this->createManageTable($sort,$alldents);
		$data['message'] = $message;
		
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/customers/manage_customers_view',$data);
		$this->load->view('dslisting/common/footer_view');		
	}
	function createManageTable($sort,$alldents){
		$table = '<tr class="header">
			<td>Avatar</td>
			<td>Name</td>
			<td>Phone</td>
			<td>Address</td>
			<td>Insurance Accepted</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$alldents){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			$hour_scheds = NULL;
			foreach($alldents as $dent){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$prof_pic = $dent['prof_pic'];
				if($prof_pic){
					$picvid = explode(".",$prof_pic);
					if($picvid[1]=="flv"){
						$avatar = '<a href="'.base_url().'user_assets/prof_images/'.$dent['prof_pic'].'" rel="shadowbox;width=600;height=450"><img style="border:1px solid #A6A6A6;" src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/playvid_small.gif&width=50&height=50" /></a>';
					}else{
						$avatar = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/'.$prof_pic.'&width=50&height=50" alt="image" />';
					}
				}else{
					$avatar = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'assets/themes/default/images/no_photo_small.png&width=50&height=50" alt="image" />';
				}
				$table .= '<tr '.$rowbg.'>
					<td width="5%">'.$avatar.'</td>
					<td width="14%"><label style="color:#078579;">'.$dent['last_name'].', '.$dent['first_name'].' '.$dent['post_nominal'].'</label> <br> '.ret_alt_echo($dent['company_name'],'','(',')').'</td>
					<td width="10%" style="font-size:10px;">'.ret_alt_echo($dent['telephone'],'NA','<label style="color:#05887b;font-size:11px;">','</label>').'</td>
					<td width="20%" style="font-size:11px;">'.$dent['address'].'<br/> '.ret_alt_echo($dent['city'],'','',', ').$dent['state'].' '.$dent['zip'].'</td>
					<td width="25%">'.@$dent['insurance'].'</td>
					<td width="10%">
						<a title="View Schedule" href="#hours_info_'.$dent['user_id'].'" class="hours_scheds">
							<img src="'.base_url().'assets/images/admin/hourglass.png"/>
						</a>
						<a title="View Profile" target="_blank" href="'.base_url().'dentist/profile/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/user.png"/>
						</a>
						<a title="Edit" href="'.base_url().'dslisting/customers/edit_customer/'.$dent['user_id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						<a title="Delete" onClick="confirmDelete(this,'.$dent['user_id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
				
				$dent_userid = $dent['user_id'];
				$mon = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'monday');
				$tue = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'tuesday');
				$wed = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'wednesday');
				$thu = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'thursday');
				$fri = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'friday');
				$sat = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'saturday');
				$sun = $this->Event_scheduler_model->get_scheds_by_day($dent_userid,'sunday');
				$hour_scheds .= '
					<div id="hours_info_'.$dent['user_id'].'">
						<div><label style="color:#078579; font-weight:bold;">'.$dent['last_name'].', '.$dent['first_name'].' '.$dent['post_nominal'].' Daily Schedule</label> </div><br/>
						<table cellspacing="0" cellpadding="0" class="table_scheds" style="color:gray;">
							<tr>
								<td width="75" class="no_bg"></td>
								<td width="66" class="no_bg table_header">Login</td>
								<td width="66" class="no_bg table_header">Break-Out</td>
								<td width="66" class="no_bg table_header">Break-In</td>
								<td width="66" class="no_bg table_header">Logout</td>
							</tr>
							<tr>
								<td class="no_bg">Monday</td>
								<td id="mon_login" >'.@ret_alt_echo($mon['login'],'- - - - - -').'</td>
								<td id="mon_brkout">'.@ret_alt_echo($mon['break_out'],'- - - - - -').'</td>
								<td id="mon_brkin">'.@ret_alt_echo($mon['break_in'],'- - - - - -').'</td>
								<td id="mon_logout">'.@ret_alt_echo($mon['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Tuesday</td>
								<td id="tue_login" class="alt_bg">'.@ret_alt_echo($tue['login'],'- - - - - -').'</td>
								<td id="tue_brkout" class="alt_bg">'.@ret_alt_echo($tue['break_out'],'- - - - - -').'</td>
								<td id="tue_brkin" class="alt_bg">'.@ret_alt_echo($tue['break_in'],'- - - - - -').'</td>
								<td id="tue_logout" class="alt_bg">'.@ret_alt_echo($tue['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Wednesday</td>
								<td id="wed_login">'.@ret_alt_echo($wed['login'],'- - - - - -').'</td>
								<td id="wed_brkout">'.@ret_alt_echo($wed['break_out'],'- - - - - -').'</td>
								<td id="wed_brkin">'.@ret_alt_echo($wed['break_in'],'- - - - - -').'</td>
								<td id="wed_logout">'.@ret_alt_echo($wed['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Thursday</td>
								<td id="thu_login" class="alt_bg">'.@ret_alt_echo($thu['login'],'- - - - - -').'</td>
								<td id="thu_brkout" class="alt_bg">'.@ret_alt_echo($thu['break_out'],'- - - - - -').'</td>
								<td id="thu_brkin" class="alt_bg">'.@ret_alt_echo($thu['break_in'],'- - - - - -').'</td>
								<td id="thu_logout" class="alt_bg">'.@ret_alt_echo($thu['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Friday</td>
								<td id="fri_login">'.@ret_alt_echo($fri['login'],'- - - - - -').'</td>
								<td id="fri_brkout">'.@ret_alt_echo($fri['break_out'],'- - - - - -').'</td>
								<td id="fri_brkin">'.@ret_alt_echo($fri['break_in'],'- - - - - -').'</td>
								<td id="fri_logout">'.@ret_alt_echo($fri['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Saturday</td>
								<td id="sat_login" class="alt_bg">'.@ret_alt_echo($sat['login'],'- - - - - -').'</td>
								<td id="sat_brkout" class="alt_bg">'.@ret_alt_echo($sat['break_out'],'- - - - - -').'</td>
								<td id="sat_brkin" class="alt_bg">'.@ret_alt_echo($sat['break_in'],'- - - - - -').'</td>
								<td id="sat_logout" class="alt_bg">'.@ret_alt_echo($sat['logout'],'- - - - - -').'</td>
							</tr>
							<tr>
								<td class="no_bg">Sunday</td>
								<td id="sun_login">'.@ret_alt_echo($sun['login'],'- - - - - -').'</td>
								<td id="sun_brkout">'.@ret_alt_echo($sun['break_out'],'- - - - - -').'</td>
								<td id="sun_brkin">'.@ret_alt_echo($sun['break_in'],'- - - - - -').'</td>
								<td id="sun_logout">'.@ret_alt_echo($sun['logout'],'- - - - - -').'</td>
							</tr>
						</table>
					</div>
				';
			}
			$hour_scheds = '
				<div style="display:none;">
					'.$hour_scheds.'
				</div>
			';
		}
		$tables['table'] = $table;
		$tables['scheds'] = $hour_scheds;
		
		return $tables;
	}
}