


				<?php if($tag3 != '') { ?>

			<?php } elseif ($tag2 != '' AND $show_tag) { ?>
				
				<h1 class="title">Tags</h1>
				<ul class="tags">
				@foreach($tag3_array as $tag)
				<li><a href="/tags/{{ $tag1 }}/{{ $tag2 }}/{{ $tag->tag3 }}"><?php echo ucwords(str_replace("-"," ",$tag->tag3)); ?></a></li>
				@endforeach
				</ul>
			
			<?php } elseif ($show_tag) { ?>
			<h1 class="title">Tags</h1>
			<ul class="tags">
			@foreach($tag2_array as $tag)
			<li><a href="/tags/{{ $tag1 }}/{{ $tag->tag2 }}"><?php echo ucwords(str_replace("-"," ",$tag->tag2)); ?></a></li>
			@endforeach
			</ul>
			
			
			<?php } else {} ?>
			<h1 class="title">{{ $meta_h1 }}</h1>
	<section class="items small clear masonry" style="position: relative; height: 824px;">
	
	<!--Gallery Start-->
		@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'tag','dataarray' => $posts))

	</section>
	<!-- // Portfolio small -->


	<div class="pagination">
			<?php echo $posts->links(); ?>
	</div>
