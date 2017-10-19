<script type="text/javascript">
	$(function(){
		$('.wysiwyg_text').wysiwyg();
		$('input#btn_promo').click(function(){
			process_form('input#btn_promo','SAVE','div#promo_form_messages',true,'form#promo_form','dashboard/save_promo',false,'insert_new_promo');
		});
		$('input#btn_update_promo').click(function(){
			process_form('input#btn_update_promo','UPDATE','div#promo_form_messages',true,'form#promo_form','dashboard/save_promo',false,'update_promo');
		});
		$("#promo_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>dashboard/upload_promo_file',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'promo_fileQueue',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'MS Word; MS Excel; Powerpoint Presentation; PDF',
			'fileExt': '*.doc;*.docx;*.xls;*.xlsx;*.ppt;*.pptx;*.pdf',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					var file_image = '<img src="'+base_url+'assets/themes/default/images/ico'+res.file.file_ext+'.gif" />'
					$('#promo_file').val(res.file.file_name);
					$('#promo_file_orig_name').val(res.file.orig_name);
					$('#promo_file_preview').empty();
					$('#promo_file_preview').append(file_image);
					$('#promo_file_name').text(res.file.orig_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#image_uploadify").uploadifyCancel(q);
					$("#image_uploadify").uploadifyClearQueue();
				}
			}
		});
		clear_form();
	})
	function update_promo(val){
		clear_form();
		if(val.file_path){
			var icon_download = '<a href="'+base_url+'dashboard/download_promo_file/'+val.promo_id+'"><img alt="type" src="'+base_url+'assets/themes/default/images/ico'+val.file_type+'.gif" />';
		}else{
			var icon_download = 'NA';
		}
		$('#td_promo_name_'+val.promo_id).text(val.promo_name);
		$('#td_promo_code_'+val.promo_id).text(val.promo_code);
		$('#td_promo_desc_'+val.promo_id).html(val.short_desc);
		$('#td_promo_file_'+val.promo_id).html(icon_download);
		
		$('#name_promo_edit_'+val.promo_id).val(val.promo_name);
		$('#code_promo_edit_'+val.promo_id).val(val.promo_code);
		$('#file_promo_edit_'+val.promo_id).val(val.file);
		$('#file_path_promo_edit_'+val.promo_id).val(val.file_path);
		$('#description_promo_edit_'+val.promo_id).val(val.full_desc);
		setTimeout("$('div#promo_form_messages').css({'display':'none'})",5000);
	}
	function insert_new_promo(val){
		clear_form();
		if(val.file_path){
			var icon_download = '<a href="'+base_url+'dashboard/download_promo_file/'+val.promo_id+'"><img alt="type" src="'+base_url+'assets/themes/default/images/ico'+val.file_type+'.gif" />';
		}else{
			var icon_download = 'NA';
		}
		var new_promo = '<tr>'
				+'<td id="td_promo_name_'+val.promo_id+'">'+val.promo_name+'</td>'
				+'<td id="td_promo_desc_'+val.promo_id+'">'+val.short_desc+'</td>'
				+'<td id="td_promo_code_'+val.promo_id+'">'+val.promo_code+'</td>'
				+'<td id="td_promo_file_'+val.promo_id+'">'+icon_download+'</a></td>'
				+'<td>'
					+'<img id="action_promo_edit_'+val.promo_id+'" style="cursor:pointer;" onclick="edit_promo('+val.promo_id+',\''+val.file_type+'\')" alt="Edit" class="icons" src="'+base_url+'assets/themes/default/images/page_white_edit.png" />'
					+'<img style="cursor:pointer;" onclick="delete_promo(this,'+val.promo_id+')" alt="Delete" class="icons" src="'+base_url+'assets/themes/default/images/cross.png" />'
				+'</td>'
			+'</tr>'
			+'<input type="hidden" id="name_promo_edit_'+val.promo_id+'" value="'+val.promo_name+'"/>'
			+'<input type="hidden" id="code_promo_edit_'+val.promo_id+'" value="'+val.promo_code+'"/>'
			+'<input type="hidden" id="file_promo_edit_'+val.promo_id+'" value="'+val.file+'"/>'
			+'<input type="hidden" id="file_path_promo_edit_'+val.promo_id+'" value="'+val.file_path+'"/>'
			+'<input type="hidden" id="description_promo_edit_'+val.promo_id+'" value="'+val.full_desc+'"/>';
			
		$('#promo_no_file').remove();
		$('#promotionals_row_header').css({'display':'table-row'});
		$('#promo_grid_table').append(new_promo);
		setTimeout("$('div#promo_form_messages').css({'display':'none'})",5000);
	}
	function delete_promo(el,id){
		Sexy.confirm('<h1>Delete Promo?</h1><p>Are you sure you want to delete this promo?</p>',{onComplete: 
			function(returnvalue) {
				if(returnvalue){
					$.ajax({
						url: base_url+'dashboard/delete_promo/'+id,
						success: function(data) {
							$(el).parent().parent().remove();
						}
					});
				}
			}
		});
	}
	function edit_promo(id){		
		$('#btn_new_promo').css('display','inline');
		$('#btn_update_promo').css('display','inline');
		$('#btn_promo').css('display','none');
		
		var promo_code = $('#code_promo_edit_'+id).val();
		var promo_name = $('#name_promo_edit_'+id).val();
		var promo_file = $('#file_promo_edit_'+id).val();
		var promo_file_path = $('#file_path_promo_edit_'+id).val();
		var promo_content = $('#description_promo_edit_'+id).val();
		
		var type = promo_file_path.split('.');
		type = type[1];
		
		$('#promo_id').val(id);
		$('#promo_code').val(promo_code);
		$('#promo_name').val(promo_name);
		$('#promo_file_orig_name').val(promo_file);
		$('#promo_file').val(promo_file_path);
		$('#promo_content').wysiwyg('clear');
		$('#promo_content').wysiwyg('insertHtml', promo_content);
		$('#promo_content').val(promo_content);
		
		$('#promo_file_preview').empty();
		if(promo_file){
			var file_image = '<img src="'+base_url+'assets/themes/default/images/ico.'+type+'.gif" />'
			$('#promo_file_preview').append(file_image);
			$('#promo_file_name').text(promo_file);
		}else{
			$('#promo_file_name').text('(DOC,DOCX,XLS,XLSX,PPT,PPTX,PDF)');
		}
		$('html,body').animate({ scrollTop: $('#promo_form').position().top },500);
	}
	function new_promo(){
		$('#btn_new_promo').css('display','none');
		$('#btn_update_promo').css('display','none');
		$('#btn_promo').css('display','inline');
		clear_form();
	}
	function clear_form(){
		$(':input','#promo_form')
		.not(':button, :submit, :reset')
		.val('')
		.removeAttr('checked')
		.removeAttr('selected');
		$('#promo_content').wysiwyg('clear');
		$('#promo_file_preview').empty();
		$('#promo_file_name').text('(DOC,DOCX,XLS,XLSX,PPT,PPTX,PDF)');
	}
