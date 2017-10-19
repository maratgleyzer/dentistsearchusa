<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title> DSUSA - Admin </title>
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/admin/style.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/jquery_ui_dsusa/jquery-ui-1.8.2.custom.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/admin/jquery_dropdownmenu.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/sexyalertbox/sexyalertbox.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/fancybox/jquery.fancybox-1.3.0.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/shadowbox/shadowbox.css')?>" />
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/css/uploadify.css')?>" />
		<script type="text/javascript">
			base_url = '<?=base_url()?>'; //define base_url in JS
		</script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery-1.4.2.min.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery-ui-1.8.2.complete.min.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.metadata.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery_dropdownmenu.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.jqEasyCharCounter.min.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/ajax-form.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/sexyalertbox.v1.2.jquery.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.fancybox-1.3.0.js')?>"></script>
		<script type="text/javascript" src="<?=base_url();?>assets/shadowbox/shadowbox.js"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/swfobject.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/jquery.uploadify.v2.1.0.min.js')?>"></script>
		<script type="text/javascript" src="<?=min_file('assets/js/admin-autocomplete.js')?>"></script>
	</head>
	<body>
		<div id="main_container">
			<div id="main_header">
				<a title="Open front end" href="<?=base_url()?>" target="_blank">
					<img id="logo" src="<?=base_url()?>assets/images/admin/logo.png">
				</a>
				<div id="logout">
					<a href="<?=base_url()?>_admin_console/login/logout">
						<img src="<?=base_url()?>assets/images/admin/logout.png"> Logout
					</a>
				</div>
			</div>