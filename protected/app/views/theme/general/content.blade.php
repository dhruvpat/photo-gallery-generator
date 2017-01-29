<div class="main alpha right-aside">

	<section class="section">

		<article class="post">

			<h1 class="title"><a href="post-3.html" class="alt">This is image post type with a full-width photography</a></h1>
			<div class="mr10 thumbnail-container"><img src="" style="width:300px; height:220px; background-color:#bbb">
			<span class="img-title">This is the title of the post</span>
			</div>
			<div class="thumbnail-container"><img src="" style="width:300px; height:220px; background-color:#bbb">
			<span class="img-title">This is the title of the post</span>
			</div>
			

		</article>

	</section>
	<section class="section">
		<ul class="parsley-error-list">
			@foreach($posts as $post)
				<li>{{ $post->img_filename }}</li>
				<li><img src="{{ $post->img_src }}" alt="{{ $post->img_title }}" width="{{ $post->img_width }}" height="{{ $post->img_height }}"></li>
			@endforeach
		</ul>
	</section>
	<section class="section">

		<div class="pagination">
			<a href="blog-right-sidebar.html" class="button active">1</a>
			<a href="blog-right-sidebar-2.html" class="button">2</a>
			<a href="blog-right-sidebar.html" class="button">3</a>
			&hellip;
			<a href="blog-right-sidebar-2.html" class="button">8</a>
			<a href="blog-right-sidebar-2.html" class="button"><span>&rsaquo;</span></a>
		</div>

	</section>

</div><!-- // .main -->