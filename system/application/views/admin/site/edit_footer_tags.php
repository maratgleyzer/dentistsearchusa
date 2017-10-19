<script type="text/javascript">	
	function save_success(){
		
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#footertag_form_messages',true,'form#footertag_form','_admin_console/home/save_footer_tags',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Footer Tags
	</label><br/><br/>
	<div id="footertag_form_messages" class="form_messages"></div>
	<form id="footertag_form" class="admin_forms">
		Tags:<br/>	
		<textarea class="wide_input_text" name="footer_tags"><?php echo $footer_tags; ?></textarea><br/><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
		
	</form>
</div>