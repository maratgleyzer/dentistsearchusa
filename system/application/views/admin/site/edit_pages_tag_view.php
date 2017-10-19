<?php if($tag['editable_content']){ ?>
	<script type="text/javascript" src="<?=base_url()?>wysiwyg/admin/scripts/innovaeditor.js"></script>
<?php } ?>
<script type="text/javascript">
	function save_success(){
	
	}
	$(function(){
		$('input#btn_save').click(function(){
			<?php if($tag['editable_content']){ ?>
				$('#txtEditor').val(idContentoEdit1.document.body.innerHTML);
			<?php } ?>
			process_form('input#btn_save','SAVE','div#tag_form_messages',true,'form#tag_form','_admin_console/home/save_tag/<?=$tag['id']?>',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Page - <?php if(!$tag['content_only']){ ?> <a target="_blank" href="<?=base_url()?><?=$tag['page']?>" style="color:#007a6d;"><?=$tag['page']?></a> <?php }else{ echo $tag['page']; } ?>
	</label><br/><br/>
	<div id="tag_form_messages" class="form_messages"></div>
	<form id="tag_form">
			<input type="hidden" value="<?=$tag['editable_content']?>" name="editable_content"/>
			<input type="hidden" value="<?=$tag['content_only']?>" name="content_only"/>
		<?php if(!$tag['content_only']){ ?>
			Page Title<br/>	
			<input type="text" class="wide_input_text" name="title" value="<?=$tag['title']?>" /><br/><br/>
			Meta Keywords<br/>	
			<input type="text" class="wide_input_text" name="keywords" value="<?=$tag['keywords']?>" /><br/><br/>
			Meta Description<br/>
			<textarea style="height:200px;" class="wide_input_text"  name="description"><?=$tag['description']?></textarea><br/><br/>
		<?php } ?>
		<?php if($tag['editable_content']){ ?>
			Content <?php if($tag['page'] == 'registration_details'){ ?><label class="form_description">(Signup Popup Form: %signup_form%)<?php }?></label><br/>
			<textarea id="txtEditor" name="content">
				<?=$tag['content']?>
			</textarea>
			<script type="text/javascript">
				//WYSIWYG EDITOR
				var oEdit1 = new InnovaEditor("oEdit1");
				oEdit1.width=670;
				oEdit1.height=461;

				/***************************************************
					RECONFIGURE TOOLBAR BUTTONS
				***************************************************/
				
				oEdit1.features=[
					"Superscript","Subscript","|","LTR","RTL","|",
					"Table","Guidelines","|",
					"Characters","ClearAll",		
					"Cut","Copy","Paste","PasteWord","PasteText","|",
					"Undo","Redo","|","Hyperlink","Image","|",
					"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull","|",
					"Numbering","Bullets","|",
					"Line","RemoveFormat","BRK",
					"StyleAndFormatting",
					"BoxFormatting","|",
					"Paragraph","|",
					"Bold","Italic","Underline","Strikethrough","|",
					"ForeColor","BackColor"];
					
				/***************************************************
					OTHER SETTINGS
				***************************************************/
				oEdit1.cmdAssetManager = "modalDialogShow('<?=base_url()?>wysiwyg/assetmanager/assetmanager.php',670,465)";
				oEdit1.cmdInternalLink = "modelessDialogShow('links.htm',365,270)"; 
				oEdit1.cmdCustomObject = "modelessDialogShow('objects.htm',365,270)"; 
				oEdit1.arrCustomTag=[["First Name","{%first_name%}"],
						["Last Name","{%last_name%}"],
						["Email","{%email%}"]];
				oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];
				oEdit1.mode="XHTMLBody";
				oEdit1.REPLACE("txtEditor");
				//WYSIWYG EDITOR END
			</script><br/>
		<?php } ?>
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>