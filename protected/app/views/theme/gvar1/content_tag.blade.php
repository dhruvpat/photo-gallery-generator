<div class="main alpha right-aside">

	<section class="section">

		<article class="post">
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
			
			<!--Gallery Start-->
			@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'tag','dataarray' => $posts))
			
			
		</article>
		<div  style="clear:both"></div>
		<div class="pagination">
			<?php echo $posts->links(); ?>
		</div>


	</section>


</div><!-- // .main -->