<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('admin_logged_in')){
				header('location: '.base_url().'_admin_console/login');
			}
		}
		$this->load->model('Contact_Model');
		$this->load->model('Admin_Model');
		$this->load->model('Social_Media_Model');
		$this->load->model('Seo_Model');
		$this->load->model('Choices_Model');
		$this->load->model('Privileges_Model');
		$this->load->model('CMS_Model');
		
		$this->load->library('form_validation');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('file');
		$this->load->helper('text');
	}
	function index()
	{
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');
	}
	function purge_mysql_cache(){
		$this->Seo_Model->purge_mysql_cache();
		$this->index();
	}
	function purge_php_cache(){
		$this->Seo_Model->purge_php_cache();
		$this->index();
	}
	function contact_us_messages($sort='date'){
		$messages = $this->Contact_Model->get_messages($sort);
		$data['sort'] = $sort;
		$data['messages'] =  $messages;
		$data['table'] = $this->createManageTableMessages($messages);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_messages_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function delete_message($id){
		$this->Seo_Model->purge_php_cache();
		$this->Contact_Model->delete_message($id);
		print TRUE;
	}
	function createManageTableMessages($messages){
		$table = '<tr class="header">
			<td>Name</td>
			<td>Email</td>
			<td>Message</td>
			<td>Date</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$messages){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($messages as $message){
				if($message['is_dentist']){
					$user = '(<label style="color:#058478;">Dentist<label>)';
				}else{
					$user = '(<label style="color:gray;">Guest</label>)';
				}
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="15%">'.$message['name'].' '.$user.'</td>
					<td width="15%"><a href="mailto:'.$message['email'].'">'.$message['email'].'</a></td>
					<td width="45%">'.character_limiter(strip_tags($message['message']),150).'</td>
					<td width="17%">'.$message['date'].'</td>
					<td width="8%">
						<a class="message_box actionIcons" title="Read Message" href="#message_'.$message['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_text.png"/>
						</a>
						&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$message['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
				$messages .= '<div class="admin_messages" id="message_'.$message['id'].'">'.$message['message'].'</div>';
			}
			$table .= '<div style="display:none;">'.$messages.'</div>';
		}
		return $table;
	}
	function admin_account(){
		$data = $this->Admin_Model->get_details(1);
		$data['id'] = 1;
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/admin_account_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_admin(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				if(!$this->input->post('change_pass')){
					$config = array(
						array(
							'field'   => 'partner_email',
							'label'   => 'Admin Login',
							'rules'   => 'required'
						)
					);
				}else{
					$config = array(
						array(
							'field'   => 'partner_email',
							'label'   => 'Admin Login',
							'rules'   => 'required'
						),
						array(
							'field'   => 'old_password',
							'label'   => 'Old Password',
							'rules'   => 'required|callback_check_old_password'
						),
						array(
							'field'   => 'password',
							'label'   => 'Password',
							'rules'   => 'required'
						),
						array(
							'field'   => 'ret_password',
							'label'   => 'Confirm Password',
							'rules'   => 'required|matches[password]'
						)
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Admin_Model->save_admin();
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
	function check_old_password($str){
		if(!$this->Admin_Model->check_old_password($str)){
			$this->form_validation->set_message('check_old_password', "Incorrect Old Password");
			return FALSE;
		}
	}
	function add_social_media_icon(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/add_social_media_icon_view');
		$this->load->view('admin/common/footer_view');
	}
	function edit_social_media_icon($id){
		$data = $this->Social_Media_Model->get($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_social_media_icon_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_icon($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'image',
						'label'   => 'Icon',
						'rules'   => 'required'
					),
					array(
						'field'   => 'link',
						'label'   => 'Link',
						'rules'   => 'required'
					),
					array(
						'field'   => 'tooltip',
						'label'   => 'Tooltip',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Social_Media_Model->save($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Icon succesfully saved.</div>'
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
	function upload_icon(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/assets/images/social_media_icons/';
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size']	= '5000';
			$config['max_width'] = '20';
			$config['max_height'] = '20';
			$config['encrypt_name']	= TRUE;
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('Filedata')){
				$res = array('success' => false,'message' => $this->upload->display_errors());
			}else{
				$this->Seo_Model->purge_php_cache();
				$file_data = $this->upload->data();
				$res = array('success' => TRUE, 'file' => $file_data);
			}
			print json_encode($res);
		}
	}
	function manage_social_media_icons($id=NULL){
		$allicons = $this->Social_Media_Model->get_all();
		$data['allicons'] = $allicons;
		$data['table'] = $this->createManageTableIcons($allicons);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_social_media_icons_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTableIcons($allicons){
		$table = '<tr class="header">
			<td>Icon</td>
			<td>Tooltip</td>
			<td>Link</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allicons){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allicons as $icon){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$avatar = '<a target="_blank" href="'.$icon['link'].'"><img width="20" height="20" src="'.base_url().'assets/images/social_media_icons/'.$icon['icon'].'" alt="image" /></a>';
				$table .= '<tr '.$rowbg.'>
					<td width="10%">'.$avatar.'</td>
					<td width="30%">'.$icon['tooltip'].'</td>
					<td width="52%">'.$icon['link'].'</td>
					<td width="8%" style="text-align:center;">
						<a href="'.base_url().'_admin_console/home/edit_social_media_icon/'.$icon['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a> &nbsp; 
						<a onClick="confirmDelete(this,'.$icon['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
						
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function delete_icon($id){
		$this->Seo_Model->purge_php_cache();
		$this->Social_Media_Model->delete_icon($id);
	}
	function page_management(){
		$alltags = $this->Seo_Model->get_all();
		$data['alltags'] = $alltags;
		$data['table'] = $this->createManageTablePage($alltags);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_pages_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTablePage($pages){
		$table = '<tr class="header">
			<td>Page</td>
			<td>Page Title</td>
			<td>Meta Description</td>
			<td>Meta Keywords</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$pages){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($pages as $page){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				if($page['content_only']){
					$pagename = $page['page'];
				}else{
					$pagename = '<a target="_blank" href="'.base_url().$page['page'].'" style="color:#007a6d; font-weight: bold;">'.$page['page'].'</a>';
				}
				if($page['editable_content']){
					$pageprev = '<a class="page_box actionIcons" title="Edit" >
						<img src="'.base_url().'assets/images/admin/page_white_magnify.png"/>
					</a>';
				}else{
					$pageprev = '<a class="page_box actionIcons" title="Edit" >
						<img src="'.base_url().'assets/images/admin/no_page.png"/>
					</a>';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="10%">'.$pagename.'</td>
					<td width="15%">'.$page['title'].'</td>
					<td width="40%">'.character_limiter(strip_tags($page['description']),150).'</td>
					<td width="27%">'.character_limiter(strip_tags($page['keywords']),150).'</td>
					<td width="8%" align="center">
						'.$pageprev.'&nbsp;
						<a class="page_box actionIcons" title="Edit" href="'.base_url().'_admin_console/home/edit_tags/'.$page['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function edit_tags($id){
		$data['tag'] =  $this->Seo_Model->get($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_pages_tag_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_tag($edit){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				if(!$this->input->post('content_only')){
					$config = array(
						array(
							'field'   => 'title',
							'label'   => 'Title',
							'rules'   => 'required'
						),
						array(
							'field'   => 'keywords',
							'label'   => 'Meta Keywords',
							'rules'   => 'required'
						),
						array(
							'field'   => 'description',
							'label'   => 'Meta Description',
							'rules'   => 'required'
						)
					);
					if($this->input->post('editable_content')){
						$config[] = array(
							'field'   => 'content',
							'label'   => 'Content',
							'rules'   => 'required'
						);
					}
				}else{
					$config = array(
						array(
							'field'   => 'content',
							'label'   => 'Content',
							'rules'   => 'required'
						)
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Seo_Model->save($edit);
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
	function analytics(){
		$data['id'] =  $this->Seo_Model->get_analytics_id();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_analytics_code_id_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_analytics_code_id(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'id',
						'label'   => 'Web Property ID',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Seo_Model->save_analytics_id();
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Google analytics code ID succesfully saved.</div>'
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
	function footer_tags(){
		$data['footer_tags'] =  $this->Seo_Model->get_footer_tags();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_footer_tags',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_footer_tags(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'footer_tags',
						'label'   => 'Web Property ID',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Seo_Model->save_footer_tags();
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Footer tags successfully saved.</div>'
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
	function dentists_featured(){
		$data['dentists_featured'] =  $this->Seo_Model->get_dentists_featured();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_dentists_featured',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_dentists_featured(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'dentists_featured',
						'label'   => 'Web Property ID',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Seo_Model->save_dentists_featured();
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Dentists featured successfully saved.</div>'
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
	function search_result_text(){
		$results = $this->Seo_Model->get_search_result_text();
		$data['title'] = $results['search_result_title'];
		$data['text'] = $results['search_result_text'];
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_search_result_text_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_search_result_text(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'title',
						'label'   => 'Title',
						'rules'   => 'required'
					),
					array(
						'field'   => 'text',
						'label'   => 'Text',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Seo_Model->save_search_result_text();
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Search result title/text succesfully saved.</div>'
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
	function add_dropdown_choice(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/add_dropdown_choice');
		$this->load->view('admin/common/footer_view');
	}
	function edit_dropdown_choice($edit){
		$data['value'] = $this->Choices_Model->get_choice($edit);
		$data['edit'] = $edit;
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_dropdown_choice',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_dropdown_choice($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'value',
						'label'   => 'Dropdown Value',
						'rules'   => 'required'
					)
				);
				
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Choices_Model->save($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Dropdown value succesfully saved.</div>'
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
	function delete_choice($id){
		$this->Seo_Model->purge_php_cache();
		$this->Choices_Model->delete($id);
		print TRUE;
	}
	function dropdown_choices_management(){
		$allvalue = $this->Choices_Model->get_all();
		$data['allvalue'] = $allvalue;
		$data['table'] = $this->createManageTableChoices($allvalue);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_dropdown_choices_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTableChoices($values){
		$table = '<tr class="header">
			<td>Dropdown Value</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$values){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($values as $value){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="92%">'.$value['value'].'</td>
					<td width="8%" align="center">
						<a class="page_box actionIcons" title="Edit" href="'.base_url().'_admin_console/home/edit_dropdown_choice/'.$value['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$value['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function edit_sub_admin($id){
		$data['admin'] = $this->Admin_Model->get_details($id);
		$data['privileges'] = $this->Privileges_Model->get_all_settings();
		$data['user_privileges'] =  $this->Privileges_Model->get_admin_privileges($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_sub_admin_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function add_sub_admin(){
		$data['privileges'] = $this->Privileges_Model->get_all_settings();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/add_sub_admin_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_edit_sub_admin($id){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'email',
						'label'   => 'Login',
						'rules'   => 'required|valid_email'
					),array(
						'field'   => 'privileges',
						'label'   => 'Privileges',
						'rules'   => 'required'
					)
				);
				if($this->input->post('change_pass')){
					$config[] = array(
						'field'   => 'password',
						'label'   => 'Password',
						'rules'   => 'required'
					);
					$config[] = array(
						'field'   => 'ret_password',
						'label'   => 'Confirm Password',
						'rules'   => 'required|matches[password]'
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$adminid = $this->Admin_Model->save_sub_admin($id);
					$this->Privileges_Model->delete_sub_admin_privileges($id);
					$this->Privileges_Model->add_privileges($id);
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Sub-admin succesfully saved.</div>'
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
	function save_sub_admin(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'email',
						'label'   => 'Login',
						'rules'   => 'required|valid_email|callback_check_unique_email'
					),array(
						'field'   => 'password',
						'label'   => 'Password',
						'rules'   => 'required'
					),array(
						'field'   => 'ret_password',
						'label'   => 'Confirm Password',
						'rules'   => 'required|matches[password]'
					),array(
						'field'   => 'privileges',
						'label'   => 'Privileges',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$adminid = $this->Admin_Model->add_sub_admin();
					$this->Privileges_Model->add_privileges($adminid);
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Sub-admin succesfully saved.</div>'
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
	function manage_sub_admin(){
		$allsub = $this->Admin_Model->get_all_sub_admin();
		$data['allsub'] = $allsub;
		$data['table'] = $this->createManageTableSubAdmin($allsub);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_sub_admin_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function add_cms_user(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/add_cms_user_view');
		$this->load->view('admin/common/footer_view');
	}
	function edit_cms_user($id){
		$data['admin'] = $this->CMS_Model->get_details($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/site/edit_cms_user_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_cms_user(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'email',
						'label'   => 'Login',
						'rules'   => 'required|valid_email|callback_check_unique_cms_email'
					),array(
						'field'   => 'name',
						'label'   => 'Name',
						'rules'   => 'required'
					),array(
						'field'   => 'password',
						'label'   => 'Password',
						'rules'   => 'required'
					),array(
						'field'   => 'ret_password',
						'label'   => 'Confirm Password',
						'rules'   => 'required|matches[password]'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$adminid = $this->CMS_Model->add_cms_user();
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">CMS User succesfully saved.</div>'
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
	function save_edit_cms_user($id){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'email',
						'label'   => 'Login',
						'rules'   => 'required|valid_email'
					),array(
						'field'   => 'name',
						'label'   => 'Name',
						'rules'   => 'required'
					)
				);
				if($this->input->post('change_pass')){
					$config[] = array(
						'field'   => 'password',
						'label'   => 'Password',
						'rules'   => 'required'
					);
					$config[] = array(
						'field'   => 'ret_password',
						'label'   => 'Confirm Password',
						'rules'   => 'required|matches[password]'
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$adminid = $this->CMS_Model->save_cms_user($id);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">CMS user succesfully saved.</div>'
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
	function manage_cms_user(){
		$allsub = $this->CMS_Model->get_all_cms_users();
		$data['allsub'] = $allsub;
		$data['table'] = $this->createManageTableCmsUsers($allsub);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/site/manage_cms_users_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTableCmsUsers($values){
		$table = '<tr class="header">
			<td>Login</td>
			<td>Name</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$values){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($values as $value){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="52%">'.$value['login'].'</td>
					<td width="40%">'.$value['name'].'</td>
					<td width="8%" align="center">
						<a class="page_box actionIcons" title="Edit" href="'.base_url().'_admin_console/home/edit_cms_user/'.$value['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$value['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function delete_cms_user($id){
		$this->Seo_Model->purge_php_cache();
		$this->CMS_Model->delete_cms_user($id);
	}
	function createManageTableSubAdmin($values){
		$table = '<tr class="header">
			<td>Login</td>
			<td>Privileges</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$values){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($values as $value){
				$privileges = $this->Privileges_Model->get_admin_privileges($value['id']);
				$text_privileges = NULL;
				foreach($privileges AS $priv){
					$text_privileges .= '<img src="'.base_url().'assets/images/admin/bullet_green.png" style="margin-bottom: -4px;">'.$priv['name'].' '; 
				}
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="15%">'.$value['login'].'</td>
					<td width="77%">'.$text_privileges.'</td>
					<td width="8%" align="center">
						<a class="page_box actionIcons" title="Edit" href="'.base_url().'_admin_console/home/edit_sub__admin/'.$value['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$value['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function delete_sub_admin($id){
		$this->Seo_Model->purge_php_cache();
		$this->Admin_Model->delete_sub_admin($id);
		$this->Privileges_Model->delete_sub_admin_privileges($id);
	}
	function check_unique_email($str){
		if($this->Admin_Model->check_unique_email($str)){
			$this->form_validation->set_message('check_unique_email', "$str is already used");
			return FALSE;
		}
	}
	function check_unique_cms_email($str){
		if($this->CMS_Model->check_unique_email($str)){
			$this->form_validation->set_message('check_unique_cms_email', "$str is already used");
			return FALSE;
		}
	}
}