<?php

class Payment extends Controller {

	function Payment(){
		parent::Controller();
		if($this->input->server('REQUEST_METHOD') != 'POST'){
			if(!$this->session->userdata('admin_logged_in')){
				header('location: '.base_url().'_admin_console/login');
			}
		}
		
		$this->load->model('Payments_Model');
		$this->load->model('Seo_Model');
		
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->helper('text');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/'.load_admin_level().'home_view');
		$this->load->view('admin/common/footer_view');
	}
	function add_payment_plan(){
		$data['plan_type'] = $this->Payments_Model->get_plan_types();
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/payment/add_payment_plan_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function edit_payment_plan($id){
		$data['plan_type'] = $this->Payments_Model->get_plan_types();
		$data['plan'] = $this->Payments_Model->get_plan($id);;
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view');
		$this->load->view('admin/payment/edit_payment_plan_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function save_payment_plan($edit=FALSE){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('admin_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'type',
						'label'   => 'Payment Type',
						'rules'   => 'required'
					),
					array(
						'field'   => 'name',
						'label'   => 'Payment Name',
						'rules'   => 'required'
					),
					array(
						'field'   => 'description',
						'label'   => 'Payment Description',
						'rules'   => 'required'
					)
				);
				$payment_type = $this->input->post('type');
				if($payment_type == 2){
					$config[] = array(
						'field' => 'initial_amount',
						'label' => 'Initial Payment',
						'rules' => 'required'
					);
				}elseif($payment_type == 3 || $payment_type == 4){
					$config[] = array(
						'field' => 'initial_amount',
						'label' => 'Initial Payment',
						'rules' => 'required'
					);
					$config[] = array(
						'field' => 'recurring_amount',
						'label' => 'Recurring Payment',
						'rules' => 'required'
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					$this->Seo_Model->purge_php_cache();
					$this->Payments_Model->save_payment_plan($edit);
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Payment plan succesfully saved.</div>'
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
	function manage_payment_plan($sort='type'){
		$plans = $this->Payments_Model->get_payment_plans($sort);
		$data['plans'] =  $plans;
		$data['sort'] = $sort;
		$data['table'] = $this->createManageTablePlans($plans);
		$this->load->view('admin/common/header_view');
		$this->load->view('admin/common/'.load_admin_level().'menu_view',$data);
		$this->load->view('admin/payment/manage_plans_view',$data);
		$this->load->view('admin/common/footer_view');
	}
	function createManageTablePlans($allplans){
		$table = '<tr class="header">
			<td>Plan Type</td>
			<td>Plan Name</td>
			<td>Description</td>
			<td>Initial Payment</td>
			<td>Recurring Payment</td>
			<td>Dentists</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		if(!$allplans){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allplans as $plan){
				if($plan['dentist_count']){
					$delete = '<img src="'.base_url().'assets/images/admin/bin_closed.png"/>';
					$count_color = 'style="color:#057f73; font-weight:bold;"';
				}else{
					$delete = '<a onClick="confirmDelete(this,'.$plan['id'].');return false;" href="#">
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
					<td width="15%">'.$plan['type_name'].'</td>
					<td width="20%">'.$plan['name'].'</td>
					<td width="35%">'.character_limiter($plan['description'],80).'</td>
					<td width="8%">'.ret_alt_echo($plan['initial_payment'],'<label style="color:red;">N/A</label>','<label style="color:green;">','</label>').'</td>
					<td width="8%">'.ret_alt_echo($plan['recurring_payment'],'<label style="color:red;">N/A</label>','<label style="color:green;">','</label>').'</td>
					<td width="6%" align="center" '.$count_color.'>'.$plan['dentist_count'].'</td>
					<td width="8%">
						<a href="'.base_url().'_admin_console/payment/edit_payment_plan/'.$plan['id'].'">
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
	function delete($id){
		$this->Seo_Model->purge_php_cache();
		$this->Payments_Model->delete($id);
	}
}