<script type="text/javascript">
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
		//auto fill email to pdf recepients
		$('#recepient_emails').val(dets.email);
		
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
	function all_dentist_report(chk){
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
	$(document).ready(function() {
		$('input#btn_generate_report').click(function(){
			process_form('input#btn_generate_report','GENERATE','div#personal_form_messages',true,'form#report_form','dslisting/reports/customer_report/generate',false,'save_success_generate');
		});
		$('input#btn_preview_report').click(function(){
			process_form('input#btn_preview_report','PREVIEW','div#personal_form_messages',false,'form#report_form','dslisting/reports/customer_report/preview',false,'save_success_preview');
		});
		$("#end_date").datepicker({
			dateFormat: 'yy-mm-dd'
		})
		$("#start_date").datepicker({
			dateFormat: 'yy-mm-dd',
			onSelect: function(selDate,ins) {
				$("#end_date").datepicker('option','minDate',new Date(selDate))
			}
		})
		$('#input_dentist_assigned_to').val('');
		$('#input_dentist_assigned_to_id').val('');
		all_dentist_report($('#all_checkbox'));
	});
	function save_success_preview(obj){
		$('div#manage_table').css('display','block');
		$('table#manage_table').html(obj.report);
	}
	function save_success_generate(ret){
		$('input:[name=pdf_file]').val(ret.report);
		if(ret.format == 'pdf'){
			$('#pdf_download_link').attr('href',base_url+'dslisting/reports/download_report/'+ret.report+'/pdf');
			$('#pdf_download_link').html('<img src="'+base_url+'assets/images/admin/page_white_acrobat.png"/> '+ret.report);
		}else{
			$('#pdf_download_link').html('<img src="'+base_url+'assets/images/admin/page_white_excel.png"/> '+ret.report);
			$('#pdf_download_link').attr('href',base_url+'dslisting/reports/download_report/'+ret.report+'/xls');
		}
		$("a#send_pdf_box_link").fancybox().trigger('click');
	}
	function choose_report_type(el){
		if($(el).val() == 'weekly'){
			$('#start_date').attr('disabled','');
			$('#end_date').attr('disabled','');
		}else{
			$('#start_date').attr('disabled','disabled');
			$('#end_date').attr('disabled','disabled');
			$('#start_date').val('');
			$('#end_date').val('');
		}
	}
</script>
<style>
	#btn_preview_report{
		background-position: 0 0px !important;
	}
	div.preview_report{
		background-position: -7px 0;
		border: 1px solid #FBFBFB;
		padding-top: 5px !important;
		position: relative;
		width: 536px !important;
		margin-left: 0px !important;
		border: 1px solid #f3f3f3;
	}
	table#manage_table{
		width: 520px;
	}
