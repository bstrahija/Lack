<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Lack&deg; Backend</title>
	<meta name="description" content="Lack CMS backend">
	<meta name="author" content="Boris Strahija">
	
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/init.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/login.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/post.css'); ?>">
</head>

<body id="auth">
<div id="layout">
	<header>
		<h1><?php echo config_item('site_name'); ?></h1>
	</header>
	<div id="main" role="main">
		<?php echo $yield; ?>
	</div>
</div>
<!-- !/#layout -->


<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
<script>window.jQuery || document.write("<script src='assets/js/libs/jquery-1.6.1.min.js'>\x3C/script>")</script>

<script src="<?php echo site_url('data/system_assets/js/plugins.js'); ?>"></script>
<script src="<?php echo site_url('data/system_assets/js/script.js'); ?>"></script>

</body>
</html>
