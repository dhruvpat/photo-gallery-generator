<aside class="aside beta">

	<section class="section">
	@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'sidebar'))
		<h2>Latest Posts</h2>
		
			<?php $i=1 ?>
			@foreach($latestposts as $post)
			<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> smalltn">
			<a href="/post/{{ $post->slug }}"><img src="{{ $post->img_src }}" alt="{{ $post->img_title }}" width="145" height="100">
			<span>{{ $post->title }}</a></span>
			</div>
			<?php $i++ ?>
			@endforeach
			

		
		<div style="clear:both"></div>
		
		
	</section>


</aside>