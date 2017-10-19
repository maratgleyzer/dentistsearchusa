<script type="text/javascript" src="<?=base_url()?>wysiwyg/admin/scripts/innovaeditor.js"></script>
<script type="text/javascript">
	
	function confirmCancel(link){
		Sexy.confirm('<h1>Cancel</h1><p>Are you sure you want to cancel and go to contest management?</p>',{onComplete: 
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
			$('#txtEditor').val(idContentoEdit1.document.body.innerHTML);
			process_form('input#btn_save','SAVE','div#article_form_messages',true,'form#article_form','_admin_console/articles/save_article',false,'save_success');
		});
		$("#image_uploadify").uploadify({
			'uploader': '<?=base_url()?>assets/swf/uploadify.swf',
			'script': '<?=base_url()?>_admin_console/articles/upload_image',
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
					$('#main_image').val(res.file.file_name);
				}else{
					Sexy.error('<h1>Upload error</h1>'+res.message);
					$("#image_uploadify").uploadifyCancel(q);
					$("#image_uploadify").uploadifyClearQueue();
				}
			}
		});
		$('#limit_summary').jqEasyCounter({
			'maxChars': 500,
			'maxCharsWarning': 420
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Add Article
	</label><br/><br/>
	<div id="article_form_messages" class="form_messages"></div>
	<form id="article_form">
		Main Image<br>
		<input type="hidden" id="main_image" name="image"/>
		<input type="file" id="image_uploadify" name="Filedata" /><br/>
		<img id="article_main_image" class="main_image" src="<?=base_url();?>content_assets/images/no_image.jpg" alt="image" width="320" height="167" />
		<div id="image_fileQueue" style="width: 320px;"></div>
		<br/><br/>
		Author<br/>	
		<input type="text" style="width: 330px;" class="medium_input_text" name="author" /><br/><br/>
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
		<textarea class="wide_input_text" id="limit_summary" name="summary" rows="5"></textarea><br/><br/>
		Content<br/>
		<textarea id="txtEditor" name="content">
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
		<div class="btn-holder">
			<input class="btn03" type="button" value="CANCEL" />
			<input class="btn02" id="btn_save" type="button" value="SAVE" />
		</div><!-- /btn-holder end -->
	</form>
</div>