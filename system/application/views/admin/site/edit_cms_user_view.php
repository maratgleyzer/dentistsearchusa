<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#cmsuser_form_messages',true,'form#cmsuser_form','_admin_console/home/save_edit_cms_user/<?=$_admin_console['id']?>',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit CMS User
	</label><br/><br/>
	<div id="cmsuser_form_messages" class="form_messages"></div>
	<form id="cmsuser_form" class="admin_forms">
		<h4>Login Information:</h4>
		Email (Username)<br/>	
		<input type="text" readonly="readonly" class="medium_input_text" name="email" value="<?=$admin['login']?>" /><br/>
		Name<br/>	
		<input type="text" class="medium_input_text" name="name" value="<?=$admin['name']?>" /><br/><br/>
		<input type="checkbox" name="change_pass"/>Check to change password<br/><br/>
		New Password<br/>	
		<input type="password" class="medium_input_text" name="password" /><br/>
		Confirm New Password<br/>
		<input type="password" class="medium_input_text" name="ret_password" /><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
		
	</form>
</div>