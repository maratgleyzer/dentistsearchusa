<script type="text/javascript">
	function save_success(){

	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#search_result_text_form_messages',true,'form#search_result_text_form','_admin_console/home/save_search_result_text',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Search Result Text
	</label><br/><br/>
	<div id="search_result_text_form_messages" class="form_messages"></div>
	<form id="search_result_text_form">
		Title <label class="form_description">(custom tag: %searchname%)</label><br/>
		<input type="text" class="wide_input_text" name="title" value="<?=$title?>" /><br/><br/>
		Text <br/>
		<textarea class="wide_input_text" rows="5" name="text" /><?=$text?></textarea><br/><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>