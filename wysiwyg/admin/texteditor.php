<?php
	include_once("../include/Config.php");
	
	if($text_editor_width=="")$text_editor_width="570";
	if($text_editor_height=="")$text_editor_height="450";
?>
	<script>
		var oEdit1 = new InnovaEditor("oEdit1");

		oEdit1.width=<?=$text_editor_width?>;
		oEdit1.height=<?=$text_editor_height?>;

		/***************************************************
			RECONFIGURE TOOLBAR BUTTONS
		***************************************************/
		
		oEdit1.features=["FullScreen","Preview","Print",
			"Search","|",
			"Superscript","Subscript","|","LTR","RTL","|",
			"Table","Guidelines","Absolute","|",
			"Flash","Media","|","InternalLink","CustomObject","|",
			"Form","Characters","ClearAll","XHTMLFullSource","XHTMLSource","BRK",		
			"Cut","Copy","Paste","PasteWord","PasteText","|",
			"Undo","Redo","|","Hyperlink","Bookmark","Image","|",
			"JustifyLeft","JustifyCenter","JustifyRight","JustifyFull","|",
			"Numbering","Bullets","|","Indent","Outdent","|",
			"Line","RemoveFormat","BRK",
			"StyleAndFormatting","TextFormatting","ListFormatting",
			"BoxFormatting","ParagraphFormatting","CssText","Styles","|",
			"CustomTag","Paragraph","FontName","FontSize","|",
			"Bold","Italic","Underline","Strikethrough","|",
			"ForeColor","BackColor"];// => Custom Button Placement


		/***************************************************
			OTHER SETTINGS
		***************************************************/
		oEdit1.css="../template/horizontal/style.css";//Specify external css file here

		oEdit1.cmdAssetManager = "modalDialogShow('<? print ASSET_REAL_PATH?>/assetmanager/assetmanager.php',640,465)"; //Command to open the Asset Manager add-on.
		oEdit1.cmdInternalLink = "modelessDialogShow('links.htm',365,270)"; //Command to open your custom link lookup page.
		oEdit1.cmdCustomObject = "modelessDialogShow('objects.htm',365,270)"; //Command to open your custom content lookup page.

		oEdit1.arrCustomTag=[["First Name","{%first_name%}"],
				["Last Name","{%last_name%}"],
				["Email","{%email%}"]];//Define custom tag selection

		oEdit1.customColors=["#ff4500","#ffa500","#808000","#4682b4","#1e90ff","#9400d3","#ff1493","#a9a9a9"];//predefined custom colors

		oEdit1.mode="XHTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"

		oEdit1.REPLACE("txtContent");
	</script>
