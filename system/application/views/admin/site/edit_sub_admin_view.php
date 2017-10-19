<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#sub_admin_console_form_messages',true,'form#sub_admin_console_form','_admin_console/home/save_edit_sub__admin_console/<?=$_admin_console['id']?>',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Sub-Admin
	</label><br/><br/>
	<div id="subadmin_form_messages" class="form_messages"></div>
	<form id="subadmin_form" class="admin_forms">
		<h4>Login Information:</h4>
		Email (Username)<br/>	
		<input type="text" readonly="readonly" class="medium_input_text" name="email" value="<?=$admin['login']?>" /><br/><br/>
		<input type="checkbox" name="change_pass"/>Check to change password<br/><br/>
		New Password<br/>	
		<input type="password" class="medium_input_text" name="password" /><br/>
		Confirm New Password<br/>
		<input type="password" class="medium_input_text" name="ret_password" /><br/>
		<h4>Privileges</h4>
		<?php foreach($privileges AS $priv){ ?>
			<?php 
				$checked = NULL;
				foreach($user_privileges AS $user_priv){ 
					if($user_priv['privilege_id'] == $priv['id']){
						$checked = 'checked="checked"';
					}
				} ?>
				<input type="checkbox" <?=$checked?> value="<?=$priv['id']?>" name="privileges[]"/> <?=$priv['name']?><br>
		<?php } ?>
		<br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
		
	</form>
</div>