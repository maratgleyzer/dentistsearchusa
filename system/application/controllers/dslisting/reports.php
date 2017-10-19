<?php

class Reports extends Controller {

	function Reports(){
		parent::Controller();
		if(!$this->session->userdata('cmsuser_logged_in')){
			header('location: '.base_url().'dslisting/login');
		}
		$this->load->model('CMS_Model');
		$this->load->model('Patients_Model');
		
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
	function generate_report(){
		$this->load->view('dslisting/common/header_view');
		$this->load->view('dslisting/common/menu_view');
		$this->load->view('dslisting/reports/generate_report_view');
		$this->load->view('dslisting/common/footer_view');
	}
	function customer_report($action){
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			$logged_id = $this->session->userdata('cmsuser_logged_id');
			if($logged_id){
				if($this->input->post('report_type') == 'weekly'){
					$config = array(
						array(
							'field'   => 'start_date',
							'label'   => 'Start Date',
							'rules'   => 'required'
						),array(
							'field'   => 'end_date',
							'label'   => 'End Date',
							'rules'   => 'required'
						)
					);
				}
				$config[] = array(
								'field'   => 'dentist_assigned_to',
								'label'   => 'Customer Report for',
								'rules'   => 'required'
							);
				
				$this->form_validation->set_rules($config);
				if($this->form_validation->run()){
					
					if($this->input->post('report_type') == 'weekly'){
						if($this->input->post('dentist_assigned_to') == 0){
							$the_res = $this->Patients_Model->get_patients_date_range($this->input->post('start_date'),$this->input->post('end_date')); //query weekly
						}else{
							$the_res = $this->Patients_Model->get_patients_date_range_by_dentist($this->input->post('dentist_assigned_to'),$this->input->post('start_date'),$this->input->post('end_date')); //query weekly by dentist
						}
					}else{
						if($this->input->post('dentist_assigned_to') == 0){
							$the_res = $this->Patients_Model->get_patients_monthly(); //query monthly
						}else{
							$the_res = $this->Patients_Model->get_patients_monthly_by_dentist($this->input->post('dentist_assigned_to')); //query monthly by dentist
						}
					}
					
					if($action == 'preview'){
						$report = $this->create_preview_report($the_res); //create preview
					}else{
						if($this->input->post('report_format') == 'pdf'){
							$report = $this->create_pdf_report($the_res); //generate PDF
						}else{
							$report = $this->create_excel_report($the_res); //generate Excel
						}
					}
					
					
					$res = array(
						'success' => TRUE,
						'message' => '<div class="form_success">Report successfully generated.</div>',
						'report' => $report,
						'action' => $action,
						'format' => $this->input->post('report_format')
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
	function create_preview_report($patients){
		return $this->createManageTablePatients($patients);
	}
	function createManageTablePatients($allpatients){
		$table = '<tr class="header">
			<td>Patient Name</td>
			<td>Phone</td>
			<td>Office Contact</td>
			<td>Appointment</td>
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
				$table .= '<tr '.$rowbg.' style="font-size:11px;">
					<td width="25%"><label style="color:#05887B;">'.$patient['patient_name'].'</label></td>
					<td width="25%">'.ret_alt_echo($patient['phone'],' - - - - - - - - - -').'</td>
					<td width="20%">'.ret_alt_echo($patient['office_contact'],' - - - - - - - - - -').'</td>
					<td width="30%">'.ret_alt_echo($patient['appointment_time'],'<center><i>NONE</i></center>','<label style="color:#05887B;">'.$patient['appointment_date'].' ','</label>').'</td>
				</tr>';
			}
		}
		return $table;
	}
	function create_excel_report($patients){
		ob_start();
		// start the file
		$excel_table = '<table border="1" style="border-color:#cdcdcd;"><tr>
					<td style="font-weight:bold;">Patient Name</td>
					<td style="font-weight:bold;">Caller Name</td>
					<td style="font-weight:bold;">Phone</td>
					<td style="font-weight:bold;">Office Contact</td>
					<td style="font-weight:bold;">Email</td>
					<td style="font-weight:bold;">Address</td>
					<td style="font-weight:bold;">City</td>
					<td style="font-weight:bold;">State</td>
					<td style="font-weight:bold;">Zip</td>
					<td style="font-weight:bold;">Appointment</td>
				</tr>';
		$i = 0;		
		foreach($patients AS $patient){
			if($i%2){
				$rowbg = 'style="background-color:#f3f3f3;"';
			}else{
				$rowbg = '';
			}
			$i++;
			$excel_table .= '
			<tr '.$rowbg.'>	
				<td style="border-color:#cdcdcd;">'.$patient['patient_name'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['caller_name'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['phone'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['office_contact'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['email'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['address'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['city'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['state'].'</td>
				<td style="border-color:#cdcdcd;">'.$patient['zip'].'</td>
				<td style="border-color:#cdcdcd;">'.ret_alt_echo($patient['appointment_time'],'NA',$patient['appointment_date'].' ').'</td>
			</tr>';
		}
		$excel_table .= '</table>';
		echo $excel_table;
		$randstring = random_string('numeric',6);
		file_put_contents("dslistings_docs/reports/referrals_{$randstring}.xls", ob_get_clean());
		return "referrals_{$randstring}";
	}
	function create_pdf_report($patients){
		$pdf_table = '
			<style>
				table{
					font-family: helvetica;
					font-size: 9px;
					border-collapse: collapse;
					width: 776px;
				}
				table td{
					padding: 2px;
					padding-left: 8px;
					color: gray;
				}
				tr td.headers{
					font-weight: bold;
					background-color: #0d887c;
					font-size: 10px;
					color: white;
				}
			</style>
			<div>
				<img src="'.base_url().'assets/themes/default/images/logo.gif"/>
				<br/><br/>
			</div>
			<table style="border-color:#cdcdcd;">
				<tr>
					<td class="headers" style="font-weight:bold;">Patient Name</td>
					<td class="headers" style="font-weight:bold;">Caller Name</td>
					<td class="headers" style="font-weight:bold;">Phone</td>
					<td class="headers" style="font-weight:bold;">Office Contact</td>
					<td class="headers" style="font-weight:bold;">Email</td>
					<td class="headers" style="font-weight:bold;">Address</td>
					<td class="headers" style="font-weight:bold;">City</td>
					<td class="headers" style="font-weight:bold;">State</td>
					<td class="headers" style="font-weight:bold;">Zip</td>
					<td class="headers" style="font-weight:bold;">Appointment</td>
				</tr>';
		$i = 0;		
		foreach($patients AS $patient){
			if($i%2){
				$rowbg = 'background-color:#f3f3f3;';
			}else{
				$rowbg = '';
			}
			$i++;
			$pdf_table .= '
			<tr>	
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['patient_name'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['caller_name'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['phone'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['office_contact'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['email'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['address'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['city'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['state'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.$patient['zip'].'</td>
				<td style="border-color:#cdcdcd;'.$rowbg.'">'.ret_alt_echo($patient['appointment_time'],'NA',$patient['appointment_date'].' ').'</td>
			</tr>';
		}
		$pdf_table .= '</table>';
		
		require_once("dompdf/dompdf_config.inc.php");
		$old_limit = ini_set("memory_limit", "64M");
		
		$dompdf = new DOMPDF();
		$dompdf->load_html($pdf_table);
		$dompdf->set_paper('letter', 'landscape');
		$dompdf->render();
		$pdf = $dompdf->output();
		$randstring = random_string('numeric',6);
		file_put_contents("dslistings_docs/reports/referrals_{$randstring}.pdf", $pdf);
		return "referrals_{$randstring}";
	}
	function download_report($report,$ext){
		$data = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/dslistings_docs/reports/'.$report.'.'.$ext);
		force_download($report.'.'.$ext, $data); 
	}
}