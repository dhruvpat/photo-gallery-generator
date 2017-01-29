

	<!-- Portfolio small -->
	<h1 class="title">{{ $meta_h1 }}</h1>
	<section class="items small clear masonry">
	
	<!--Gallery Start-->
		@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'post','dataarray' => $posts))

	</section>
	<!-- // Portfolio small -->


	<div class="pagination">
			<?php echo $posts->links(); ?>
	</div>

