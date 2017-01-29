<div class="main alpha right-aside">

	<section class="section">

		<article class="post">

			<h1 class="title">{{ $meta_h1 }}</h1>

			@foreach($imageinfo as $info)
			<div>
			<a href="{{ $info->img_src_big }}">
			<img src="{{ $info->img_src }}" alt="{{ $info->title }}" width="{{ $info->width_md }}" height="{{ $info->height_md }}" target="_blank">
			</a>
			<a name="error"></a>

			@if(Config::get('general.enable_ads') == '1') 
			<div class="mr10" style="padding-top:10px;">
			@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'single1'))
			</div>
			@endif
						<p>
			<a class="fltl" href="//www.pinterest.com/pin/create/button/?url={{ $info->slug }}&media={{ $info->img_src_big }}&description={{ $info->title }}"  data-pin-do="buttonPin" data-pin-config="none"><img src="/uploads/theme/{{ Config::get('general.theme_folder')}}/img/pinit.png"></a>
			
			<label style="margin-left:20px;">Label:</label> {{ $info->title }}</p>
			<div class="imageinfo fltl" style="width: 264px;">
			<?php if($info->content != '') { echo '<p>'.$info->content.'</p>'; } ?>
			<ul class="imagenote">
			<li>Category: {{ ucwords($info->post_keyword) }}</li>
			<li>Date: {{ date('m/d/y', strtotime($info->post_publish_date)) }}</li>
			<li>Reference: <a href="{{ $info->external_link }}" target="_blank" rel="nofollow">{{ $info->original_domain }}</a></li>
			</ul>

			</div>
			</div>
			@endforeach

		</article>
		
		<article class="post" style="padding-top:10px;">
		
		<h2>Related {{ $keyword }}</h2>
		
		<?php $i=1 ?>
		@foreach($allimages as $image)
		<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> conttn">
		<a href="/{{ $image->slug }}"><img src="{{ $image->img_src }}" alt="{{ $image->title }}" width="{{ $image->width_sm }}" height="{{ $image->height_sm }}">
		<span class="img-title">{{ $image->title }}</span></a>
		</div>
		<?php $i++ ?>
		@endforeach
		
		@if(Config::get('general.enable_ads') == '1') 
			<div class="conttn">
			@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'single2'))
			</div>
			@endif
		
		</article>
		
		<article class="post">
		<p class="message"><a href="/post/{{ $posturl }}">View all related images...</a></p>
		</article>
	</section>


</div><!-- // .main -->