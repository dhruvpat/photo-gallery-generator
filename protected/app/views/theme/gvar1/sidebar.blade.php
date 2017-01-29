<aside class="aside beta">

<section class="section">

<h2>Latest Posts</h2>

<!--Gallery Start-->
	<?php $i=1 ?>
	@foreach($latestposts as $post)
	<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> smalltn">
	<a href="/post/{{ $post->slug }}"><img src="{{ $post->img_src }}" alt="{{ $post->img_title }}">
	<span>{{ $post->title }}</span></a>
	</div>
	<?php $i++ ?>
	@endforeach
	

<div style="clear:both"></div>
	
@if(Config::get('general.enable_ads') == '1') 
	@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'sidebar'))
@endif
</section>


</aside>