<?php

class Articles extends Controller {

	function Articles(){
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('admin_logged_in')){
				header('location: '.base_url().'_admin_console/login');
			}
		}
		$this->load->model('Blog_Model');
		$this->load->model('Seo_Model');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('file');
		$this->load->helper('my_image');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');
	}
	function add_article(){
		$data['categories'] = $this->Blog_Model->categories(1);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/articles/add_article_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function edit_article($id){
		$dets = $this->Blog_Model->content_page($id);
		$data = $dets[0];
		$data['categories'] = $this->Blog_Model->categories(1);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/articles/edit_article_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function upload_image(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$_FILES['Filedata']['type'] = get_mime_by_extension($_FILES['Filedata']['name']);
			$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/content_assets/images/';
			$config['allowed_types'] = 'png|jpeg|jpg';
			$config['max_size']	= '5000';
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
	function save_article($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'author',
						'label'   => 'Author',
						'rules'   => 'required'
					),
					array(
						'field'   => 'category',
						'label'   => 'Category',
						'rules'   => 'required'
					),
					array(
						'field'   => 'title',
						'label'   => 'Title',
						'rules'   => 'required'
					),
					array(
						'field'   => 'tags',
						'label'   => 'Tags',
						'rules'   => 'required'
					),
					array(
						'field'   => 'summary',
						'label'   => 'Summary',
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
					$this->Seo_Model->purge_php_cache();
					$this->Blog_Model->save($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Article succesfully saved.</div>'
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
	function delete_category($id){
		$this->Blog_Model->delete_category($id);
	}
	function add_category(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/articles/add_category_view');
		$this->load->view('admin/common/footer_view');
	}
	function edit_category($id){
		$data['category'] = $this->Blog_Model->get_category($id);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/articles/edit_category_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_category($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'category_title',
						'label'   => 'Category Title',
						'rules'   => 'required'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Blog_Model->save_category($edit,FALSE);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Article category succesfully saved.</div>'
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
	function manage_articles($sort='date',$message=null){
		$allarticle = $this->Blog_Model->articles($sort);
		$data['sort'] = $sort;
		$data['allarticle'] = $allarticle;
		$data['table'] = $this->createManageTable($sort,$allarticle);
		$data['message'] = $message;
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/articles/manage_article_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function manage_categories(){
		$categories = $this->Blog_Model->categories_and_count();
		$data['categories'] =  $categories;
		$data['table'] = $this->createManageTableCategories($categories);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/articles/manage_categories_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function delete($id){
		$this->Seo_Model->purge_php_cache();
		$this->Blog_Model->delete($id);
	}
	function createManageTable($sort,$allarticle){
		$table = '<tr class="header">
			<td>Title</td>
			<td>Author</td>
			<td>Summary</td>
			<td>Category</td>
			<td>Publish Date</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allarticle){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allarticle as $article){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				$table .= '<tr '.$rowbg.'>
					<td width="15%">'.$article['title'].'</td>
					<td width="12%">'.$article['author'].'</td>
					<td width="45%">'.substr(strip_tags($article['summary']),0,100).'...</td>
					<td width="10%">'.$article['category_title'].'</td>
					<td width="10%">'.$article['date'].'</td>
					<td width="8%">
						<a href="'.base_url().'_admin_console/articles/edit_article/'.$article['id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;&nbsp;
						<a onClick="confirmDelete(this,'.$article['id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function createManageTableCategories($allarticle){
		$table = '<tr class="header">
			<td>Category Name</td>
			<td>Description</td>
			<td>Articles</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allarticle){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allarticle as $article){
				if($article['art_count']){
					$delete = '<img src="'.base_url().'assets/images/admin/bin_closed.png"/>';
					$count_color = 'style="color:#057f73; font-weight:bold;"';
				}else{
					$delete = '<a onClick="confirmDelete(this,'.$article['id'].');return false;" href="#">
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
					<td width="25%">'.$article['category_title'].'</td>
					<td width="63%">'.$article['description'].'</td>
					<td width="4%" align="center" '.$count_color.'>'.$article['art_count'].'</td>
					<td width="8%">
						<a href="'.base_url().'_admin_console/articles/edit_category/'.$article['id'].'">
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
}