
<?php $theme_folder = Config::get("general.theme_folder"); ?>

@include('theme.'.$theme_folder.'.header')

@if ($layout_type == 'page')
	@include('theme.'.$theme_folder.'.content_page')
@elseif ($layout_type == 'post')
	@include('theme.'.$theme_folder.'.content_post')
@elseif ($layout_type == 'image')
	@include('theme.'.$theme_folder.'.content_image')
@elseif ($layout_type == 'tag')
	@include('theme.'.$theme_folder.'.content_tag')
@else
	@include('theme.'.$theme_folder.'.content_index')
@endif

@include('theme.'.$theme_folder.'.sidebar')
@include('theme.'.$theme_folder.'.footer')

 
 