<div class="main alpha right-aside">

	<section class="section">

		<article class="post">

			<h1 class="title">{{ $meta_h1 }}</h1>
			<?php if($content != '') { echo '<p>'.$content.'</p>'; } ?>
			
			<!--Gallery Start-->
			@include('theme.'.$theme_folder.'.content_imagelisting', array('type'=>'image','dataarray' => $images))
			

		</article>
		<div  style="clear:both"></div>
		<div class="pagination">
			<?php echo $images->links(); ?>
		</div>


	</section>


</div><!-- // .main -->