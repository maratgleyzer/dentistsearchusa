<?php

class Advertisements extends Controller {

	function advertisements(){
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('admin_logged_in')){
				header('location: '.base_url().'_admin_console/login');
			}
		}
		
		$this->load->model('Advertisements_Model');
		$this->load->model('Seo_Model');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('file');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');

	}
	function manage_sidebar_ads(){
		$sidebarads = $this->Advertisements_Model->get_sidebar_ads();
		$data['sidebarads'] = $sidebarads;
		$data['table'] = $this->createManageTableSidebarAds($sidebarads);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/advertisements/manage_sidebar_ads_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_footer_ads(){
		$footerads = $this->Advertisements_Model->get_footer_ads();
		$data['footerads'] = $footerads;
		$data['table'] = $this->createManageTableFooterAds($footerads);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/advertisements/manage_footer_ads_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTableSidebarAds($sidebarads){
		$table = '<tr class="header">
			<td>Section</td>
			<td>Page</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$sidebarads){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($sidebarads as $ad){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="40%">'.$ad['name'].'</td>
					<td width="52%"><a href="'.base_url().$ad['page'].'" target="_blank">'.base_url().$ad['page'].'</a></td>
					<td width="8%" style="text-align:center;">
						<a title="Edit" href="'.base_url().'_admin_console/advertisements/edit_sidebar_ads/'.$ad['page'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTableFooterAds($footerads){
		$table = '<tr class="header">
			<td>Image</td>
			<td>Title</td>
			<td>Text</td>
			<td>Align</td>
			<td>Link</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$footerads){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($footerads as $ad){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				if($ad['image']){
					$image = '<img class="footer_ads" src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'assets/images/advertisements/'.$ad['image'].'&width=220&height=96" alt="image" />';
				}else{
					$image = '<img class="footer_ads" src="'.base_url().'assets/images/advertisements/no_footer_ads.png" />';
				}
				$table .= '<tr '.$rowbg.'>
					<td width="20%">'.$image.'</td>
					<td width="20%">'.ret_alt_echo($ad['title'],'NA').'</td>
					<td width="20%">'.ret_alt_echo($ad['text'],'NA').'</td>
					<td width="7%">'.ret_alt_echo($ad['align'],'NA').'</td>
					<td width="25%">'.ret_alt_echo($ad['links'],'NA','<a target="_blank" href="'.$ad['links'].'">','</a>').'</td>
					<td width="8%" style="text-align:center;">
						<a title="Edit" href="'.base_url().'_admin_console/advertisements/edit_footer_ad/'.$ad['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function upload_footer_image(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/assets/images/advertisements/';
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size']	= '5000';
			$config['max_width'] = '220';
			$config['max_height'] = '96';
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
	function upload_sidebar_image($big=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/assets/images/advertisements/';
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size']	= '5000';
			
			if($big){
				$config['max_width'] = '259';
				$config['max_height'] = '215';
			}else{
				$config['max_width'] = '124';
				$config['max_height'] = '124';
			}
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
	function save_footer_ad($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$this->Seo_Model->purge_php_cache();		
				$this->Advertisements_Model->save_footer_ad($edit);
				$res = array(
					'success' => TRUE,
					'message' => '<div class="form_success">Footer ad succesfully saved.</div>'
				);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
	function save_sidebar_ads($page){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){				
				if($this->input->post('use_default')){
					$use_default = 1;
				}else{
					$use_default = 0;
				}
				$data_1 = array(
					'image' => ret_alt_echo($this->input->post('image_1'),''),
					'text' => ret_alt_echo($this->input->post('text_1'),''),
					'links' => ret_alt_echo($this->input->post('links_1'),''),
					'use_default' => $use_default
				);
				$data_2 = array(
					'image' => ret_alt_echo($this->input->post('image_2'),''),
					'text' => ret_alt_echo($this->input->post('text_2'),''),
					'links' => ret_alt_echo($this->input->post('links_2'),''),
					'use_default' => $use_default
				);
				$data_3 = array(
					'image' => ret_alt_echo($this->input->post('image_3'),''),
					'text' => ret_alt_echo($this->input->post('text_3'),''),
					'links' => ret_alt_echo($this->input->post('links_3'),''),
					'use_default' => $use_default
				);
				
				$this->Seo_Model->purge_php_cache();
				$this->Advertisements_Model->save_sidebar_ad($page,1,$data_1);
				$this->Advertisements_Model->save_sidebar_ad($page,2,$data_2);
				$this->Advertisements_Model->save_sidebar_ad($page,3,$data_3);
				$res = array(
					'success' => TRUE,
					'message' => '<div class="form_success">Sidebar ads succesfully saved.</div>'
				);
			}else{
				$res = array(
					'success' => FALSE,
					'message' => '<div class="form_error">Your session has ended. Please click <a href="#" style="color:white;" onclick="location.reload();">HERE</a> to refresh your browser and log-in again.</div>'
				);
			}
			print json_encode($res);
		}
	}
	function edit_footer_ad($edit){
		$data = $this->Advertisements_Model->get_footer_ad($edit);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/advertisements/edit_footer_ads_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function edit_sidebar_ads($page){
		$data['page'] = $page;
		$data['first_ad'] = $this->Advertisements_Model->get_sidebar_ads_by_page($page,1);
		$data['second_ad'] = $this->Advertisements_Model->get_sidebar_ads_by_page($page,2);
		$data['third_ad'] = $this->Advertisements_Model->get_sidebar_ads_by_page($page,3);
		
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/advertisements/edit_sidebar_ads_view',$data);
		$this->load->view('admin/common/footer_view');
	}
}