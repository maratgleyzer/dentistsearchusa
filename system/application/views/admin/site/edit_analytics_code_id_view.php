<script type="text/javascript">
	function save_success(){

	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#analytics_form_messages',true,'form#analytics_form','_admin_console/home/save_analytics_code_id',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Google Analytics Code ID
	</label><br/><br/>
	<div id="analytics_form_messages" class="form_messages"></div>
	<form id="analytics_form">
		Web Property ID<br/>	
		<input type="text" class="medium_input_text" name="id" value="<?=$id?>" /><br/><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>