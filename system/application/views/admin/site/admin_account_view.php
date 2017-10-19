<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#partner_form_messages',true,'form#partner_form','_admin_console/home/save__admin_console',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Admin Account
	</label><br/><br/>
	<div id="partner_form_messages" class="form_messages"></div>
	<form id="partner_form" class="admin_forms">
		<h4>Login Information:</h4>
		Admin login (Username)<br/>	
		<input value="<?=$login?>" type="text" class="medium_input_text" name="partner_email" /><br/>
		<br/>
		<input type="checkbox" name="change_pass"/>Check to change password<br/><br/>
		Old Password<br/>	
		<input type="password" class="medium_input_text" name="old_password" /><br/>
		New Password<br/>	
		<input type="password" class="medium_input_text" name="password" /><br/>
		Confirm New Password<br/>	
		<input type="password" class="medium_input_text" name="ret_password" /><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>