	<script type="text/javascript" src="<?=min_file('
		assets/js/jquery-1.4.2.min.js,
		assets/js/jquery-ui-1.8.2.complete.min.js,
		assets/js/jquery.metadata.js,
		assets/js/jquery.pagination.js,
		assets/js/jquery.simplelightbox.js,
		assets/js/hide-text-inputs.js,
		assets/js/main.js,
		assets/js/city-zip-autocomplete.js,
		assets/js/ajax-form.js,
		assets/js/jquery.jcarousel.min.js,
		assets/js/jquery-ui-timepicker.js,
		assets/js/sexyalertbox.v1.2.jquery.js,
		assets/js/google-map.js,
		assets/js/jquery.fancybox-1.3.0.js,
		assets/js/jquery.printarea-2.0.js,
		assets/jquery.ui.stars-3.0/jquery.ui.stars.min.js,
		assets/js/jquery.wysiwyg.js,
		assets/js/swfobject.js,
		assets/js/jquery.uploadify.v2.1.0.min.js,
		assets/js/ba-throttle-debounce.min.js
	')?>"></script>
	<link rel="stylesheet" type="text/css" href="<?=min_file('
		assets/themes/default/jquery_ui_dsusa/jquery-ui-1.8.2.custom.css,
		assets/themes/default/css/all.css,
		assets/themes/default/css/jquery.wysiwyg.css,
		assets/themes/default/css/uploadify.css,
		assets/themes/default/sexyalertbox/sexyalertbox.css,
		assets/themes/default/fancybox/jquery.fancybox-1.3.0.css,
		assets/jquery.ui.stars-3.0/jquery.ui.crystalstars.css,
		assets/themes/default/css/pagination.css
	')?>" />
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?=min_file('assets/themes/default/css/ie.css')?>" media="screen"/><![endif]-->	
	<?php if(isset($video_page)){ ?>
		<link rel="stylesheet" type="text/css" href="<?=min_file('assets/shadowbox/shadowbox.css')?>" media="screen"/>
		<script type="text/javascript" src="<?=min_file('assets/shadowbox/shadowbox.js')?>"></script>
		<script type="text/javascript">Shadowbox.init();</script>
	<?php } ?>