<script type="text/javascript" src="<?=base_url()?>wysiwyg/admin/scripts/innovaeditor.js"></script>
<script type="text/javascript">
	function save_success(){
	
	}
	$(function(){
		$('input#btn_save').click(function(){
			$('#txtEditor').val(idContentoEdit1.document.body.innerHTML);
			process_form('input#btn_save','SAVE','div#email_form_messages',true,'form#email_form','_admin_console/emails/save_email_template/<?=$email['id']?>',false,'save_success');
		});
	})
</script>
<div>
	<br/><br/>
	<label class="page_header" >
		Edit Email Template
	</label><br/><br/>
	<div id="email_form_messages" class="form_messages"></div>
	<form id="email_form">
		Subject<br/>	
		<input type="text" class="wide_input_text" name="subject" value="<?=$email['subject']?>" /><br/><br/>
		Content <label class="form_description">(Recipient's Name: %recepient_name%, Registration Link: %registration_link%)</label><br/>
		<textarea id="txtEditor" name="content">
			<?=$email['content']?>
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
			oEdit1.arrCustomemail=[["First Name","{%first_name%}"],
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