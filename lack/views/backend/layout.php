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
	
	<script>
	var site_url = "<?php echo site_url(); ?>";
	</script>
	
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/init.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/js/markitup/skins/simple/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/js/markitup/sets/markdown/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('data/system_assets/css/post.css'); ?>">
</head>

<body id="back">
<div id="layout">
	<header id="hd1"><div class="wrap">
		<h1><a href="<?php echo site_url('backend'); ?>"><?php echo config_item('site_name'); ?></a></h1>
		
		<nav id="nav"><ul>
			<li><a href="<?php echo site_url('backend/content');  ?>" class="content">Content</a></li>
			<li><a href="<?php echo site_url('backend/settings'); ?>" class="settings">Settings</a></li>
			<li><a href="<?php echo site_url('backend/logout');   ?>" class="logout">Logout</a></li>
		</ul></nav>
		<!-- !/#nav -->
	</div></header>
	<!-- !/#hd1 -->
	
	<?php echo $yield; ?>
	
	<footer id="f1">
		<p><?php echo config_item('site_copyright'); ?></p>
	</footer>
	<!-- !/#f1 -->
</div>
<!-- !/#layout -->


<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.js"></script>
<script>window.jQuery || document.write("<script src='assets/js/libs/jquery-1.6.1.min.js'>\x3C/script>")</script>

<script src="<?php echo site_url('data/system_assets/js/plugins.js'); ?>"></script>
<script src="<?php echo site_url('data/system_assets/js/markitup/jquery.markitup.js'); ?>"></script>
<script src="<?php echo site_url('data/system_assets/js/markitup/sets/markdown/set.js'); ?>"></script>

<script src="<?php echo site_url('data/system_assets/js/script.js'); ?>"></script>

</body>
</html>
