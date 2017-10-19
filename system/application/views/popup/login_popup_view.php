	<script type="text/javascript">
		$(function(){
			$('input#btn_forgot_send').click(function(){
				process_form('input#btn_forgot_send','SEND','div#forgot_password_form_messages',false,'form#forgot_password_form','dentist/forgot_password');
			});
			$('input#btn_login').click(function(){
				process_form('input#btn_login','LOGIN','div#login_form_messages',false,'form#login_form','dentist/login','dashboard/');
			});
		})
		function close_login(){
			$('#lbox02').fadeOut(400);
		}
	</script>
	<div id="lbox02">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">LOGIN: Dentist Login</strong>
					<span class="ico02">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div class="form_messages" id="login_form_messages"></div>
				<div class="form-holder">
					<form id="login_form" action="#">
						<fieldset>
							<div class="row">
								<div class="col">
									<label for="lb40">Email:</label>
									<input id="lb40" tabindex="1" name="email" class="txt" type="text" />
									<div class="check-h">
										<input id="lb43" tabindex="4" class="chk" type="checkbox" name="remember_me" id="remember" value="true" />
										<label for="lb43">Remember me</label>
									</div>
								</div>
								<div class="col alignright">
									<label for="lb41">Password:</label>
									<input id="lb41" tabindex="2" class="txt" type="password" name="password"/>
									<div class="check-h">
										<label><a class="open-popup" href="#lbox07" onclick="close_login()">Forgot Password</a></label>
									</div>
								</div>
							</div><!-- /row end -->
							<div class="btn-holder">
							<!--	<input class="btn03 close" type="button" value="CANCEL" /> -->
								<input id="btn_login" tabindex="3" class="btn02" type="button" value="LOGIN" />
								
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /form-holder end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div>
	</div><!-- /lbox02 end -->
	
	<!-- FORGOT PASSWORD -->
	<div id="lbox07">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">LOGIN: Forgot Password</strong>
					<span class="ico02">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div class="form_messages" id="forgot_password_form_messages"></div>
				<div class="form-holder">
					<form id="forgot_password_form" action="#">
						<fieldset>
							<div class="row">
								<div class="col">
									<p style="font-size: 12px; padding-right: 20px; border-right:1px solid #e9eaef;">Please enter your email address. An email will be sent to your email address containing a link to change your password.</p>
								</div>
								
								<div class="col alignright" style="width: 254px;">
									<label>Email Address :</label>
									<input name="email" class="txt" type="text" style="width:244px;" />
								</div>
							</div><!-- /row end -->
							<div class="btn-holder">
							<!--	<input class="btn03 close" type="button" value="CANCEL" /> -->
								<input id="btn_forgot_send" tabindex="3" class="btn02" type="button" value="SEND" />
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /form-holder end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div>
	</div><!-- /lbox02 end -->