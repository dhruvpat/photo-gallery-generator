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
			<p>
			<a style="float:left;" href="//www.pinterest.com/pin/create/button/?url={{ $info->slug }}&media={{ $info->img_src_big }}&description={{ $info->title }}"  data-pin-do="buttonPin" data-pin-config="none"><img src="/uploads/theme/{{ Config::get('general.theme_folder')}}/img/pinit.png" style="float:left;"></a>
			
			<label style="margin-left:20px;">Label:</label> {{ $info->title }}</p>
			@if(Config::get('general.enable_ads') == '1') 
			<div class="mr10">
			@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'single2'))
			</div>
			@endif
			
			<div class="imageinfo" style="float:left; width: 264px;">
			<?php if($info->content != '') { echo '<p>'.$info->content.'</p>'; } ?>
			<ul class="imagenote">
			<li>Category: {{ ucwords($info->post_keyword) }}</li>
			<li>Date: {{ date('m/d/y', strtotime($info->post_publish_date)) }}</li>
			<li>Reference: <a href="{{ $info->external_link }}" target="_blank" rel="nofollow">{{ $info->original_domain }}</a></li>
			</ul>
			<div class="downform" style="padding:10px; border: solid 2px #eee">
			<h2>H2 Title Here</h2>
			{{ Form::open(array('url' => 'download')) }}
			
			   
				@foreach($errors->all() as $message)
				 <p data-message-closable="true" class="message red"><i class="icon-cancel-circled"></i>{{ $message }}</p>
				@endforeach
				
			<p>
			{{-- Width. ------------------------}}
			{{ Form::label('width', 'Width') }}
			<?php if(Input::old('width')) { ?>{{ Form::text('width',Input::old('width')) }}<?php } else { ?>{{ Form::text('width',$info->width_bg) }}<?php } ?>
			{{-- Height. ------------------------}}
			x {{ Form::label('height', 'Height') }}
			<?php if(Input::old('height')) { ?>{{ Form::text('height',Input::old('height')) }}<?php } else { ?>{{ Form::text('height',$info->height_bg) }}<?php } ?>
			</p><p>
			{{-- Effect. ------------------------}}
			{{ Form::label('effect', 'Effect') }}
			{{ Form::select('effect', array('og' => 'Original', 'bw' => 'Black/White', 'sp' => 'Sepia'),Input::old('effect')) }}
			</p><p>
			
			
			{{ Form::hidden('path', '/'.$info->keyword.'/'.$info->slug.'.'.$info->extension.'') }}
			{{ Form::hidden('slug', ''.$info->slug.'') }}
			{{ Form::hidden('extension', ''.$info->extension.'') }}
			{{ Form::hidden('currentwidth', ''.$info->width_bg.'') }}
			{{ Form::hidden('currentheight', ''.$info->height_bg.'') }}
			{{ Form::submit('Download') }}
			</p>
			{{ Form::close() }}
			</div>
			</div>
			</div>
			@endforeach

		</article>
		
		<article class="post" style="padding-top:10px;">
		
		<h2>Related {{ $keyword }}</h2>
		
		<?php $i=1 ?>
		@foreach($allimages as $image)
		<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> thumbnail-container">
		<a href="/{{ $image->slug }}"><img src="{{ $image->img_src }}" alt="{{ $image->title }}" width="{{ $image->width_sm }}" height="{{ $image->height_sm }}">
		<span class="img-title">{{ $image->title }}</a></span>
		</div>
		<?php $i++ ?>
		@endforeach
		
		</article>
		
		<article class="post">
		<p class="message"><a href="/post/{{ $posturl }}">View all related images...</a></p>
		</article>
	</section>


</div><!-- // .main -->