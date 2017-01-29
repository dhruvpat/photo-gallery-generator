
<?php $i=1; $j=1;?>
@foreach($dataarray as $row)
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> conttn">
<a href="/<?php if($type == 'post' OR $type == 'tag') { echo "post/"; } ?>{{ $row->slug }}"><img src="{{ $row->img_src }}" alt="{{ $row->title }}">
<span class="img-title">{{ $row->title }}</span></a>
<?php if($row->tag1 != "" AND $layout_type != 'post') { ?>
<span class="datebox">published in <b><a href="/tags/<?php echo $row->tag1; ?>"><?php echo ucwords(str_replace("-"," ",$row->tag1)); ?></a></b> on <b><?php echo date("d-m-Y", strtotime($row->publish_date)); ?></b></span>
<?php } elseif($layout_type != 'post') { ?>
<span class="datebox">published on <b><?php echo date("d-m-Y", strtotime($row->publish_date)); ?></b></span>
<?php } else {} ?>

</div>
<?php $i++; ?>
@if($j =='2' AND Config::get('general.enable_ads') =='1') 
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> conttn">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content1'))
</div>
<?php $i++; ?>
@endif

@if($j =='4' AND Config::get('general.enable_ads') =='1') 
<div class="<?php if ($i % 2 != 0) { print "mr10";} ?> conttn">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content2'))
</div>
<?php $i++; ?>
@endif
<?php $j++; ?>
@endforeach
		