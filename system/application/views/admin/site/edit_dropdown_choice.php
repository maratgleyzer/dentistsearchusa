<script type="text/javascript">
	function save_success(){

	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#dropdown_form_messages',true,'form#dropdown_form','_admin_console/home/save_dropdown_choice/<?=$edit?>',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Dropdown Choice
	</label><br/><br/>
	<div id="dropdown_form_messages" class="form_messages"></div>
	<form id="dropdown_form">
		Dropdown Value<br/>	
		<input type="text" class="medium_input_text" name="value" value="<?=$value['value']?>"/><br/><br/><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>