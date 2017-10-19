<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<title><?=$seo['title']?>.</title>
	
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="<?=$seo['description']?>" />
	<meta  name="keywords" content="<?=$seo['keywords']?>" />
	<script type="text/javascript">
		base_url = '<?=base_url()?>'; //define base_url in JS
		search_page = '<?=isset($search_page)?>'; //define base_url in JS
	</script>
	<?=$includes_section; //js and css includes ?>
	
</head>
<body>
	<div class="wrapper <?php if(isset($page)) echo $page;?>">
		<div id="header">
			<?=$menu_section; //logo and menu section ?>
			<?php if(isset($search_section)) echo $search_section; //search bar seaction ?>
		</div><!-- /header end -->