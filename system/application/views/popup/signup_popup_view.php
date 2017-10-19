	<script type="text/javascript">
		$(function(){
			$('input#btn_register').click(function(){
				process_form(
					'input#btn_register','REGISTER','div#reg_form_messages',false,'form#reg_form','dentist/pre_registration',false,'close_registration');
			});
		})
		function cancel_reg_form(){
			//close popup form
			$('#lbox03').fadeOut(400);
			_global_lightbox.fadeOut(400, function(){
				_global_fader.fadeOut(300);
				_global_scroll = false;
			});
			
			//reset form
			$(':input','#reg_form')
			.not(':button, :submit, :reset, :hidden')
			.val('')
			.removeAttr('checked')
			.removeAttr('selected');
			
			//remove form messages
			$('#reg_form_messages').css('display','none');
		}
		function close_registration(){
			setTimeout('cancel_reg_form()',3000);
		}
	</script>
	<div id="lbox03">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">SIGNUP: Dentist signup form</strong>
					<span class="ico03">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div id="reg_form_messages" class="form_messages"></div>
				<div class="columns">
					<form id="reg_form" action="#">
						<fieldset>
							<div class="c-holder">
								<div class="column">
									<p><?=$signup_text['content']?></p>
								</div><!-- /column end -->
								<div class="column alignright">
									<h4>Personal Information:</h4>
									<div class="row">
										<label for="lb444"><span class="required_asterisk">* </span>Name:</label>
										<input id="lb444" class="txt" type="text" name="name" />
									</div><!-- /row end -->
									<div class="row">
										<label for="lb475">Company Name:</label>
										<input id="lb475" class="txt" type="text" name="company"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb476"><span class="required_asterisk">* </span>Phone Number:</label>
										<input id="lb476" class="txt" type="text" name="phone"/>
									</div><!-- /row end -->
									<div class="row">
										<label for="lb477"><span class="required_asterisk">* </span>Email Address:</label>
										<input id="lb477" class="txt" type="text" name="email"/>
									</div><!-- /row end -->	
									<div class="row">
										<label for="lb478"><span class="required_asterisk">* </span>Interested In:</label>
										<select name="interest" class="sel">
											<?php foreach($dropdown_choices AS $choice): ?>
											<option value="<?=$choice['id']?>"><?=$choice['value']?></option>
											<?php endforeach; ?>
										</select><br/><br/>
									</div><!-- /row end -->	
								</div><!-- /column alignright end -->
							</div><!-- /c-holder end -->
							<div class="btn-holder">
							<!--	<input class="btn03 close" type="reset" onclick="cancel_reg_form()" value="CANCEL" /> -->
								<input class="btn02" id="btn_register" type="button" value="REGISTER" />
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /columns end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div><!-- /lbox-b end -->
	</div><!-- /lbox03 end -->