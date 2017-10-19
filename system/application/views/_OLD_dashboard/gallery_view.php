<script type="text/javascript">
$(document).ready(function() {
	$('input#btn_gallery').click(function(){
		process_form('input#btn_gallery','SAVE','div#gallery_form_messages',false,'form#gallery_form','dashboard/save_dashboard_info');
	});
	$("#gallery_uploadify").uploadify({
		'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
		'script': '<?=base_url()?>dashboard/upload_image/',
		'cancelImg': '<?=base_url()?>assets/images/cancel.png',
		'queueID': 'gallery_fileQueue',
		'method': 'POST',
		'auto': true,
		'scriptData': {'up_key':"<?=$logged_key?>"},
		'multi': true,
		'fileDesc':'PNG; JPEG;',
		'fileExt': '*.png;*.jpeg;*.jpg;',
		'onComplete': function(e,q,o,r){
			res = jQuery.parseJSON(''+r+'');
			if(res.success){
				var new_file = ''
					+'<tr>'
						+'<td><a rel="gal_groupbtn1" class="image_preview" href="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/images/'+res.file.file_name+'&width=800&height=600"><img alt="type" src="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/images/'+res.file.file_name+'&width=40&height=40" /></a></td>'
						+'<td>'+res.file.orig_name+'</td>'
						+'<td>'
							+'<a rel="gal_groupbtn2" class="image_preview" href="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/images/'+res.file.file_name+'&width=800&height=600"><img alt="download" class="icons" src="'+base_url+'assets/themes/default/images/page_white_magnify.png" /></a>'
							+'<img style="cursor:pointer;" onclick="delete_image(this,'+res.file.file_id+')" alt="delete" class="icons" src="'+base_url+'assets/themes/default/images/cross.png" />'
						+'</td>'
					+'</tr>';
				$('#gallery_no_image').remove();
				$('#gallery_row_header').css({'display':'table-row'});
				$('#gallery_grid_table').append(new_file);
				$(".image_preview").fancybox({
					'titleShow'     : false,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic'
				});
			}else{
				Sexy.error('<h1>Upload error</h1>'+res.message);
				$("#gallery_uploadify").uploadifyCancel(q);
				$("#gallery_uploadify").uploadifyClearQueue();
			}
		}
	});
	$(".image_preview").fancybox({
		'titleShow'     : false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	})
});
function delete_image(el,id){
	Sexy.confirm('<h1>Delete Image?</h1><p>Are you sure you want to delete this image?</p>',{onComplete: 
		function(returnvalue) {
			if(returnvalue){
				$.ajax({
					url: base_url+'dashboard/delete_image/'+id,
					success: function(data) {
						$(el).parent().parent().remove();
					}
				});
			}
		}
	});
}
</script>
<div class="tab-content documents_tab" id="tab-6">
	<div id="gallery_form_messages" class="form_messages"></div>
	<div id="gallery-col-left">
		<form id="gallery_form" action="#">
			<h4 class="default">Introduction Text</h4>
			<input type="hidden" name="field" value="gallery_intro"/>
			<textarea cols="38" rows="8" name="content" class="wysiwyg_text">
				<?=$dashboard_info['gallery_intro']?>
			</textarea>
			<div class="btn-holder" style="margin-right: 10px; margin-top: 10px;">
				<input id="btn_gallery" class="btn02" type="button" value="SAVE" />
				<input class="btn03" type="reset" value="RESET" />
			</div><!-- /btn-holder end -->
		</form>
	</div>
	<div id="gallery-col-right">
		<h4 class="default">Add Image</h4>
		<form action="#">
			<div class="row">
				<label>Upload Images:</label><br/>
				<input class="text" type="file" name="gallery_uploadify" id="gallery_uploadify" />
			</div>
		</form>
	</div>
	<div class="clear_both"></div>
	<br/>
	<div id="gallery_fileQueue"></div>
	<br/>
	<h4 class="default">Manage Gallery</h4>
	<table class="grid_table" id="gallery_grid_table">
		<tr id="gallery_row_header" class="header <?php if(!$images){ echo 'hide';} ?>">
			<td width="6%">Preview</td>
			<td width="84%">Filename</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$images){ ?>
			<tr id="gallery_no_image">
				<td colspan="3"> No available image in the gallery</td>
			</tr>
		<?php } ?>
		<?php foreach($images AS $image): ?>
			<tr>
				<td><a rel="gal_groupbtn1" class="image_preview" href="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/images/<?=$image['path']?>&width=800&height=600"><img alt="type" src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/images/<?=$image['path']?>&width=40&height=40" /></a></td>
				<td><?=$image['filename']?></td>
				<td>
					<a rel="gal_groupbtn2" class="image_preview" href="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/images/<?=$image['path']?>&width=800&height=600"><img alt="download" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" /></a>
					<img style="cursor:pointer;" onclick="delete_image(this,<?=$image['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div><!-- /tab-5 end -->