</style>
<div id="add_patient_form_template">
	<br/><br/>
	<label id="the_page_header" class="page_header" >
		Generate Report
	</label><br/><br/>
	<div class="tab-content personal_info" id="tab-2">
		<div id="personal_form_messages" class="form_messages"></div>
			<form id="report_form">
			<div id="personal_info_col_left" style="display:inline;float:left;width: 360px; border-right: 1px solid #eeeeee; height: 640px;">
				<h4>Report Filters:</h4>
				<div class="row">
					<label>Report Type:</label><br/>
					<select name="report_type" style="width: 164px" onchange="choose_report_type(this)">
						<option value="weekly">
							Weekly
						</option>
						<option value="monthly">
							Monthly
						</option>
					</select>
				</div><!-- /row end -->
				<div class="row">
					<label>Start Date:</label><label style="margin-left: 120px;">End Date:</label><br/>
					<input id="start_date" class="small_input_text txt input_date_field" type="text" name="start_date" style="width:162px;background-position: 145px 1px;" /> <input style="margin-left:10px; width:162px;background-position: 145px 1px;" id="end_date" class="small_input_text txt input_date_field" type="text" name="end_date" />
				</div><!-- /row end -->
				<div class="row">
					<div id="dentist_info_container">
						<label id="label_dentist_assigned_to">Customer Report For: <input onchange="all_dentist_report(this)" style="margin-top: 0px;" id="all_checkbox" type="checkbox"><i style="color:#00796b;">All Customers</i></label><br/>
						<input id="input_dentist_assigned_to" onfocus="open_search(this)" readonly="readonly" class="medium_input_text txt input_dentist_field" type="text" style="width:337px;background-position:320px 1px;"/>
						<input id="input_dentist_assigned_to_id" name="dentist_assigned_to" type="hidden"/>
						<div id="dentist_info">
							<div id="dentist_info_view">
								<img src="<?=base_url()?>assets/images/admin/bullet_go.png" /><a target="_blank" href="#" id="up_details_profile">View dentist profile</a>
							</div>
							<div id="info_details">
								<p>Phone: <label id="up_details_phone">888 456</label></p>
								<p>Email: <label id="up_details_email">emailaddress@email.com</label></p>
								<p>Address: <label id="up_details_address">12st Address corner City State 100001</label></p>
								<p>Website: <a id="up_details_website" target="_blank" href="#">www.website.com</a></p>
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
										<td id="mon_login" >12:00am</td>
										<td id="mon_brkout">12:00am</td>
										<td id="mon_brkin">12:00am</td>
										<td id="mon_logout">12:00am</td>
									</tr>
									<tr>
										<td class="no_bg">Tuesday</td>
										<td id="tue_login" class="alt_bg">12:00pm</td>
										<td id="tue_brkout" class="alt_bg">12:00pm</td>
										<td id="tue_brkin" class="alt_bg">12:00pm</td>
										<td id="tue_logout" class="alt_bg">12:00pm</td>
									</tr>
									<tr>
										<td class="no_bg">Wednesday</td>
										<td id="wed_login">12:00pm</td>
										<td id="wed_brkout">12:00pm</td>
										<td id="wed_brkin">12:00pm</td>
										<td id="wed_logout">12:00pm</td>
									</tr>
									<tr>
										<td class="no_bg">Thursday</td>
										<td id="thu_login" class="alt_bg">12:00pm</td>
										<td id="thu_brkout" class="alt_bg">12:00pm</td>
										<td id="thu_brkin" class="alt_bg">12:00pm</td>
										<td id="thu_logout" class="alt_bg">12:00pm</td>
									</tr>
									<tr>
										<td class="no_bg">Friday</td>
										<td id="fri_login">12:00pm</td>
										<td id="fri_brkout">12:00pm</td>
										<td id="fri_brkin">12:00pm</td>
										<td id="fri_logout">12:00pm</td>
									</tr>
									<tr>
										<td class="no_bg">Saturday</td>
										<td id="sat_login" class="alt_bg">12:00pm</td>
										<td id="sat_brkout" class="alt_bg">12:00pm</td>
										<td id="sat_brkin" class="alt_bg">12:00pm</td>
										<td id="sat_logout" class="alt_bg">12:00pm</td>
									</tr>
									<tr>
										<td class="no_bg">Sunday</td>
										<td id="sun_login">12:00pm</td>
										<td id="sun_brkout">12:00pm</td>
										<td id="sun_brkin">12:00pm</td>
										<td id="sun_logout">12:00pm</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="row saved_readonly" id="appoinment_made_box" style="display:block;">
					<input checked="checked" value="pdf" type="radio" name="report_format"/> <img style="margin-bottom: -3px;" src="<?=base_url()?>assets/images/admin/page_white_acrobat.png"/> Generate PDF File &nbsp;&nbsp;&nbsp;&nbsp;
					<input value="excel" type="radio" name="report_format"/> <img style="margin-bottom: -3px;" src="<?=base_url()?>assets/images/admin/page_white_excel.png"/> Generate Excel File
				</div>
				<div class="row">
					<div class="btn_holder" style="margin-top: 20px; margin-right: 15px;">
						<input id="btn_preview_report" class="btn03" type="button" value="PREVIEW" />
						<input id="btn_generate_report" class="btn02" type="button" value="GENERATE" />
					</div>
				</div>
			</div>
			</form>
			<div id="personal_info_col_right" style="display:inline;float:left; padding-left: 20px;height: auto;">
				<div id="manage_table" class="preview_report" style="display:none;">
					<table id="manage_table"></table>
				</div>
			</div>
			<div class="clear_both" style="clear:both;"></div><br><br>
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
				<input type="text" name="emails" id="recepient_emails" class="semi_wide_input_text txt"/>
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