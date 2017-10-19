<script type="text/javascript" src="<?=min_file('assets/js/jquery.wysiwyg.js')?>"></script>
<script type="text/javascript" src="<?=min_file('assets/js/jquery.metadata.js')?>"></script>
<script type="text/javascript" src="<?=min_file('assets/js/city-zip-autocomplete.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/css/jquery.wysiwyg.css')?>" />
<script type="text/javascript" src="<?=base_url();?>assets/js/jquery-ui-timepicker.js"></script>
<script type="text/javascript">
	function check_appointment(){
		$('input:[name=appointment_made]').attr('checked',true)
	}
	function display_value(name){
		$('#saved_'+name).text($('input:[name='+name+']').val());
	}
	function save_success_pdf(){
		setTimeout('$.fancybox.close()',3000);
	}
	function save_success(ret){
		$('#saved_patient_name').text(ucwords($('input:[name=patient_name]').val()));
		$('#saved_caller_name').text(ucwords($('input:[name=caller_name]').val()));
		
		$('#saved_dental_emergency').text($('select:[name=dental_emergency] option:selected').text());
		$('#saved_pain_level').text($('select:[name=pain_level] option:selected').text());
		$('#saved_fear_of_dentist').text($('select:[name=fear_of_dentist] option:selected').text());
		
		$('#label_dentist_assigned_to').text('Dentist Assigned to:');
		$('#saved_dentist_info_container').html($('#dentist_info_container').html());
		$('#saved_dentist_info_container input').replaceWith('<label style="position:absolute; top: 20px; left: 10px; z-index: 2000; font-weight:bold; color:#058b7f;">'+$('#input_dentist_assigned_to').val()+'</label>');
		var adjusted_height = $('#dentist_info').height();
		$('div#saved_dentist_info_container').css('height',adjusted_height+20);
		
		$('textarea:[name=notes]').val(ret.notes);
		$('#saved_notes').html(ret.notes);
	//	$('#saved_notes_edit_text').empty();
		$('#saved_notes_edit_text').html(ret.notes);
		display_value('phone');
		display_value('patient_name');
		display_value('last_appointment_date');
		display_value('birth_day');
		display_value('address');
		display_value('city');
		display_value('state');
		display_value('zip');
		display_value('email');
		display_value('office_contact');
		
		var save_id = $('input:[name=save_id]').val();
		$('input:[name=save_id]').val(ret.saved_id);
		
		if($('input:[name=appointment_made]').attr('checked')){
			$('#saved_appointment_made').css('display','block');
			$('#saved_appointment_date').text($('input:[name=appointment_date]').val());
			$('#saved_appointment_time').text($('input:[name=appointment_time]').val());
		}else{
			$('#saved_appointment_made').css('display','none');
		}
		
		$('#additional_notes').wysiwyg('clear');
		$('#saved_patient_details_template').css('display','block');
		$('#add_patient_form_template').css('display','none');
		
		$('input:[name=pdf_file]').val(ret.pdf_file);
		$('#pdf_download_link').attr('href',base_url+'dslisting/patients/download_patient_pdf/'+ret.pdf_file);
		$('#pdf_download_link').html('<img src="'+base_url+'assets/images/admin/page_white_acrobat.png"/> '+ret.pdf_file+'.pdf');
		
		if(save_id == 0){
			$("a#send_pdf_box_link").fancybox().trigger('click');
		}
		if(ret.dentist_assigned_to_id == 0){
			$('div#saved_dentist_info_container').css('height','30px');
			$('div#saved_dentist_info_container').html('Dentist Assigned to: <br/><label class="saved_value">NONE</label>');
			$('#label_dentist_assigned_to').html('Dentist Assigned to: <input onchange="assign_no_dentist(this)" checked="checked" style="margin-top: 0px;" id="none_checkbox" type="checkbox"><i style="color:#00796b;">None</i>');
		}else{
			$('div#saved_dentist_info_container').css('display','block');
			$('#label_dentist_assigned_to').html('Dentist Assigned to: <input onchange="assign_no_dentist(this)" style="margin-top: 0px;" id="none_checkbox" type="checkbox"><i style="color:#00796b;">None</i>');
		}
	}
	$(function(){
		$('input#btn_personal_info').click(function(){
			process_form('input#btn_personal_info','SAVE','div#personal_form_messages',true,'form#personal_info','dslisting/patients/save_patient/',false,'save_success');
		});
		$('input#btn_send_pdf').click(function(){
			process_form('input#btn_send_pdf','SEND','div#send_pdf_form_messages',false,'form#send_pdf','dslisting/patients/send_pdf/',false,'save_success_pdf');
		});
		
		$('.wysiwyg_text').wysiwyg();
		
		var adjusted_height = $('#dentist_info').height();
		$('div#dentist_info_container').css('height',adjusted_height+20);
		
		$('#notes_edit_patient').css('display','block');
		$('#notes_add_patient').css('display','none');
		$('#appoinment_made_box').css('display','block');
		$('#dentist_info').css('display','block');
		
		<?php if($view_page){ ?>
			$('#saved_dentist_info_container').html($('#dentist_info_container').html());
			$('#saved_dentist_info_container input').replaceWith('<label style="position:absolute; top: 20px; left: 10px; z-index: 2000; font-weight:bold; color:#058b7f;">'+$('#input_dentist_assigned_to').val()+'</label>');
			$('div#saved_dentist_info_container').css('height',adjusted_height+20);
			
			$('#saved_patient_details_template').css('display','block');
			$('#add_patient_form_template').css('display','none');
			
			<?php if($patient['dentist_assigned_to'] == 0){ ?>
				$('div#saved_dentist_info_container').css('height','30px');
				$('div#saved_dentist_info_container').html('Dentist Assigned to: <br/><label class="saved_value">NONE</label>');
			<?php } ?>
		<?php } ?>
	})
	$(document).ready(function(){
		$("a#dentist_search_link").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
		})
		$("a#send_pdf_box_link").fancybox({
			'titleShow'     : false,
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
		})
	})
	function open_search(el){
		$("a#dentist_search_link").fancybox().trigger('click');
		el.focus();
	}
	function dentist_search(){
		$('#dentist_results').empty();
		values = $('#search_form').serializeArray();
		$('#dentist_search_loading').css('display','block');
		$.ajax({
			type: 'POST',
			url: base_url+'dslisting/patients/search_dentist',
			data: values,
			dataType: 'json',
			success: function(data){
				$('#dentist_search_loading').css('display','none');
				if(data){
					if(data.success){
						//append search result
						$('#dentist_results').append(data.results);
					}else{
						//no results found
						alert('an error occured, please try again');
					}
				}else{
					//error
					alert('an error occured, please try again');
				}
			}
		});
	}
	function highlight_result(el,highlight){
		if(highlight){
			$(el).addClass('result_bg_highlight');
		}else{
			$(el).removeClass('result_bg_highlight');
		}
	}
	function select_dentist(dets,scheds){
		//change info details
		$('#up_details_profile').attr('href',base_url+'dentist/profile/'+dets.id);
		$('#up_details_phone').text(dets.telephone);
		$('#up_details_email').text(dets.email);
		$('#up_details_address').text(dets.address+' '+dets.city+', '+dets.state+' '+dets.zip);
		$('#input_dentist_assigned_to').val(dets.last_name+', '+dets.first_name+' '+dets.post_nominal);
		$('#input_dentist_assigned_to_id').val(dets.id);
		
		if(dets.website){
			$('#up_details_website').parent().css('display','block');
			$('#up_details_website').text(dets.website);
			$('#up_details_website').attr('href','http://'+dets.website);
		//	$('#dentist_info_container').css('min-height','276px');
		//	$('#saved_dentist_info_container').css('min-height','276px');
		}else{
			$('#up_details_website').parent().css('display','none');
			$('#up_details_website').attr('href','#');
		//	$('#dentist_info_container').css('min-height','260px');
		//	$('#saved_dentist_info_container').css('min-height','276px');
		}
		
		var adjusted_height = $('#dentist_info').height();
		$('div#dentist_info_container').css('height',adjusted_height+20);
		$('div#saved_dentist_info_container').css('height',adjusted_height+20);
		
		//change scheds
		if(scheds.mon.day){
			$('#mon_login').text(scheds.mon.login);
			$('#mon_brkout').text(scheds.mon.break_out);
			$('#mon_brkin').text(scheds.mon.break_in);
			$('#mon_logout').text(scheds.mon.logout);
		}else{
			$('#mon_login').text('- - - - - -');
			$('#mon_brkout').text('- - - - - -');
			$('#mon_brkin').text('- - - - - -');
			$('#mon_logout').text('- - - - - -');
		}
		if(scheds.tue.day){
			$('#tue_login').text(scheds.tue.login);
			$('#tue_brkout').text(scheds.tue.break_out);
			$('#tue_brkin').text(scheds.tue.break_in);
			$('#tue_logout').text(scheds.tue.logout);
		}else{
			$('#tue_login').text('- - - - - -');
			$('#tue_brkout').text('- - - - - -');
			$('#tue_brkin').text('- - - - - -');
			$('#tue_logout').text('- - - - - -');
		}
		if(scheds.wed.day){	
			$('#wed_login').text(scheds.wed.login);
			$('#wed_brkout').text(scheds.wed.break_out);
			$('#wed_brkin').text(scheds.wed.break_in);
			$('#wed_logout').text(scheds.wed.logout);
		}else{
			$('#wed_login').text('- - - - - -');
			$('#wed_brkout').text('- - - - - -');
			$('#wed_brkin').text('- - - - - -');
			$('#wed_logout').text('- - - - - -');
		}
		if(scheds.thu.day){	
			$('#thu_login').text(scheds.thu.login);
			$('#thu_brkout').text(scheds.thu.break_out);
			$('#thu_brkin').text(scheds.thu.break_in);
			$('#thu_logout').text(scheds.thu.logout);
		}else{
			$('#thu_login').text('- - - - - -');
			$('#thu_brkout').text('- - - - - -');
			$('#thu_brkin').text('- - - - - -');
			$('#thu_logout').text('- - - - - -');
		}
		if(scheds.fri.day){
			$('#fri_login').text(scheds.fri.login);
			$('#fri_brkout').text(scheds.fri.break_out);
			$('#fri_brkin').text(scheds.fri.break_in);
			$('#fri_logout').text(scheds.fri.logout);
		}else{
			$('#fri_login').text('- - - - - -');
			$('#fri_brkout').text('- - - - - -');
			$('#fri_brkin').text('- - - - - -');
			$('#fri_logout').text('- - - - - -');
		}
		if(scheds.sat.day){
			$('#sat_login').text(scheds.sat.login);
			$('#sat_brkout').text(scheds.sat.break_out);
			$('#sat_brkin').text(scheds.sat.break_in);
			$('#sat_logout').text(scheds.sat.logout);
		}else{
			$('#sat_login').text('- - - - - -');
			$('#sat_brkout').text('- - - - - -');
			$('#sat_brkin').text('- - - - - -');
			$('#sat_logout').text('- - - - - -');
		}
		if(scheds.sun.day){
			$('#sun_login').text(scheds.sun.login);
			$('#sun_brkout').text(scheds.sun.break_out);
			$('#sun_brkin').text(scheds.sun.break_in);
			$('#sun_logout').text(scheds.sun.logout);
		}else{
			$('#sun_login').text('- - - - - -');
			$('#sun_brkout').text('- - - - - -');
			$('#sun_brkin').text('- - - - - -');
			$('#sun_logout').text('- - - - - -');
		}
		//gui events
		$('#dentist_info').css('display','block');
		$.fancybox.close()
	}
	function copy_name(chk){
		if($(chk).attr('checked')){
			caller_name = $('#caller_name_field').val();;
			$('#patient_name_field').val(caller_name);
		}else{
			$('#patient_name_field').val('');
		}
	}
	function appointment_clear(chk){
		if(!$(chk).attr('checked')){
			$('input:[name=appointment_date]').val('');
			$('input:[name=appointment_time]').val('');
		}
	}
	$(function(){
		$('#last_app_date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: "-50:+0"
		});
		$('#birth_date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: "-91:+0"
		});
		$('#app_date').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			yearRange: "+0:+20"
		});
		$('#app_time').timepicker({
			ampm: true,
			hourGrid: 12,
			minuteGrid: 10,
			timeFormat: 'hh:mmtt'
		});
		
		<?php if($patient['dentist_assigned_to'] == 0){ ?>
		assign_no_dentist($('#none_checkbox'));
		<?php } ?>
	});
	function ucwords(str){
		return (str+'').replace(/^([a-z])|\s+([a-z])/g,function($1){
			return $1.toUpperCase();
		});
	}
	function edit_information(){
		$('#the_page_header').text('Edit Patient');
		$('#saved_patient_details_template').css('display','none');
		$('#add_patient_form_template').css('display','block');
		$('#appoinment_made_box').css('display','block');
		$('#notes_edit_patient').css('display','block');
		$('#notes_add_patient').css('display','none');
		$('.form_messages').css('display','none');
		$('input:[name=save_action]').val('edit');
	}
	function additional_notes(){
		alert('add notes');
	}
	function assign_no_dentist(chk){
		if($(chk).attr('checked')){
			$('#input_dentist_assigned_to').val('');
			$('#input_dentist_assigned_to').attr('disabled','disabled');
			$('#input_dentist_assigned_to_id').val(0);
			
			$('#recepient_emails').val('');
			
			$('#dentist_info').css('display','none');
			$('div#dentist_info_container').css('height',20);
			$('div#saved_dentist_info_container').css('height',20);
		}else{
			$('#input_dentist_assigned_to').attr('disabled','');
			$('#input_dentist_assigned_to_id').val('');
		}
	}
