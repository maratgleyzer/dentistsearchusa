	<script type="text/javascript">
		$(function(){
			$('input#btn_app').click(function(){
				process_form('input#btn_app','SEND','div#app_form_messages',false,'form#app_form','dentist/appointment',false,'close_appointment');
			});
			$('#last_visit').datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$('#app_date').datepicker({
				dateFormat: 'yy-mm-dd',
				changeMonth: true,
				changeYear: true
			});
			$('#preferred_time').timepicker({
				ampm: true,
				hourGrid: 12,
				minuteGrid: 10,
				timeFormat: 'hh:mmtt'
			});
		});
		function close_appointment(){
			setTimeout('remove_app_form()',3000)
		}
		function remove_app_form(){
			//close popup form
			$('#lbox05').fadeOut(400);
			_global_lightbox.fadeOut(400, function(){
				_global_fader.fadeOut(300);
				_global_scroll = false;
			});
			
			//reset form
			$(':input','#app_form')
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
			
			//reload captchh
			Recaptcha.reload();
			
			//remove form messages
			$('#app_form_messages').css('display','none');
		}
	</script>
	 <script type="text/javascript">
	  var RecaptchaOptions = { 
		theme: 'white'
	  };
	</script>
	<div id="lbox05">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">APPOINTMENT: Make an appointment</strong>
					<span class="ico03">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div id="app_form_messages" class="form_messages"></div>
				<div class="columns">
					<form id="app_form" action="#">
						<fieldset>
							<div class="c-holder">
								<div class="column">
									<div class="row">
										<label>I would like to schedule an appointment for:</label>
										<select name="appointment" class="txt" style="width:220px;">
											<option value="Myself">Myself</option>
											<option value="Myself and a Family member">Myself and a Family member</option>
											<option value="Family member only">Family member only</option>
										</select>
									</div><!-- /row end -->
									<div class="row">
										<label><span class="required_asterisk">* </span>Patient's Name:</label>
										<input class="txt" type="text" name="name" />
									</div><!-- /row end -->
									<div class="row">
										<label><span class="required_asterisk">* </span>Patient's Age:</label>
										<input type="text" name="age" style="width:70px;" />
									</div><!-- /row end -->
									<div class="row">
										<label>Patient's Oral Health:</label>
										<select name="oral_health" class="txt" style="width:220px;">
											<option value="Good">Good</option>
											<option value="Fair">Fair</option>
											<option value="Poor">Poor</option>
										</select>
									</div><!-- /row end -->
									<div class="row">
										<label>Patient's last visit to a dentist:</label>
										<img src="<?=base_url()?>assets/images/date_add.png" class="data_ico" />
										<input id="last_visit" class="txt" type="text" name="last_visit" style="width:187px;" />
									</div><!-- /row end -->
									<div class="row">
										<label>Preferred appointement date:</label>
										<img src="<?=base_url()?>assets/images/date_add.png" class="data_ico" />
										<input id="app_date" class="txt" type="text" name="app_date" style="width:187px;" />
									</div><!-- /row end -->
									<div class="row">
										<label>Preferred appointement time:</label>
										<input id="preferred_time" class="txt" class="txt" type="text" name="app_time" style="width:70px;" readonly="readonly" />
									</div><!-- /row end -->
								</div><!-- /column end -->
								<div class="column alignright">
									<div class="row">
										<label><span class="required_asterisk">* </span>Email Address:</label>
										<input class="txt" type="text" name="email" />
									</div><!-- /row end -->
									<div class="row">
										<label>Telephone:</label>
										<input class="txt" type="text" name="telephone" />
									</div><!-- /row end -->
									<div class="row">
										<label>Mobile Number:</label>
										<input class="txt" type="text" name="mobile" />
									</div><!-- /row end -->
									<div class="row">
										<label>Additional comments:</label>
										<textarea name="comments" rows="8" cols="35"></textarea>
									</div><!-- /row end -->
								</div><!-- /column alignright end -->
							</div><!-- /c-holder end -->
								<div class="capt">
									<?php
										//require_once('recaptcha/recaptcha.php');
										include('recaptcha/recaptcha.php');
										 echo recaptcha_get_html($publickey);
									?>
								</div><!-- /row end -->
							<div class="btn-holder">
								<input type="hidden" name="pid" value="<?=$id;?>" />
							<!--	<input class="close btn03" type="reset" value="CANCEL" /> -->
								<input class="btn02" id="btn_app" type="button" value="SEND" />
								<!-- <a class="vsign" href="#">veri sign</a> -->
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /columns end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div><!-- /lbox-b end -->
	</div><!-- /lbox05 end -->