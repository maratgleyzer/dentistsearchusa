<div id="saved_patient_details_template">
	<div class="tab-content personal_info" id="tab-2">
		<div id="personal_form_messages" class="form_messages"></div>
		<div id="personal_info_col_left" style="display:inline;float:left;width: 360px; border-right: 1px solid #eeeeee;">
			<h4>Patient information:</h4> 
			<div class="row saved_readonly highlighted">
				<label>Caller Name:</label><br/>
				<label id="saved_caller_name" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>Dental Emergency:</label><br/>
				<label id="saved_dental_emergency" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Phone Number:</label><br/>
				<label id="saved_phone" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>Pain Level (0-10):</label><br/>
				<label id="saved_pain_level" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Patient Name:</label><br/>
				<label id="saved_patient_name" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly" style="padding-left:0px; padding-right:0px;">
				<div id="saved_dentist_info_container">
				
				</div>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Fear of Dentist:</label><br/>
				<label id="saved_fear_of_dentist" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>Last Appointment Date:</label><br/>
				<label id="saved_last_appointment_date" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Date of Birth:</label><br/>
				<label id="saved_birth_day" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>Address:</label><br/>
				<label id="saved_address" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>City:</label><br/>
				<label id="saved_city" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>State:</label><br/>
				<label id="saved_state" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Zip:</label><br/>
				<label id="saved_zip" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly">
				<label>Email Address:</label><br/>
				<label id="saved_email" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly highlighted">
				<label>Office Contact:</label><br/>
				<label id="saved_office_contact" class="saved_value">Text here</label>
			</div><!-- /row end -->
			<div class="row saved_readonly" id="saved_appointment_made">
				<div class="appointment_field_containers">
					<label>Appointment Date:</label><br/>
					<label id="saved_appointment_date" class="saved_value">Text here</label>
				</div>
				<div class="appointment_field_containers">
					<label>Appointment time:</label><br/>
					<label id="saved_appointment_time" class="saved_value">Text here</label>
				</div>
				<div class="clear_both" style="clear:both;"></div>
			</div>
		</div>
		<div id="personal_info_col_right" style="display:inline;float:left; padding-left: 20px;height: auto;">
			<h4>Notes: <a class="edit_links"  onclick="edit_information()"><img src="<?=base_url()?>assets/images/admin/page_white_edit.png"/> Edit Information</a></h4>
			<div class="row saved_readonly" id="saved_notes">
				
			</div><!-- /row end --><br>
		</div>
		<div class="clear_both" style="clear:both;"></div>
	</div><!-- /tab-2 end -->
</div>