<div class="main alpha right-aside">

	<section class="section">

		<article class="post">
			<?php if(count($tag1_array) != '0') { ?>
			
			<h1 class="title">Tags</h1>
			<ul class="tags">
			@foreach($tag1_array as $tag)
			<li><a href="/tags/{{ $tag->tag1 }}">{{ $tag->tag1 }}</a></li>
			@endforeach
			</ul>
			<?php } ?>
			<h1 class="title">{{ $meta_h1 }}</h1>
			
			<!--Gallery Start-->
			@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'image','dataarray' => $images))

		</article>
		<div  style="clear:both"></div>
		<div class="pagination">
			<?php echo $posts->links(); ?>
		</div>

	</section>


</div><!-- // .main -->