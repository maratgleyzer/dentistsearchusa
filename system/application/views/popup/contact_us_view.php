	<script type="text/javascript">
		$(function(){
			$('input#btn_contact').click(function(){
				process_form('input#btn_contact','SEND','div#contact_form_messages',false,'form#contact_form','contact','');
			});
		})
	</script>
	<div id="lbox04">
		<div class="lbox">
			<div class="lbox-h">
				<div class="box-heading">
					<a class="close" href="#">close</a>
					<strong class="ttl">CONTACT: Contact Us</strong>
					<span class="ico03">&nbsp;</span>
				</div><!-- /box-heading end -->
				<div id="contact_form_messages" class="form_messages"></div>
				<div class="columns">
					<form id="contact_form" action="#">
						<fieldset>
							<div class="c-holder">
								<div class="column">
									<div class="row">
										<label>First Name:</label>
										<input class="txt" type="text" name="fname" />
									</div><!-- /row end -->
									<div class="row">
										<label>Last Name:</label>
										<input class="txt" type="text" name="lname" />
									</div><!-- /row end -->
									<div class="row">
										<label>Email Address:</label>
										<input class="txt" type="text" name="email"/>
									</div><!-- /row end -->
								</div><!-- /column end -->
								<div class="column alignright">
									<div class="row">
										<label>Message:</label>
										<textarea name="msg" rows="8" cols="35"></textarea>
									</div><!-- /row end -->
								</div><!-- /column alignright end -->
							</div><!-- /c-holder end -->
							<div class="btn-holder">
								<input type="hidden" name="type_c" value="0" />
							<!--	<input class="close btn03" type="button" value="CANCEL"/> -->
								<input class="btn02" id="btn_contact" type="button" value="SEND" />
								<!-- <a class="vsign" href="#">veri sign</a> -->
							</div><!-- /btn-holder end -->
						</fieldset>
					</form>
				</div><!-- /columns end -->
			</div><!-- /lbox-h end -->
		</div><!-- /lbox end -->
		<div class="lbox-b"></div><!-- /lbox-b end -->
	</div><!-- /lbox04 end -->