</script>
<div id="add_patient_form_template">
	<br/><br/>
	<label id="the_page_header" class="page_header" >
		Edit Patient
	</label><br/><br/>
	<div class="tab-content personal_info" id="tab-2">
		<div id="personal_form_messages" class="form_messages"></div>
		<form id="personal_info" action="#">
			<div id="personal_info_col_left" style="display:inline;float:left;width: 360px; border-right: 1px solid #eeeeee;">
				<h4>Patient information:</h4>
				<div class="row">
					<input type="hidden" name="save_id" value="<?=$patient['id']?>"/>
					<input type="hidden" name="pdf_file" value="<?=$patient['pdf_file']?>"/>
					<label>Caller Name:</label><br/>
					<input id="caller_name_field" class="medium_input_text txt capitalize_for_names" type="text" name="caller_name" value="<?=$patient['caller_name']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>Dental Emergency:</label><br/>
					<select name="dental_emergency" style="width: 198px">
						<option value="" <?php if($patient['dental_emergency'] == ''){echo 'selected="selected"';} ?>>
							
						</option>
						<option value="1" <?php if($patient['dental_emergency'] == '1'){echo 'selected="selected"';} ?>>
							YES
						</option>
						<option value="0" <?php if($patient['dental_emergency'] == '0'){echo 'selected="selected"';} ?>>
							NO
						</option>
					</select>
				</div><!-- /row end -->
				<div class="row">
					<label>Phone Number:</label><br/>
					<input class="medium_input_text txt" type="text" name="phone" value="<?=$patient['phone']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>Pain Level (0-10):</label><br/>
					<select name="pain_level" style="width: 198px">
						<option value="" <?php if($patient['pain_level'] == ''){echo 'selected="selected"';} ?>>
							
						</option>
						<option value="0" <?php if($patient['pain_level'] == '0'){echo 'selected="selected"';} ?>>0 - No Pain</option>
						<option value="1" <?php if($patient['pain_level'] == '1'){echo 'selected="selected"';} ?>>1</option>
						<option value="2" <?php if($patient['pain_level'] == '2'){echo 'selected="selected"';} ?>>2</option>
						<option value="3" <?php if($patient['pain_level'] == '3'){echo 'selected="selected"';} ?>>3</option>
						<option value="4" <?php if($patient['pain_level'] == '4'){echo 'selected="selected"';} ?>>4</option>
						<option value="5" <?php if($patient['pain_level'] == '5'){echo 'selected="selected"';} ?>>5 - Moderate Pain</option>
						<option value="6" <?php if($patient['pain_level'] == '6'){echo 'selected="selected"';} ?>>6</option>
						<option value="7" <?php if($patient['pain_level'] == '7'){echo 'selected="selected"';} ?>>7</option>
						<option value="8" <?php if($patient['pain_level'] == '8'){echo 'selected="selected"';} ?>>8</option>
						<option value="9" <?php if($patient['pain_level'] == '9'){echo 'selected="selected"';} ?>>9</option>
						<option value="10" <?php if($patient['pain_level'] == '10'){echo 'selected="selected"';} ?>>10 - Severe Pain</option>
					</select>
				</div><!-- /row end -->
				<div class="row">
					<label>Patient Name: <input onchange="copy_name(this)" type="checkbox"> <i style="color:#00796b;">Same as caller</i></label><br/>
					<input class="medium_input_text txt capitalize_for_names" type="text" id="patient_name_field" name="patient_name" value="<?=$patient['patient_name']?>" />
				</div><!-- /row end -->
				<div class="row">
					<div id="dentist_info_container">
						<label id="label_dentist_assigned_to">Dentist Assigned to: <input onchange="assign_no_dentist(this)" <?php if($patient['dentist_assigned_to'] == 0){ echo 'checked="checked"'; }?> style="margin-top: 0px;" id="none_checkbox" type="checkbox"><i style="color:#00796b;">None</i></label><br/>
						<input id="input_dentist_assigned_to" onfocus="open_search(this)" readonly="readonly" class="medium_input_text txt input_dentist_field" type="text" value="<?=@$dentist['last_name']?>, <?=@$dentist['first_name']?> <?=@$dentist['post_nominal']?>" />
						<input id="input_dentist_assigned_to_id" name="dentist_assigned_to" type="hidden" value="<?=$patient['dentist_assigned_to']?>"/>
						
						<div id="dentist_info" <?php if($patient['dentist_assigned_to'] == 0){ ?> style="display:none;" <?php } ?>>
							<div id="dentist_info_view">
								<img src="<?=base_url()?>assets/images/admin/bullet_go.png" /><a target="_blank" href="<?=base_url()?>dentist/profile/<?=@$dentist['user_id']?>" id="up_details_profile">View dentist profile</a>
							</div>
							<div id="info_details">
								<p>Phone: <label id="up_details_phone"><?=@$dentist['telephone']?></label></p>
								<p>Email: <label id="up_details_email"><?=@$dentist['email']?></label></p>
								<p>Address: <label id="up_details_address"><?=@$dentist['address']?> <?=@$dentist['city']?>, <?=@$dentist['state']?> <?=@$dentist['zip']?></label></p>
								<?php if(@$dentist['website']){ ?>
									<p>Website: <a id="up_details_website" target="_blank" href="http://<?=@$dentist['website']?>"><?=@$dentist['website']?></a></p>
								<?php } ?>
							</div>
							<div id="hours_info">
								<table cellspacing="0" cellpadding="0">
									<tr>
										<td width="65" class="no_bg"></td>
										<td width="63" class="no_bg table_header">Login</td>
										<td width="63" class="no_bg table_header">Break-Out</td>
										<td width="63" class="no_bg table_header">Break-In</td>
										<td width="63" class="no_bg table_header">Logout</td>
									</tr>
									<tr>
										<td class="no_bg">Monday</td>
										<td id="mon_login" ><?=@alt_echo($scheds['mon']['login'],'- - - - - -')?></td>
										<td id="mon_brkout"><?=@alt_echo($scheds['mon']['break_out'],'- - - - - -')?></td>
										<td id="mon_brkin"><?=@alt_echo($scheds['mon']['break_in'],'- - - - - -')?></td>
										<td id="mon_logout"><?=@alt_echo($scheds['mon']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Tuesday</td>
										<td id="tue_login" class="alt_bg"><?=@alt_echo($scheds['tue']['login'],'- - - - - -')?></td>
										<td id="tue_brkout" class="alt_bg"><?=@alt_echo($scheds['tue']['break_out'],'- - - - - -')?></td>
										<td id="tue_brkin" class="alt_bg"><?=@alt_echo($scheds['tue']['break_in'],'- - - - - -')?></td>
										<td id="tue_logout" class="alt_bg"><?=@alt_echo($scheds['tue']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Wednesday</td>
										<td id="wed_login"><?=@alt_echo($scheds['wed']['login'],'- - - - - -')?></td>
										<td id="wed_brkout"><?=@alt_echo($scheds['wed']['break_out'],'- - - - - -')?></td>
										<td id="wed_brkin"><?=@alt_echo($scheds['wed']['break_in'],'- - - - - -')?></td>
										<td id="wed_logout"><?=@alt_echo($scheds['wed']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Thursday</td>
										<td id="thu_login" class="alt_bg"><?=@alt_echo($scheds['thu']['login'],'- - - - - -')?></td>
										<td id="thu_brkout" class="alt_bg"><?=@alt_echo($scheds['thu']['break_out'],'- - - - - -')?></td>
										<td id="thu_brkin" class="alt_bg"><?=@alt_echo($scheds['thu']['break_in'],'- - - - - -')?></td>
										<td id="thu_logout" class="alt_bg"><?=@alt_echo($scheds['thu']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Friday</td>
										<td id="fri_login"><?=@alt_echo($scheds['fri']['login'],'- - - - - -')?></td>
										<td id="fri_brkout"><?=@alt_echo($scheds['fri']['break_out'],'- - - - - -')?></td>
										<td id="fri_brkin"><?=@alt_echo($scheds['fri']['break_in'],'- - - - - -')?></td>
										<td id="fri_logout"><?=@alt_echo($scheds['fri']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Saturday</td>
										<td id="sat_login" class="alt_bg"><?=@alt_echo($scheds['sat']['login'],'- - - - - -')?></td>
										<td id="sat_brkout" class="alt_bg"><?=@alt_echo($scheds['sat']['break_out'],'- - - - - -')?></td>
										<td id="sat_brkin" class="alt_bg"><?=@alt_echo($scheds['sat']['break_in'],'- - - - - -')?></td>
										<td id="sat_logout" class="alt_bg"><?=@alt_echo($scheds['sat']['logout'],'- - - - - -')?></td>
									</tr>
									<tr>
										<td class="no_bg">Sunday</td>
										<td id="sun_login"><?=@alt_echo($scheds['sun']['login'],'- - - - - -')?></td>
										<td id="sun_brkout"><?=@alt_echo($scheds['sun']['break_out'],'- - - - - -')?></td>
										<td id="sun_brkin"><?=@alt_echo($scheds['sun']['break_in'],'- - - - - -')?></td>
										<td id="sun_logout"><?=@alt_echo($scheds['sun']['logout'],'- - - - - -')?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div><!-- /row end -->
				<div class="row">
					<label>Fear of Dentist:</label><br/>
					<select name="fear_of_dentist" style="width: 198px">
						<option value="" <?php if($patient['fear_of_dentist'] == ''){echo 'selected="selected"';} ?>>
							
						</option>
						<option value="1" <?php if($patient['fear_of_dentist'] == '1'){echo 'selected="selected"';} ?>>
							YES
						</option>
						<option value="0" <?php if($patient['fear_of_dentist'] == '0'){echo 'selected="selected"';} ?>>
							NO
						</option>
					</select>
				</div><!-- /row end -->
				<div class="row">
					<label>Last Appointment Date:</label><br/>
					<input id="last_app_date" class="small_input_text txt input_date_field" value="<?=date_output($patient['last_appointment_date'])?>" type="text" name="last_appointment_date" />
				</div><!-- /row end -->
				<div class="row">
					<label>Date of Birth:</label><br/>
					<input id="birth_date" class="small_input_text txt input_date_field" value="<?=date_output($patient['birth_day'])?>" type="text" name="birth_day" />
				</div><!-- /row end -->
				<div class="row">
					<label>Address:</label><br/>
					<input class="semi_wide_input_text txt" type="text" name="address" value="<?=$patient['address']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>City:</label><br/>
					<input class="semi_wide_input_text txt city_zip_autocomplete {autoc_width:335,autoc_type:'city_name'}" type="text" name="city" value="<?=$patient['city']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>State:</label><br/>
					<input class="semi_wide_input_text txt city_zip_autocomplete {autoc_width:335,autoc_type:'state'}" name="state" value="<?=$patient['state']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>Zip:</label><br/>
					<input class="medium_input_text txt city_zip_autocomplete {autoc_width:194,autoc_type:'zip'}" type="text" name="zip" value="<?=$patient['zip']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>Email Address:</label><br/>
					<input class="medium_input_text txt" type="text" name="email" value="<?=$patient['email']?>" />
				</div><!-- /row end -->
				<div class="row">
					<label>Office Contact:</label><br/>
					<input class="medium_input_text txt" type="text" name="office_contact" value="<?=$patient['office_contact']?>" />
				</div><!-- /row end -->
				<div class="row saved_readonly" id="appoinment_made_box">
					<input type="checkbox" onchange="appointment_clear(this)" <?php if($patient['appointment_time']){ echo 'checked="checked"';}?> name="appointment_made"> <label style="font-weight:bold;">Appointment Made</label><br/><br/>
					<div class="appointment_field_containers">
						<label>Appointment Date:</label><br/>
						<input id="app_date" onchange="check_appointment()" <?php if($patient['appointment_time']){ echo 'value="'.date_output($patient['appointment_date']).'"';}?> class="small_input_text txt input_date_field" type="text" name="appointment_date" /><br/>
					</div>
					<div class="appointment_field_containers">
						<label>Appointment time:</label><br/>
						<input id="app_time" onchange="check_appointment()" <?php if($patient['appointment_time']){ echo 'value="'.$patient['appointment_time'].'"';}?> class="small_input_text" type="text" name="appointment_time" readonly="readonly" />
					</div>
					<div class="clear_both" style="clear:both;"></div>
				</div>
			</div>
			<div id="personal_info_col_right" style="display:inline;float:left; padding-left: 20px;height: auto;">
				<div id="notes_add_patient">
					<h4>Notes:</h4>
					<div class="row">
						<textarea rows="38" cols="63" class="wysiwyg_text" name="notes"><?=$patient['notes']?></textarea>
					</div><!-- /row end --><br>
				</div>
				<div id="notes_edit_patient">
					<h4>Notes:</h4>
					<div class="row" id="saved_notes_edit" style="width: 530px;">
						<div class="row" id="saved_notes_edit_text">
							<?=$patient['notes']?>
						</div>
						<h4>Additional Notes:</h4>
						<textarea rows="10" cols="63" class="wysiwyg_text" id="additional_notes" name="additional_notes"></textarea>
					</div><!-- /row end --><br>					
				</div>
			</div>
			<div class="clear_both" style="clear:both;"></div><br><br>
			<div id="personal_info_col_bottom">
				<div class="btn-holder">
				<!--	<input class="btn03" type="reset" value="RESET" /> -->
					<input style="margin-left:0px;" id="btn_personal_info" class="btn02" type="button" value="SAVE" />
				</div><!-- /btn-holder end -->
			</div>
			<div class="clear_both" style="clear:both;"></div>
		</form>
	</div><!-- /tab-2 end -->
</div>
<a id="send_pdf_box_link" style="display:none;" href="#send_pdf_box">send pdf box</a>
<a id="dentist_search_link" style="display:none;" href="#dentist_search_box">search box</a>
<div style="display:none;">
	<div id="dentist_search_box">
		<div id="dentist_search_form">
			<h2 class="search_headers">Search Filters</h2>
			<form id="search_form">
				<div class="row">
					<label>Last Name:</label><br/>
					<input class="medium_input_text txt" type="text" name="last_name" />
				</div><!-- /row end -->
				<div class="row">
					<label>First Name:</label><br/>
					<input class="medium_input_text txt" type="text" name="first_name" />
				</div><!-- /row end -->
				<div class="row">
					<label>City:</label><br/>
					<input class="medium_input_text txt city_zip_autocomplete {autoc_width:196,autoc_type:'city_name'}" type="text" name="city" />
				</div><!-- /row end -->
				<div class="row">
					<label>State:</label><br/>
					<input class="medium_input_text txt city_zip_autocomplete {autoc_width:196,autoc_type:'state'}" type="text" name="state" />
				</div><!-- /row end -->
				<div class="row">
					<label>Zip:</label><br/>
					<input class="medium_input_text txt city_zip_autocomplete {autoc_width:196,autoc_type:'zip'}" type="text" name="zip" />
				</div><!-- /row end -->
			</form>
			<input id="btn_search_dentist" onclick="dentist_search()" class="btn02" type="button" value="SEARCH" />
		</div>
		<div id="dentist_search_result">
			<h2 class="search_headers">Search Results</h2>
			<img id="dentist_search_loading" src="<?=base_url()?>assets/images/ajax-loader.gif">
			<div id="dentist_results"></div>
		</div>
		<div class="clear_both" style="clear:both;"></div>
	</div>
	<div id="send_pdf_box">
		<form id="send_pdf">
			<div class="row" style="min-height: 88px;" id="send_pdf_box_row">
				<div style="min-height:40px;">
					<div id="send_pdf_form_messages" class="form_messages" style="margin-bottom:10px;"></div>
				</div>
				<label>Recepients: </label><label class="note">(separate emails using a comma):</label><br/>
				<input type="text" name="emails" class="semi_wide_input_text txt"/>
				<a id="pdf_download_link" href="#"><img src="<?=base_url()?>assets/images/admin/page_white_acrobat.png"/> talpolano_patient_file_123345.pdf</a>
			</div><!-- /row end -->
			<div class="clear_both" style="clear:both;"></div>
		</form>
		<div class="btn_holder" style="position:absolute; bottom: 5px; right: 0px;">
			<input onclick="$.fancybox.close()" class="btn03" type="button" value="CANCEL" />
			<input id="btn_send_pdf" onclick="" class="btn02" type="button" value="SEND" />
		</div>
	</div>
</div>