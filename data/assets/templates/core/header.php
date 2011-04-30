<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Lack&deg;</title>
	<meta name="description" content="Lack CMS Demo">
	<meta name="author" content="Boris Strahija, http://creolab.hr">
	<link rel="stylesheet" href="<?php echo site_url('data/assets/css/style.css'); ?>">
	<script src="<?php echo site_url('data/assets/js/libs/modernizr-1.7.min.js'); ?>"></script>
</head>

<body>
<div id="layout">
	<header>
		<h1><a href="<?php echo site_url(); ?>">Lack&deg;</a></h1>
	</header>
	<hr>
	
	<aside>
		<nav>
			<ul>
				<li><a href="<?php echo site_url();          ?>">Home</a></li>
				<li><a href="<?php echo site_url('about');   ?>">About</a></li>
				<li><a href="<?php echo site_url('blog');    ?>">Blog</a></li>
				<li><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
			</ul>
		</nav>
		<hr>
		
		<div class="widget twitter">
			<?php Lack::partial('twitter'); ?>
		</div>
	</aside>
	
	
	