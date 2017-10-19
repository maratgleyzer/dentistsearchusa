<script type="text/javascript">
	function save_success(){

	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#icon_form_messages',true,'form#icon_form','_admin_console/advertisements/save_footer_ad/<?=$id?>',false,'save_success');
		});
		$("#image_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>_admin_console/advertisements/upload_footer_image',
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
					$('#icon_image').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'assets/images/advertisements/'+res.file.file_name+'&width=211&height=96');
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
		Edit Footer Ad
	</label><br/><br/>
	<div id="icon_form_messages" class="form_messages"></div>
	<form id="icon_form">
		Image (220 x 96 pixels)<br>
		<input type="hidden" id="prev_image" value="<?=$image?>" name="image"/>
		<input type="file" id="image_uploadify" name="Filedata" /><br/>
		<?php if($image){ ?>
			<img id="icon_image" class="main_image" src="<?=base_url();?>assets/images/advertisements/<?=$image?>" alt="image" width="220" height="96" /> 
		<?php }else{ ?>
			<img id="icon_image" class="main_image" src="<?=base_url();?>assets/images/advertisements/no_footer_ads.png" width="220" height="96" /> 
		<?php } ?>
		<div id="image_fileQueue" style="width: 320px;"></div>
		<br/>
		Link<br/>	
		<input type="text" class="wide_input_text" name="links" value="<?=$links?>" /><br/><br/>
		Title<br/>	
		<input type="text" class="wide_input_text" name="title" value="<?=$title?>" /><br/><br/>
		Text<br/>	
		<input type="text" class="wide_input_text" name="text" value="<?=$text?>" /><br/><br/>
		Align<br/>
		<select name="align"><option value="">Select</option><option value="left"<?=($align == 'left' ? ' selected' : '');?>>Left</option><option value="right"<?=($align == 'right' ? ' selected' : '');?>>Right</option></select><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>