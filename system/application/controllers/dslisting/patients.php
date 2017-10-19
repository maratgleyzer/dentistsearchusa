<?php

class Patients extends Controller {

	function Patients(){
		parent::Controller();
		if(!$this->session->userdata('cmsuser_logged_in')){
			header('location: '.base_url().'dslisting/login');
		}
		$this->load->model('CMS_Model');
		$this->load->model('Patients_Model');
		$this->load->model('Company_Info_Model');
		$this->load->model('Personal_Info_Model');
		$this->load->model('Event_scheduler_model');
	
		$this->load->helper('form');
		$this->load->helper('string');
		$this->load->helper('security');
		$this->load->helper('text');
		$this->load->helper('string');
		$this->load->helper('download');
		
		$this->load->library('form_validation');
	}
	function index(){
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/home_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function pdf_view(){
		$this->load->view('dslisting/patients/pdf_format_view');
	}
	function pdf($updated_notes){
		$assigned_id = $this->input->post('dentist_assigned_to');
		$scheds['mon'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'monday');
		$scheds['tue'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'tuesday');
		$scheds['wed'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'wednesday');
		$scheds['thu'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'thursday');
		$scheds['fri'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'friday');
		$scheds['sat'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'saturday');
		$scheds['sun'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'sunday');
				
		$data = $_POST;
		$data['dentist'] = $this->Personal_Info_Model->get_data($assigned_id);
		
	//	die(print_r($data['dentist']));
		
		$data['scheds'] = $scheds;
		$data['notes'] = $updated_notes;
	
		require_once("dompdf/dompdf_config.inc.php");
		$old_limit = ini_set("memory_limit", "64M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($this->load->view('dslisting/patients/pdf_format_view',$data,TRUE));
		$dompdf->set_paper('letter', 'portrait');
		$dompdf->render();
		$pdf = $dompdf->output();
		
		$randstring = random_string('numeric',6);
		if($this->input->post('pdf_file')){
			$pdf_filename = $this->input->post('pdf_file');
		}else{
			$pdf_filename = str_replace(' ','',$this->input->post('patient_name')).'_'.$randstring;
		}
		file_put_contents("dslistings_docs/{$pdf_filename}.pdf", $pdf);
		
		return $pdf_filename;
	}
	function add_patient(){
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/patients/add_patient_view');
		$this->load->view('dslisting/patients/patient_details_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function edit_patient($id){
		$data['patient'] = $this->Patients_Model->get_patient($id);
		$assigned_id = $data['patient']['dentist_assigned_to'];
		
		$scheds['mon'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'monday');
		$scheds['tue'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'tuesday');
		$scheds['wed'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'wednesday');
		$scheds['thu'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'thursday');
		$scheds['fri'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'friday');
		$scheds['sat'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'saturday');
		$scheds['sun'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'sunday');
		
		$data['dentist'] = $this->Personal_Info_Model->get_data($assigned_id);
		$data['scheds'] = $scheds;
		
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/patients/edit_patient_view',$data);
		$this->load->view('dslisting/patients/patient_details_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function patient_page($id){
		$data['view_page'] = TRUE;
		$data['patient'] = $this->Patients_Model->get_patient($id);
		$assigned_id = $data['patient']['dentist_assigned_to'];
		
		$scheds['mon'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'monday');
		$scheds['tue'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'tuesday');
		$scheds['wed'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'wednesday');
		$scheds['thu'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'thursday');
		$scheds['fri'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'friday');
		$scheds['sat'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'saturday');
		$scheds['sun'] = $this->Event_scheduler_model->get_scheds_by_day($assigned_id,'sunday');
		
		$data['dentist'] = $this->Personal_Info_Model->get_data($assigned_id);
		$data['scheds'] = $scheds;
		
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/patients/edit_patient_view',$data);
		$this->load->view('dslisting/patients/edit_patient_details_view',$data);
		$this->load->view('dslisting/common/footer_view');
	}
	function save_patient(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('cmsuser_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'caller_name',
						'label'   => 'Caller Name',
						'rules'   => 'required'
					),
/*					array(
						'field'   => 'dental_emergency',
						'label'   => 'Dental Emergency',
						'rules'   => 'required'
					),
					array(
						'field'   => 'phone',
						'label'   => 'Phone Number',
						'rules'   => 'required'
					),
					array(
						'field'   => 'pain_level',
						'label'   => 'Pain Level',
						'rules'   => 'required'
					),
*/					array(
						'field'   => 'patient_name',
						'label'   => 'Patient Name',
						'rules'   => 'required'
					),
					array(
						'field'   => 'dentist_assigned_to',
						'label'   => 'Dentist Assigned To',
						'rules'   => 'required'
/*					),
					array(
						'field'   => 'fear_of_dentist',
						'label'   => 'Fear of Dentist',
						'rules'   => 'required'
					),
					array(
						'field'   => 'last_appointment_date',
						'label'   => 'Last Appointment Date',
						'rules'   => 'required'
					),
					array(
						'field'   => 'birth_day',
						'label'   => 'Birth Day',
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
						'field'   => 'email',
						'label'   => 'Email Address',
						'rules'   => 'required|valid_email'
					),
					array(
						'field'   => 'office_contact',
						'label'   => 'Office Contact',
						'rules'   => 'required'
					),
					array(
						'field' => 'notes',
						'label' => 'Notes',
						'rules' => 'required'
*/					)
				);
				if($this->input->post('additional_notes')){
					$append_notes = '<div class="notes_append"><label class="append_header">Note Appended on: '.date("F j, Y, g:i a").'</label><br/><br/><div>'.$this->input->post('additional_notes').'</div></div>';
					$notes = $this->input->post('notes').$append_notes;
				}else{
					$notes = $this->input->post('notes');
				}
				if($this->input->post('appointment_made') || $this->input->post('appointment_date') || $this->input->post('appointment_time')){
					$config[] = array(
						'field'   => 'appointment_date',
						'label'   => 'Appointment Date',
						'rules'   => 'required'
					);
					$config[] = array(
						'field'   => 'appointment_time',
						'label'   => 'Appointment Time',
						'rules'   => 'required'
					);
				}
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					@$pdf_filename = $this->pdf($notes);
					$saved_id = $this->Patients_Model->save_patient($this->input->post('save_id'),$notes,$pdf_filename);
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Patient succesfully saved.</div>',
						'notes' => $notes,
						'saved_id' => $saved_id,
						'pdf_file' => $pdf_filename,
						'dentist_assigned_to_id' => $this->input->post('dentist_assigned_to')
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
	function patient_list($sort='added'){
		$allpatients = $this->Patients_Model->get_patients($sort);
		$data['sort'] = $sort;
		$data['allpatients'] = $allpatients;
		$data['table'] = $this->createManageTablePatients($sort,$allpatients);
	
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/patients/patient_list_view',$data);
		$this->load->view('dslisting/common/footer_view');
	}
	function createManageTablePatients($sort,$allpatients){
		$table = '<tr class="header">
			<td>Patient Details</td>
			<td>Customer Details</td>
			<td>Office Contact</td>
			<td>Referral Date</td>
			<td>Assigned to</td>
			<td>Actions</td>
		</tr>';
		$i = 0;
		
		if(!$allpatients){
			$table .= '<tr><td colspan="7" id="manage_table_no_records">No records to show</td></tr>';
		}else{
			foreach($allpatients as $patient){
				if($i%2){
					$rowbg = 'style="background-color:white;color:gray;"';
				}else{
					$rowbg = 'style="color:#595959;"';
				}
				$i++;
				
				$updated_date = NULL;
				if($patient['updated']){
					$updated_date = 'Updated: '.date("M d, Y g:ia", strtotime($patient['updated']));
				}
				if($patient['last_name']){
					$dentist_details = '<label style="color:#05887B;">'.$patient['last_name'].', '.$patient['first_name'].' '.$patient['post_nominal'].'</label><br> Phone: '.$patient['telephone'];
				}else{
					$dentist_details = '<label style="color:red;">NONE</label>';
				}
				$table .= '<tr '.$rowbg.' style="font-size:11px;">
					<td width="20%"><label style="color:#05887B;">'.$patient['patient_name'].'</label> <br/> Phone: '.ret_alt_echo($patient['phone'],' - - - - - - - - - -').'</td>
					<td width="20%">'.$dentist_details.'</td>
					<td width="12%">'.ret_alt_echo($patient['office_contact'],' - - - - - - - - - -').'</td>
					<td width="16%">'.date("M d, Y g:ia", strtotime($patient['added'])).'</td>
					<td width="20%"><label style="color:#05887B;">'.$patient['name'].'</label><br/><label style="font-size:10px;">'.$updated_date.'</label></td>
					<td width="12%">
						<a href="#" onclick="send_pdf(\''.$patient['pdf_file'].'\')">
							<img src="'.base_url().'assets/images/admin/page_white_acrobat.png"/>
						</a>
						&nbsp;
						<a href="'.base_url().'dslisting/patients/edit_patient/'.$patient['pa_id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_edit.png"/>
						</a>
						&nbsp;
						<a href="'.base_url().'dslisting/patients/patient_page/'.$patient['pa_id'].'">
							<img src="'.base_url().'assets/images/admin/page_white_magnify.png"/>
						</a>
						&nbsp;
						<a onClick="confirmDelete(this,'.$patient['pa_id'].');return false;" href="#">
							<img src="'.base_url().'assets/images/admin/bin_empty.png"/>
						</a>
					</td>
				</tr>';
			}
		}
		return $table;
	}
	function search_dentist(){
		$dentists = $this->Company_Info_Model->filter_dentist();
		$dents = NULL;
		$i = 0;
		if($dentists){
			foreach($dentists AS $dentist){
				if($i%2){
					$class = 'result_bg_alt';
				}else{
					$class = 'result_bg';
				}
				$i++;
				
				$scheds['mon'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'monday');
				$scheds['tue'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'tuesday');
				$scheds['wed'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'wednesday');
				$scheds['thu'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'thursday');
				$scheds['fri'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'friday');
				$scheds['sat'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'saturday');
				$scheds['sun'] = $this->Event_scheduler_model->get_scheds_by_day($dentist['id'],'sunday');
				
				$json_details = json_encode($dentist);
				$prof_pic = $dentist['prof_pic'];
				if($prof_pic){
					$picvid = explode(".",$prof_pic);
					if($picvid[1]=="flv"){
						$image = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/playvid_small.gif&width=56&height=56" alt="image" width="56" height="56" />';
					}else{
						$image = '<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'user_assets/prof_images/'.$prof_pic.'&width=56&height=56" alt="image" />';
					}
				}else{
					$image ='<img src="'.base_url().'assets/phpthumb/resize.php?src='.base_url().'assets/themes/default/images/no_photo_small.png&width=56&height=56" alt="image" width="56" height="56" />';
				}
				$dents .= "<div class=\"{$class}\" onmouseover=\"highlight_result(this,true)\" onmouseout=\"highlight_result(this,false)\" onclick=\"select_dentist(".htmlspecialchars($json_details,ENT_QUOTES).",".htmlspecialchars(json_encode($scheds),ENT_QUOTES).")\">
					<div class=\"result_photo\">
						{$image}
					</div>
					<div class=\"result_info\">
						<label class=\"dentist_name\">{$dentist['last_name']}, {$dentist['first_name']} {$dentist['post_nominal']}</label>
						<label>{$dentist['company_name']}</label>
						<label>{$dentist['address']}</label>
						<label>{$dentist['city']} {$dentist['state']} {$dentist['zip']}</label>
					</div>
				</div>";
			}
		}else{
			$dents = '<label>No results found</label>';
		}
		$res = array(
			'success' => TRUE,
			'results' => $dents
		);
		print json_encode($res);
	}
	function send_pdf(){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('cmsuser_logged_id');
			if($logged_id){
				$config = array(
					array(
						'field'   => 'emails',
						'label'   => 'Recepients',
						'rules'   => 'required|valid_emails'
					)
				);
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					//sending process here.
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">PDF file succesfully sent.</div>'
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
	function download_patient_pdf($file){
		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/dslistings_docs/'.$file.'.pdf');
		force_download($file.'.pdf', $data); 
	}
	function delete($id){
		$this->Patients_Model->delete_patient($id);
	}
}