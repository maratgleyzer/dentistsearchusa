<script type="text/javascript">
	function save_success(){

	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#icon_form_messages',true,'form#icon_form','_admin_console/home/save_icon',false,'save_success');
		});
		$("#image_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>_admin_console/home/upload_icon',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'image_fileQueue',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'PNG; JPEG;',
			'fileExt': '*.png;*.jpeg;*.jpg;',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					$('#icon_image').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'assets/images/social_media_icons/'+res.file.file_name+'&width=20&height=20');
					$('#prev_image').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#image_uploadify").uploadifyCancel(q);
					$("#image_uploadify").uploadifyClearQueue();
				}
			}
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Social Media Icon
	</label><br/><br/>
	<div id="icon_form_messages" class="form_messages"></div>
	<form id="icon_form">
		Icon (20 x 20 pixels)<br>
		<input type="hidden" id="prev_image" value="" name="image"/>
		<img id="icon_image" class="main_image" src="<?=base_url();?>assets/images/admin/icon_blank.png" alt="image" width="20" height="20" /> <input type="file" id="image_uploadify" name="Filedata" />
		<div id="image_fileQueue" style="width: 320px;"></div>
		<br/>
		Link<br/>	
		<input type="text" class="wide_input_text" name="link" /><br/><br/>
		Tooltip<br/>	
		<input type="text" class="wide_input_text" name="tooltip" /><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>