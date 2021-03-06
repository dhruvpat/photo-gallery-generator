<!DOCTYPE html>
<!--[if lt IE 9]>             <html class="no-js ie lt-ie9" lang="en-US"><![endif]-->
<!--[if IE 9]>                <html class="no-js ie ie9" lang="en-US">   <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js no-ie" lang="en-US">    <!--<![endif]-->
<!-- Head section -->
<head>
		<title>{{ $meta_title or "" }}{{ Config::get('general.meta_title_postfix') }}</title>
		<meta name="description" content="{{ $meta_description or "" }}" />
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
		<?php $theme_folder = Config::get('general.theme_folder'); ?>
		<link rel="shortcut icon" href="/uploads/theme/{{ $theme_folder }}/img/favicon.ico" />
		
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/opti.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/color-blue.css')}}
		{{ HTML::style('uploads/theme/'.$theme_folder.'/css/common.css')}}
		<link rel="stylesheet" href="{{asset('uploads/theme/'.$theme_folder.'/css/responsive.css')}}" media="only screen and (max-width: 767px)">

		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<script type="text/javascript" src="data/js/selectivizr.min.js"></script>
		<![endif]-->
	</head>
	<body class="layout-boxed">
		<div id="top">
			<div id="backgrounds" style="background-image:url('/uploads/img/ccpback.png')"></div>
			<div class="outer-container">
				<nav class="mobile">
					<ul>
						<li><a href="/page/about">About</a></li>
						<li><a href="/page/careers">Careers</a></li>
						<li><a href="/page/contact">Contact</a></li>
						<li><a href="/page/terms-of-use">Terms of use</a></li>
						<li><a href="/page/privacy-policy">Privacy policy</a></li>
					</ul>
				</nav>
				<nav class="mobile">
			
				</nav>


			</div>

			<div class="outer-container upper">
				<header class="header">

					<div class="container" style="text-align:center;">
					<div class="logo vertical-align">
						<a href="/" title="Home Page">
						<img src="/uploads/img/ccplogo.gif">
						</a>
					</div>
					
					
						<div class="mobile-helper vertical-align" style="text-align:center; width:100%">
						<nav>
						<ul>
							<li><a href="/tags/cartoons">Cartoons</a> | </li>
							<li><a href="/tags/animals">Animals</a> | </li>
							<li><a href="/tags/alphabets">Alphabets</a> | </li>
							<li><a href="/tags/numbers">Numbers</a> | </li>
							<li><a href="/tags/general">General</a></li>
						</ul>
						</nav>
						</div>

					<nav class="primary vertical-align" style="top: 0px;">
						<ul>
							<li><a href="/tags/cartoons">Cartoons</a></li>
							<li><a href="/tags/animals">Animals</a></li>
							<li><a href="/tags/alphabets">Alphabets</a></li>
							<li><a href="/tags/numbers">Numbers</a></li>
							<li><a href="/tags/general">General</a></li>
						</ul>
					</nav>
					</div>

				</header>

			</div>

			<div class="outer-container">
				<div class="content">
					<div class="container">
