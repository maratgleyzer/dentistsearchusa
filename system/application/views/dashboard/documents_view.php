<script type="text/javascript">
$(document).ready(function() {
	$('input#btn_docs').click(function(){
		process_form('input#btn_docs','SAVE','div#docs_form_messages',false,'form#docs_form','dashboard/save_dashboard_info');
	});
	$("#uploadify").uploadify({
		'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
		'script': '<?=base_url()?>dashboard/upload_document_file/',
		'cancelImg': '<?=base_url()?>assets/images/cancel.png',
		'queueID': 'fileQueue',
		'method': 'POST',
		'auto': true,
		'sizeLimit': 5000000,
		'scriptData': {'up_key':"<?=$logged_key?>"},
		'multi': true,
		'fileDesc':'MS Word; MS Excel; Powerpoint Presentation; PDF',
		'fileExt': '*.doc;*.docx;*.xls;*.xlsx;*.ppt;*.pptx;*.pdf',
		'onComplete': function(e,q,o,r){
			res = jQuery.parseJSON(''+r+'');
			if(res.success){
				var new_file = ''
					+'<tr>'
						+'<td><img alt="type" src="'+base_url+'assets/themes/default/images/ico'+res.file.file_ext+'.gif" /></td>'
						+'<td>'+res.file.orig_name+'</td>'
						+'<td>'+res.file.group+'</td>'
						+'<td>'
							+'<a href="'+base_url+'dashboard/download_document_file/'+res.file.file_id+'"><img alt="download" class="icons" src="'+base_url+'assets/themes/default/images/page_white_put.png" /></a>'
							+'<img style="cursor:pointer;" onclick="delete_document_file(this,'+res.file.file_id+')" alt="delete" class="icons" src="'+base_url+'assets/themes/default/images/cross.png" />'
						+'</td>'
					+'</tr>';
				$('#documents_no_file').remove();
				$('#documents_row_header').css({'display':'table-row'});
				$('#documents_grid_table').append(new_file);
			}else{
				Sexy.error('<h1>Upload error</h1>'+res.message);
				$("#uploadify").uploadifyCancel(q);
				$("#uploadify").uploadifyClearQueue();
			}
		},
		'onSelect': function(e,q){
			var group = $("input:radio:[name=file_group]:checked").val();
			group_name = $('#'+group+'_group_name').val();
			$("#uploadify").uploadifySettings('scriptData',{'group_name':group_name});
			if(!group_name){
				$("#uploadify").uploadifyCancel(q);
				Sexy.error('<h1>File group name error</h1><p>Please select/provide a group name for the files</p>');
				return false;
			}
		}
	});
});
function delete_document_file(el,id){
	Sexy.confirm('<h1>Delete File?</h1><p>Are you sure you want to delete this file?</p>',{onComplete: 
		function(returnvalue) {
			if(returnvalue){
				$.ajax({
					url: base_url+'dashboard/delete_document_file/'+id,
					success: function(data) {
						$(el).parent().parent().remove();
					}
				});
			}
		}
	});
}
</script>
<div class="tab-content documents_tab" id="tab-5">
	<div id="docs_form_messages" class="form_messages"></div>
	<div id="col-left">
		<form id="docs_form" action="#">
			<h4 class="default">Introduction Text</h4>
			<input type="hidden" name="field" value="documents_intro"/>
			<textarea cols="38" rows="8" name="content" class="wysiwyg_text">
				<?=$dashboard_info['documents_intro']?>
			</textarea>
			<div class="btn-holder" style="margin-right: 10px; margin-top: 10px;">
				<input id="btn_docs" class="btn02" type="button" value="SAVE" />
				
			</div><!-- /btn-holder end -->
		</form>
	</div>
	<div id="col-right">
		<h4 class="default">Add files</h4>
		<form action="#">
			<div class="row">
				<input type="radio" value="new" name="file_group" checked="checked" />
				<label>New group</label><br/> 
				<input class="default" id="new_group_name" type="text" />
			</div>
			<div class="row">
				<input type="radio" value="old" name="file_group"/>
				<label>Add files to existing group</label><br/> 
				<select class="default" id="old_group_name">
					<option value="">
						- - - - - - - - - - - - - - select - - - - - - - - - - - - - -
					</option>
					<?php foreach($groups AS $group): ?>
						<option value="<?=$group['group']?>">
							<?=$group['group']?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="row">
				<label>Upload Files:</label><br/>
				<input class="text" type="file" name="uploadify" id="uploadify" />
			</div>
		</form>
	</div>
	<div class="clear_both"></div>
	<br/>
	<div id="fileQueue"></div>
	<br/>
	<h4 class="default">Manage files</h4>
	<table class="grid_table" id="documents_grid_table">
		<tr id="documents_row_header" class="header <?php if(!$documents){ echo 'hide';} ?>">
			<td width="6%">Type</td>
			<td width="45%">Filename</td>
			<td width="37%">Group name</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$documents){ ?>
			<tr id="documents_no_file">
				<td colspan="4"> No available document files</td>
			</tr>
		<?php } ?>
		<?php foreach($documents AS $doc): ?>
			<tr>
				<td><img alt="type" src="<?=base_url()?>assets/themes/default/images/ico<?=$doc['type']?>.gif" /></td>
				<td><?=$doc['filename']?></td>
				<td><?=$doc['group']?></td>
				<td>
					<a href="<?=base_url()?>dashboard/download_document_file/<?=$doc['id']?>"><img alt="download" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_put.png" /></a>
					<img style="cursor:pointer;" onclick="delete_document_file(this,<?=$doc['id']?>)" alt="delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div><!-- /tab-4 end -->