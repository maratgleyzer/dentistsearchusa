<script type="text/javascript">
	function save_success(){

	}
	function mask_form(el){
		if($(el).is(':checked')){
			$('#ads_form_mask').css('display','block');
			$('#icon_form :input[type="text"]').attr('disabled',true);
		}else{
			$('#ads_form_mask').css('display','none');
			$('#icon_form :input[type="text"]').attr('disabled','');
		}
	}
	$(function(){
		$('input#btn_save').click(function(){
			process_form('input#btn_save','SAVE','div#icon_form_messages',true,'form#icon_form','admin/advertisements/save_sidebar_ads/<?=$page?>',false,'save_success');
		});
		$("#ad_image_1").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>admin/advertisements/upload_sidebar_image/1',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'queue_ad_1',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'PNG; JPEG;',
			'fileExt': '*.png;*.jpeg;*.jpg;',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					$('#ad_image_prev_1').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'assets/images/advertisements/'+res.file.file_name+'&width=259&height=215');
					$('#ad_value_1').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#ad_image_1").uploadifyCancel(q);
					$("#ad_image_1").uploadifyClearQueue();
				}
			}
		});
		$("#ad_image_2").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>admin/advertisements/upload_sidebar_image',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'queue_ad_2',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'PNG; JPEG;',
			'fileExt': '*.png;*.jpeg;*.jpg;',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					$('#ad_image_prev_2').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'assets/images/advertisements/'+res.file.file_name+'&width=259&height=215');
					$('#ad_value_2').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#ad_image_2").uploadifyCancel(q);
					$("#ad_image_2").uploadifyClearQueue();
				}
			}
		});
		$("#ad_image_3").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>admin/advertisements/upload_sidebar_image',
			'cancelImg': '<?=base_url()?>assets/images/cancel.png',
			'queueID': 'queue_ad_3',
			'method': 'POST',
			'auto': true,
			'multi': false,
			'fileDesc':'PNG; JPEG;',
			'fileExt': '*.png;*.jpeg;*.jpg;',
			'onComplete': function(e,q,o,r){
				res = jQuery.parseJSON(''+r+'');
				if(res.success){
					$('#ad_image_prev_3').attr('src',base_url+'assets/phpthumb/resize.php?src='+base_url+'assets/images/advertisements/'+res.file.file_name+'&width=259&height=215');
					$('#ad_value_3').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#ad_image_3").uploadifyCancel(q);
					$("#ad_image_3").uploadifyClearQueue();
				}
			}
		});
		mask_form($('#use_default'));
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Sidebar Ads (<a href="<?=base_url().$page?>" target="_blank"><?=base_url().$page?></a>)
	</label><br/><br/><br/>
	<div id="icon_form_messages" class="form_messages"></div>
	<div id="ads_container" style="display:inline; float:left; margin-top: 20px;">
		<div id="ads_1">
			<?php if($first_ad['image']){ ?>
				<img id="ad_image_prev_1" src="<?=base_url()?>assets/images/advertisements/<?=$first_ad['image']?>">
			<?php }else{ ?>
				<img id="ad_image_prev_1" src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_1.png">
			<?php } ?>
		</div>
		<div id="ads_2">
			<?php if($second_ad['image']){ ?>
				<img id="ad_image_prev_2" src="<?=base_url()?>assets/images/advertisements/<?=$second_ad['image']?>">
			<?php }else{ ?>
				<img id="ad_image_prev_2" src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_2.png">
			<?php } ?>
		</div>
		<div id="ads_3">
			<?php if($third_ad['image']){ ?>
				<img id="ad_image_prev_3" src="<?=base_url()?>assets/images/advertisements/<?=$third_ad['image']?>">
			<?php }else{ ?>
				<img id="ad_image_prev_3" src="<?=base_url()?>assets/images/advertisements/no_sidebar_ads_3.png">
			<?php } ?>
		</div>
	</div>
	<div style="display:inline; float:left; width: 500px; margin-left: 40px; position:relative;">
		<div id="ads_form_mask"></div>
		<form id="icon_form">
			<div style="position:absolute; left: -305px; top: 0px;">
				<input id="use_default" onchange="mask_form(this)" name="use_default" value="1" type="checkbox" <?php if($first_ad['use_default']){echo 'checked="checked"';} ?> /> Use default advertisements?
			</div>
			<div class="ads_form">
				<label class="label_header">Advertisement 1</label><br>
				Image (259 x 215 pixels)<br>
				<input type="hidden" id="ad_value_1" value="<?=$first_ad['image']?>" name="image_1"/>
				<input type="file" id="ad_image_1" name="Filedata" /><br/>
				<div id="queue_ad_1" style="width: 320px;"></div>
				Link<br/>	
				<input type="text" class="wide_input_text" name="links_1" value="<?=$first_ad['links']?>" /><br>
				Text<br/>	
				<input type="text" class="wide_input_text" name="text_1" value="<?=$first_ad['text']?>" /><br>
			</div>
			
			<div class="ads_form">
				<label class="label_header">Advertisement 2</label><br>
				Image (124 x 124 pixels)<br>
				<input type="hidden" id="ad_value_2" value="<?=$second_ad['image']?>" name="image_2"/>
				<input type="file" id="ad_image_2" name="Filedata" /><br/>
				<div id="queue_ad_2" style="width: 320px;"></div>
				Link<br/>	
				<input type="text" class="wide_input_text" name="links_2" value="<?=$second_ad['links']?>" /><br/>
				Text<br/>	
				<input type="text" class="wide_input_text" name="text_2" value="<?=$second_ad['text']?>" /><br/>
			</div>
			
			<div class="ads_form">
				<label class="label_header">Advertisement 3</label><br>
				Image (124 x 124 pixels)<br>
				<input type="hidden" id="ad_value_3" value="<?=$third_ad['image']?>" name="image_3"/>
				<input type="file" id="ad_image_3" name="Filedata" /><br/>
				<div id="queue_ad_3" style="width: 320px;"></div>
				Link<br/>	
				<input type="text" class="wide_input_text" name="links_3" value="<?=$third_ad['links']?>" /><br/>
				Text<br/>	
				<input type="text" class="wide_input_text" name="text_3" value="<?=$third_ad['text']?>" /><br/>
			</div>
			<div class="btn-holder">
				<input class="btn03" type="button" value="CANCEL" />
				<input class="btn02" id="btn_save" type="button" value="SAVE" />
			</div><!-- /btn-holder end -->
		</form>
	</div>
</div>