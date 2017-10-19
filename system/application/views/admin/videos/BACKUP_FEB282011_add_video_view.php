<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	
	function confirmCancel(link){
		Sexy.confirm('<h1>Cancel</h1><p>Are you sure you want to cancel and go to Video management?</p>',{onComplete: 
            function(returnvalue) {
				if(returnvalue){
					window.location.href = link.getAttribute('href');
				}
			}
        });
	}
	function save_success(){
	/*	$('form :input').each(function(){
	        switch(this.type) {
	            case 'password':
	            case 'select-multiple':
	            case 'select-one':
	            case 'text':
	            case 'textarea':
	                $(this).val('');
	                break;
	            case 'checkbox':
	            case 'radio':
	                this.checked = false;
	        }
	    });
		idContentoEdit1.document.body.innerHTML = "";
	*/
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#article_form_messages',true,'form#video_form','_admin_console/videos/save_video',false,'save_success');
		});
		$("#image_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': base_url+'_admin_console/videos/upload_image',
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
					$('#article_main_image').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'content_assets/images/'+res.file.file_name+'&width=320&height=167');
					$('#prev_image').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#image_uploadify").uploadifyCancel(q);
					$("#image_uploadify").uploadifyClearQueue();
				}
			}
		});
		$("#video_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': base_url+'_admin_console/videos/upload_video',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'video_fileQueue',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'FLV',
			'fileExt': '*.flv;',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					$('#video_image_container').empty();
					video = '<a id="flv_player" href="'+base_url+'content_assets/videos/'+res.file.file_name+'" rel="shadowbox;width=600;height=450"><img class="main_image" src="'+base_url+'user_assets/prof_images/playvid.gif" alt="image" width="320" height="167" /></a>';
					$('#video_image_container').append(video);
					Shadowbox.setup("a#flv_player"); 
					$('#video').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#video_uploadify").uploadifyCancel(q);
					$("#video_uploadify").uploadifyClearQueue();
				}
			}
		});
		$('#limit_summary').jqEasyCounter({
			'maxChars': 150,
			'maxCharsWarning': 140
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Video
	</label><br/><br/>
	<div id="article_form_messages" class="form_messages"></div>
	<form id="video_form">
		Preview Image<br>
		<input type="hidden" id="prev_image" name="image"/>
		<input type="file" id="image_uploadify" name="Filedata" /><br/>
		<img id="article_main_image" class="main_image" src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
		<div id="image_fileQueue" style="width: 320px;"></div>
		<br/><br/>
		Video<br>
		<input type="hidden" id="video" name="video"/>
		<input type="file" id="video_uploadify" name="Filedata" /><br/>
		<div id="video_image_container">
			<img id="video_image" class="main_image" src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
		</div>
		<div id="video_fileQueue" style="width: 320px;"></div>
		<br/><br/>
		Category<br/>
		<select style="width: 330px;" class="medium_input_text" name="category" />
			<option value="">- - - - - - - - - - - - - - - Select Category - - - - - - - - - - - - - - - </option>
			<?php foreach($categories AS $cat): ?>
				<option value="<?=$cat['id']?>"><?=$cat['category_title']?></option>
			<?php endforeach; ?>
		</select><br/><br/>
		Title<br/>	
		<input type="text" class="wide_input_text" name="title" /><br/><br/>
		Tags<br/>	
		<input type="text" class="wide_input_text" name="tags" /><br/><br/>
		Summary<br/>
		<textarea class="wide_input_text"  id="limit_summary" name="summary"></textarea><br/><br/>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>