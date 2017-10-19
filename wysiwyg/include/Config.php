<?php
	$domainname			=		"http://localhost";
	
	$siterealpath			=		"/wysiwyg";
	$siteurlrealpath		=		$domainname.$siterealpath."/";
	
	$assetspath 			= 		$siterealpath;
	$assetsvirtualpath		=		$siterealpath."/assets";  
	$assetbasepath			=		$_SERVER['DOCUMENT_ROOT'].$assetsvirtualpath; 
	
	
	//================ LINKS FOR SITE EXTERNAL SOURCES ===================//
	define("SITE_URL_REAL_PATH",$siteurlrealpath);
//	define("SITE_URL_CONN_PATH",$connectionpath);
//	define("SITE_URL_SQL_PATH",$mysqlclasspath);
	
	
	//================ LINKS FOR TEXT EDITORS ===================//
	define("ASSET_REAL_PATH",$assetspath);
	define("ASSET_VIRTUAL_SETTINGS",$assetsvirtualpath);
	define("ASSET_BASE_PATH",$assetbasepath);
	
	
	$sBaseVirtual0 = ASSET_VIRTUAL_SETTINGS;  //Assuming that the path is http://yourserver/Editor/assets/ ("Relative to Root" Path is required)
		$sBase0 = ASSET_BASE_PATH
?>
