<!DOCTYPE html>
<!--[if lt IE 9]>             <html class="no-js ie lt-ie9" lang="en-US"><![endif]-->
<!--[if IE 9]>                <html class="no-js ie ie9" lang="en-US">   <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js no-ie" lang="en-US">    <!--<![endif]-->
<!-- Head section -->
<head>
		<title>{{ $meta_title }}</title>
		<meta name="description" content="{{ $meta_description }}" />
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<?php $theme_folder = Config::get('general.theme_folder'); ?>
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/fancybox.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/layerslider.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/mejs.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/style.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/bright.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/color-blue.css')}}
		<link rel="stylesheet" href="{{asset('uploads/theme/'.$theme_folder.'/css/mobile.css')}}" media="only screen and (max-width: 767px)">
		<link rel="shortcut icon" href="/uploads/theme/{{ Config::get('general.theme_folder')}}/img/favicon.ico" />
		
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script type="text/javascript" src="data/js/selectivizr.min.js"></script>
		<![endif]-->
		
	</head>
	<!-- // Head section -->

	<!-- Body section -->
	<body class="layout-boxed">

		<div id="top">

			<div id="backgrounds"></div>

			<div class="outer-container">

				<!-- Mobile navigation -->
				<nav class="mobile">
					<ul>
						<li><a href="/page/about">About</a></li>
						<li><a href="/page/careers">Careers</a></li>
						<li><a href="/page/contact">Contact</a></li>
						<li><a href="/page/terms-of-use">Terms of use</a></li>
						<li><a href="/page/privacy-policy">Privacy policy</a></li>
					</ul>
				</nav>
				<!-- // Mobile navigation -->

				<!-- Mobile navigation -->
				<nav class="mobile">
					<ul>
						<li>
							<form class="search" action="search.html">
								<input type="text" placeholder="search" /><button type="submit"><i class="icon-search"></i></button>
							</form>
						</li>
					</ul>
				</nav>
				<!-- // Mobile navigation -->

			</div><!-- // .outer-container -->

			<div class="outer-container upper">

				<!-- Header -->
				<header class="header">

					<div class="container">

						<!-- Mobile helper -->
						<div class="mobile-helper vertical-align">
							<a class="button" title="Menu"><i class="icon-menu"></i></a>
							<a class="button" title="Search"><i class="icon-search"></i></a>
						</div>
						<!-- // Mobile helper -->


						<!-- Logo -->
						<img src="/uploads/theme/{{ Config::get('general.theme_folder')}}/img/logo.jpg">
						<!-- // Logo -->

						
						
						<!-- // Menu html -->

					</div><!-- // .container -->

				</header>
				<!-- // Header -->

			</div><!-- // .outer-container -->


			<div class="outer-container">

				<!-- Content -->
				<div class="content">

					<div class="container">



