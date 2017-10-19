<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#sub_admin_console_form_messages',true,'form#sub_admin_console_form','_admin_console/home/save_sub__admin_console',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Sub-Admin
	</label><br/><br/>
	<div id="subadmin_form_messages" class="form_messages"></div>
	<form id="subadmin_form" class="admin_forms">
		<h4>Login Information:</h4>
		Email (Username)<br/>	
		<input type="text" class="medium_input_text" name="email" /><br/>
		Password<br/>	
		<input type="password" class="medium_input_text" name="password" /><br/>
		Confirm Password<br/>
		<input type="password" class="medium_input_text" name="ret_password" /><br/><br/>
		<h4>Privileges</h4>
		<?php foreach($privileges AS $priv){ ?>
			<input type="checkbox" value="<?=$priv['id']?>" name="privileges[]"/> <?=$priv['name']?><br>
		<?php } ?>
		<br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
		
	</form>
</div>