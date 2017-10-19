<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#dentistsfeatured_form_messages',true,'form#dentistsfeatured_form','_admin_console/home/save_dentists_featured',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Dentists Featured
	</label><br/><br/>
	<div id="dentistsfeatured_form_messages" class="form_messages"></div>
	<form id="dentistsfeatured_form" class="admin_forms">
		Select the number of dentists to feature on each search page.<br />
		Selecting 'None/Disable' will disable the featured dentist widget<br />
		and no featured dentists will be displayed:<br /><br />
		<select name="dentists_featured">
		<option value="0"<?php echo ($dentists_featured == 0 ? ' selected' : ''); ?>>None/Disable</option>
		<option value="1"<?php echo ($dentists_featured == 1 ? ' selected' : ''); ?>>1 Dentist</option>
		<option value="2"<?php echo ($dentists_featured == 2 ? ' selected' : ''); ?>>2 Dentists</option>
		<option value="3"<?php echo ($dentists_featured == 3 ? ' selected' : ''); ?>>3 Dentists</option>
		<option value="4"<?php echo ($dentists_featured == 4 ? ' selected' : ''); ?>>4 Dentists</option>
		<option value="5"<?php echo ($dentists_featured == 5 ? ' selected' : ''); ?>>5 Dentists</option>
		<option value="6"<?php echo ($dentists_featured == 6 ? ' selected' : ''); ?>>6 Dentists</option>
		<option value="7"<?php echo ($dentists_featured == 7 ? ' selected' : ''); ?>>7 Dentists</option>
		<option value="8"<?php echo ($dentists_featured == 8 ? ' selected' : ''); ?>>8 Dentists</option>
		<option value="9"<?php echo ($dentists_featured == 9 ? ' selected' : ''); ?>>9 Dentists</option>
		</select><br/><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
		
	</form>
</div>