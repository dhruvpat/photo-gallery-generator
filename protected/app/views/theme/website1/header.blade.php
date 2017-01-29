<!DOCTYPE html>
<html class="no-js" lang="en-US">

<head>

	<title>{{ $meta_title or "" }}{{ Config::get('general.meta_title_postfix') }}</title>
	<meta name="description" content="{{ $meta_description or "" }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	

	<?php $theme_folder = Config::get('general.theme_folder'); ?>
	<link rel="shortcut icon" href="/uploads/theme/{{ $theme_folder }}/img/favicon.ico" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Rokkitt:400,700" />
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/fancybox.css')}}
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/flexslider.css')}}
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/base.css')}}
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/structure.css')}}
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/bright.css')}}
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/parts.css')}}
	

	<!--[if lte IE 9]>
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/ie9.css')}}
	<![endif]-->
	<!--[if lte IE 8]>
	{{ HTML::style('uploads/theme/'.$theme_folder.'/data/css/ie8.css')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/html5.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/respond.min.js')}}
	<![endif]-->

	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.cookie.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.fancybox.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.flexslider.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.masonry.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/jquery.yaselect.min.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/website.config.js')}}
	{{ HTML::script('uploads/theme/'.$theme_folder.'/data/js/website.min.js')}}

</head>

	<body>

		<div id="main" class="clear">
			<div class="container">

				<header id="header" class="clear">
					<hgroup class="alpha">
						<span class="alpha vertical">
							<span>
								<a href="/" title="Home Page">
								<img src="/uploads/img/ccplogo.png">
								</a>
							</span>
						</span>

					</hgroup>

				</header>

				<nav id="nav-main" class="clear left">
					<ul>
						<li><a href="index.html" title="Home">Home</a></li>
						<li><a href="blog.html" title="Blog">Blog</a></li>
					</ul>
				</nav>

				<section id="content">
