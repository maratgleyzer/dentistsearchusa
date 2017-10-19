<script type="text/javascript">Shadowbox.init();</script>
<script type="text/javascript">
	function preview_loaded(){
		$('img.video_play_image').css('display','block');
		$('#youtube_video_preview .video_size_container').removeClass('video_container_preloader');
		Shadowbox.setup("a.flv_player"); 
	}
	function change_video_type(el){
		if($(el).val() == 'flv'){
			$('#flv_upload_cont').css('display','block');
			$('#youtube_vid_cont').css('display','none');
		}else{
			$('#flv_upload_cont').css('display','none');
			$('#youtube_vid_cont').css('display','block');
		}
	}
	function get_youtube_video(){
		$('div#youtube_video_preview .video_size_container').empty();
		$('div.video_container').css('display','block');
		$('#youtube_video_preview .video_size_container').addClass('video_container_preloader');
		var link_val = $("#youtube_link").val();
		$.ajax({
			url: base_url+'_admin_console/videos/youtube_vid',
			type: 'POST',
			dataType: 'json',
			data: {link:link_val},
			success: function(data){
				if(data){
					if(data.success){
						$('#youtube_video').val(data.video_url);
						$('#youtube_preview').val(data.preview_image);
					}else{
						$('#youtube_video').val('');
						$('#youtube_preview').val('');
					}
					$('#youtube_video_preview .video_size_container').html(data.content);
				}
			}
		})
	}
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
		$('input[name="video_type"]').val(['flv']);
		$("#youtube_link").bind('paste',function(e){
			setTimeout(function(){
				get_youtube_video();
			},100);
		});
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
					video = '<div class="youtube_image_mask">'
						+'<img class="main_image" src="'+base_url+'content_assets/images/'+res.preview_image+'" alt="image"/>'
						+'<a id="flv_player" href="'+base_url+'content_assets/videos/'+res.file.file_name+'" rel="shadowbox;width=600;height=450">'
							+'<img style="display:block;" src="'+base_url+'assets/themes/default/images/video_play.png" class="video_play_image"/>'
						+'</a>'
						+'</div>';
					
					$('#video_image_container').append(video);
					Shadowbox.setup("a#flv_player"); 
					$('#flv_video').val(res.file.file_name);
					$('#flv_preview').val(res.preview_image);
					console.log(res.file);
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
	<!--	
		Preview Image<br>
		<input type="hidden" id="prev_image" name="image"/>
		<input type="file" id="image_uploadify" name="Filedata" /><br/>
		<img id="article_main_image" class="main_image" src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
		<div id="image_fileQueue" style="width: 320px;"></div>
		<br/><br/> 
	-->
		Video Type<br>
		<input type="radio" onchange="change_video_type(this)" name="video_type" value="flv"/><label style="color:gray;">FLV</label> 
		<input type="radio" onchange="change_video_type(this)" name="video_type" value="youtube"/><label style="color:gray;">YouTube</label><br/><br/>
		Video<br>
		<div id="flv_upload_cont">
			<input type="hidden" id="flv_video" name="flv_video"/>
			<input type="hidden" id="flv_preview" name="flv_preview"/>
			<input type="file" id="video_uploadify" name="Filedata" /><br/>
			<div id="video_image_container">
				<img id="video_image" class="main_image" src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
			</div>
			<div id="video_fileQueue" style="width: 320px;"></div>
		</div>
		<div id="youtube_vid_cont" style="display:none;">
			<label style="color:gray;">Paste YouTube URL <i>e.g.(http://www.youtube.com/watch?v=txqiwrbYGrs)</i></label><br/>
			<input type="hidden" id="youtube_video" name="youtube_video"/>
			<input type="hidden" id="youtube_preview" name="youtube_preview"/>
			<input type="text" class="wide_input_text" id="youtube_link"/>
			<div class="video_container" id="youtube_video_preview">
				<div class="video_size_container">
				
				</div>
			</div>
		</div>
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