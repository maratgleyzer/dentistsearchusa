<script type="text/javascript">
$(document).ready(function() {
	$("#certifications_uploadify").uploadify({
		'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
		'script': '<?=base_url()?>dashboard/upload_certification/',
		'cancelImg': '<?=base_url()?>assets/images/cancel.png',
		'queueID': 'certifications_fileQueue',
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
						+'<td><a rel="cert_groupbtn1" class="image_preview" href="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/certifications/'+res.file.file_name+'&width=800&height=600"><img alt="type" src="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/certifications/'+res.file.file_name+'&width=40&height=40" /></a></td>'
						+'<td>'+res.file.orig_name+'</td>'
						+'<td>'
							+'<a rel="cert_groupbtn2" class="image_preview" href="'+base_url+'assets/phpthumb/resize.php?src='+base_url+'user_assets/certifications/'+res.file.file_name+'&width=800&height=600"><img alt="download" class="icons" src="'+base_url+'assets/themes/default/images/page_white_magnify.png" /></a>'
							+'<img style="cursor:pointer;" onclick="delete_certification(this,'+res.file.file_id+')" alt="delete" class="icons" src="'+base_url+'assets/themes/default/images/cross.png" />'
						+'</td>'
					+'</tr>';
				$('#certifications_no_image').remove();
				$('#certifications_row_header').css({'display':'table-row'});
				$('#certifications_grid_table').append(new_file);
				$(".image_preview").fancybox({
					'titleShow'     : false,
					'transitionIn'	: 'elastic',
					'transitionOut'	: 'elastic'
				});
			}else{
				Sexy.error('<h1>Upload error</h1>'+res.message);
				$("#certifications_uploadify").uploadifyCancel(q);
				$("#certifications_uploadify").uploadifyClearQueue();
			}
		}
	});
	$(".image_preview").fancybox({
		'titleShow'     : false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	})
});
function delete_certification(el,id){
	Sexy.confirm('<h1>Delete Certification?</h1><p>Are you sure you want to delete this certification?</p>',{onComplete: 
		function(returnvalue) {
			if(returnvalue){
				$.ajax({
					url: base_url+'dashboard/delete_certification/'+id,
					success: function(data) {
						$(el).parent().parent().remove();
					}
				});
			}
		}
	});
}
</script>
<div class="tab-content documents_tab" id="tab-7">
	<div id="certifications-col-right">
		<h4 class="default">Add Certificate/License</h4>
		<form action="#">
			<div class="row">
				<label>Upload Certifications:</label><br/>
				<input class="text" type="file" name="certifications_uploadify" id="certifications_uploadify" />
			</div>
		</form>
	</div>
	<div class="clear_both"></div>
	<br/>
	<div id="certifications_fileQueue"></div>
	<br/>
	<h4 class="default">Manage certifications</h4>
	<table class="grid_table" id="certifications_grid_table">
		<tr id="certifications_row_header" class="header <?php if(!$certifications){ echo 'hide';} ?>">
			<td width="6%">Preview</td>
			<td width="84%">Filename</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$certifications){ ?>
			<tr id="certifications_no_image">
				<td colspan="3"> No available certifications</td>
			</tr>
		<?php } ?>
		<?php foreach($certifications AS $certification): ?>
			<tr>
				<td><a rel="cert_groupbtn1" class="image_preview" href="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/certifications/<?=$certification['path']?>&width=800&height=600"><img alt="type" src="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/certifications/<?=$certification['path']?>&width=40&height=40" /></a></td>
				<td><?=$certification['filename']?></td>
				<td>
					<a rel="cert_groupbtn2" class="image_preview" href="<?=base_url()?>assets/phpthumb/resize.php?src=<?=base_url()?>user_assets/certifications/<?=$certification['path']?>&width=800&height=600"><img alt="download" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_magnify.png" /></a>
					<img style="cursor:pointer;" onclick="delete_certification(this,<?=$certification['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div><!-- /tab-5 end -->