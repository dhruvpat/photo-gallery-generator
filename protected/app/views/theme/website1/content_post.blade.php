

	<!-- Portfolio small -->
	<h1 class="title">{{ $meta_h1 }}</h1>
	<?php if($content != '') { echo '<p>'.$content.'</p>'; } ?>
	<section class="items small clear masonry">
	
	<!--Gallery Start-->
		@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'image','dataarray' => $images))

	</section>
	<!-- // Portfolio small -->


	<div class="pagination">
			<?php echo $images->links(); ?>
	</div>
