<script type="text/javascript">
	$(function(){
		$('.wysiwyg_text').wysiwyg();
		$('input#btn_promo').click(function(){
			process_form('input#btn_promo','SAVE','div#promo_form_messages',true,'form#promo_form','dashboard/save_dashboard_info');
		});
	})
</script>
<div class="tab-content" id="tab-4">
	<div id="promo_form_messages" class="form_messages"></div>
	<div id="promo_instructions">
		<h4 class="default">Promotional Page:</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed urna libero, dapibus at consequat eu, tempus sed elit. Donec enim lacus, dapibus quis euismod eget, suscipit id libero. Sed urna libero, dapibus at consequat eu, tempus sed elit. Donec enim lacus, dapibus quis euismod eget, suscipit id libero. 
			
		</p>
	</div>
	<form action="#" id="promo_form">
		<div id="promo_textarea">
			<input type="hidden" name="field" value="promotional"/>
			<textarea rows="39" cols="52" class="wysiwyg_text" name="content">
				<?=$dashboard_info['promotional']?>
			</textarea>
		</div>
		<div id="promo_bottom">
			<div class="btn-holder">
				<input id="btn_promo" class="btn02" type="button" value="SAVE" />
				<input class="btn03" type="reset" value="RESET" />
			</div><!-- /btn-holder end -->
		</div>
		<div class="clear_both"></div>
	</form>
</div><!-- /tab-2 end -->