</script>
<div class="tab-content" id="tab-4">
	<div id="promo_form_messages" class="form_messages"></div>
	<div id="promo_instructions">
		<h4 class="default">Promotional Page:</h4>
		<p>
			Setup promotions for patients here. Promotions are a great way to bring interest to your profile on Dentist Search U.S.A. Use the easy navigation to the right to setup your promo.
		</p>
	</div>
	<form action="#" id="promo_form">
		<div id="promo_textarea">
			<div class="row">
				<input type="hidden" id="promo_id" name="promo_id" value="0"/>
				<label class="default"><span class="required_asterisk">*</span> Promo Name:</label><br/>
				<input class="default" id="promo_name" type="text" name="promo_name" />
			</div><!-- /row end -->
			<div class="row">
				<label class="default"> Promo Code:</label><br/>
				<input class="default" type="text" id="promo_code" name="code" />
			</div><!-- /row end -->
			<div class="row" id="promo_file_row">
				<label class="default">Promo Attachment:</label><br/>
				<input type="hidden" id="promo_file" name="file_path"/>
				<input type="hidden" id="promo_file_orig_name"  name="file"/>
				<input type="file" id="promo_uploadify" name="Filedata" />&nbsp;
				<div id="promo_file_preview"></div><label id="promo_file_name">(DOC,DOCX,XLS,XLSX,PPT,PPTX,PDF)</label>
				<br/>
				<div id="promo_fileQueue" style="width:424px;"></div>
			</div><!-- /row end -->
			<div class="row">
				<label class="default"><span class="required_asterisk">*</span> Description:</label><br/>
			</div><!-- /row end -->
			<textarea id="promo_content" rows="10" cols="52" class="wysiwyg_text" name="content"></textarea><br/>
			<div class="btn-holder">
				<input id="btn_promo" class="btn02" type="button" value="SAVE" />
				<input id="btn_update_promo" class="btn02" type="button" value="UPDATE" />
				<input id="btn_new_promo" onclick="new_promo()" class="btn03" type="button" value="NEW" />
			</div><!-- /btn-holder end -->
		</div>
		<div class="clear_both"></div>
	</form>
	<br/>
	<h4 class="default">Manage Promotionals</h4>
	<table class="grid_table" id="promo_grid_table">
		<tr id="promotionals_row_header" class="header <?php if(!$promotionals){ echo 'hide';} ?>">
			<td width="30%">Promo Name</td>
			<td width="37%">Description</td>
			<td width="15%">Promo Code</td>
			<td width="6%">File</td>
			<td width="10%">Actions</td>
		</tr>
		<?php if(!$promotionals){ ?>
			<tr id="promo_no_file">
				<td colspan="4"> No available promotionals</td>
			</tr>
		<?php } ?>
		<?php 
			foreach($promotionals AS $promo):
				$type = explode('.',$promo['file_path']);
				$type = '.'.end($type);
		?>
			<tr>
				<td id="td_promo_name_<?=$promo['id']?>"><?=$promo['name']?></td>
				<td id="td_promo_desc_<?=$promo['id']?>"><?=character_limiter(strip_tags($promo['description']),25)?></td>
				<td id="td_promo_code_<?=$promo['id']?>"><?=$promo['code']?></td>
				<td id="td_promo_file_<?=$promo['id']?>">
					<?php if($promo['file_path']){ ?>
						<a href="<?=base_url()?>dashboard/download_promo_file/<?=$promo['id']?>"><img alt="type" src="<?=base_url()?>assets/themes/default/images/ico<?=$type?>.gif" /></a>
					<?php }else{ ?>
						NA
					<?php } ?>
				</td>
				<td>
					<img style="cursor:pointer;" onclick="edit_promo(<?=$promo['id']?>)" alt="Edit" class="icons" src="<?=base_url()?>assets/themes/default/images/page_white_edit.png" />
					<img style="cursor:pointer;" onclick="delete_promo(this,<?=$promo['id']?>)" alt="Delete" class="icons" src="<?=base_url()?>assets/themes/default/images/cross.png" />
				</td>
			</tr>
			<input type="hidden" id="name_promo_edit_<?=$promo['id']?>" value="<?=form_prep($promo['name'])?>"/>
			<input type="hidden" id="code_promo_edit_<?=$promo['id']?>" value="<?=form_prep($promo['code'])?>"/>
			<input type="hidden" id="file_promo_edit_<?=$promo['id']?>" value="<?=form_prep($promo['file'])?>"/>
			<input type="hidden" id="file_path_promo_edit_<?=$promo['id']?>" value="<?=form_prep($promo['file_path'])?>"/>
			<input type="hidden" id="description_promo_edit_<?=$promo['id']?>" value="<?=form_prep($promo['description'])?>"/>
		<?php endforeach; ?>
	</table>
</div><!-- /tab-2 end -->