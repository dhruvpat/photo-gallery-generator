
<!-- Full width -->
					<article class="post page" style="margin-top:-10px">
						<section class="main clear">
							<h1 class="title">{{ $meta_h1 }}</h1>
							@foreach($imageinfo as $info)
							<div class="content">

								<?php if($info->content != '') { echo '<p>'.$info->content.'</p>'; } ?>

								<div class="columns">
									
									<div class="column col-3-5">
										<div class="image">
										<a href="{{ $info->img_src_big }}">
										<img src="{{ $info->img_src }}" alt="{{ $info->title }}" width="100%" target="_blank">
										</a>
										</div>
										<p>
										
										@if(Config::get('general.enable_ads') == '1') 
										<div>
										@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'single1'))
										</div>
										@endif
										
									</div>
									<div class="column col-2-5 last">
									
										@if(Config::get('general.enable_ads') == '1') 
										<div>
										@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'single2'))
										</div>
										@endif

										
										<a style="float:left; margin-top:10px;width:100%" class="fltl" href="//www.pinterest.com/pin/create/button/?url={{ $info->slug }}&media={{ $info->img_src_big }}&description={{ $info->title }}" data-pin-do="buttonPin" data-pin-config="none" data-pin-color="red" data-pin-height="28">
										<img src="/uploads/img/pinit.png" /></a>

										
										<ul style="padding-left:10px;float:left">
											<li>Label: {{ $info->title }}</li>
											<li>Date: {{ date('m/d/y', strtotime($info->post_publish_date)) }}</li>
											<li>Reference: <a href="{{ $info->external_link }}" target="_blank" rel="nofollow">{{ $info->original_domain }}</a></li>
										</ul>
									<a name="error"></a>
									</div>
									
								</div>

							</div>
							@endforeach
						</section>
					</article>
					<!-- // Full width -->

					<h2>Related {{ $keyword }}</h2>
					<section class="items small clear masonry">
						
						
						<?php $i=1 ?>
						@foreach($allimages as $image)
						<article data-category="graphics photography" class="item masonry-brick">
							<div class="image">
							<a href="/{{ $image->slug }}"><img src="{{ $image->img_src }}" alt="{{ $image->title }}" width="{{ $image->width_sm }}" height="{{ $image->height_sm }}"></a>
							
							</div>
								<section class="main">
								<span class="title"><a href="/{{ $image->slug }}">{{ $image->title }}</a></span>
								</section>
						</article>
						<?php $i++ ?>
						
							@if($i =='4' AND Config::get('general.enable_ads') =='1') 
							<article data-category="graphics photography" class="item">
							@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content1'))
							</article>
							@endif
						
						@endforeach
						<article data-category="graphics photography" class="item masonry-brick">
						<section class="main viewall">
							<span class="title"><a href="/post/{{ $posturl }}">View all related images...</a></span>
						</section>
						</article>
					</section>
					
					
					
					
								
