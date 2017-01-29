
<?php $i=1; $j=1;?>
@foreach($dataarray as $row)
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> thumbnail-container">
<a href="/<?php if($type == 'post') { echo "post/"; } ?>{{ $row->slug }}"><img src="{{ $row->img_src }}" alt="{{ $row->title }}" width="{{ $row->width_sm }}" height="{{ $row->height_sm }}">
<span class="img-title">{{ $row->title }}</a></span>
</div>
<?php $i++; ?>
@if($j =='2' AND Config::get('general.enable_ads') =='1') 
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> thumbnail-container">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content1'))
</div>
<?php $i++; ?>
@endif

@if($j =='4' AND Config::get('general.enable_ads') =='1') 
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> thumbnail-container">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content2'))
</div>
<?php $i++; ?>
@endif
<?php $j++; ?>
@endforeach
		