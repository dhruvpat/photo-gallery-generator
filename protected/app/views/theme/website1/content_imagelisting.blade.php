
<?php $i=1; $j=1;?>
@foreach($dataarray as $row)
<article data-category="graphics photography" class="item">
	<div class="image">
		<a href="/<?php if($type == 'post' OR $type == 'tag') { echo "post/"; } ?>{{ $row->slug }}">
			<img src="{{ $row->img_src }}" alt="{{ $row->title }}" width="{{ $row->width_sm }}" height="{{ $row->height_sm }}" class="responsive">
			<span class="hover"></span>
		</a>
	</div>
	<section class="main">
		<span class="title"><a href="/<?php if($type == 'post' OR $type == 'tag') { echo "post/"; } ?>{{ $row->slug }}">{{ $row->title }}</a></span><br />
		<?php if($row->tag1 != "" AND $layout_type != 'post') { ?>
		<span class="datebox">published in <b><a href="/tags/<?php echo $row->tag1; ?>"><?php echo ucwords(str_replace("-"," ",$row->tag1)); ?></a></b> on <b><?php echo date("d-m-Y", strtotime($row->publish_date)); ?></b></span>
		<?php } elseif($layout_type != 'post') { ?>
		<span class="datebox">published on <b><?php echo date("d-m-Y", strtotime($row->publish_date)); ?></b></span>

		<?php } else {} ?>
	</section>
</article>
<?php $i++; ?>

@if($j =='2' AND Config::get('general.enable_ads') =='1') 
<article data-category="graphics photography" class="item">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content1'))
</article>
<?php $i++; ?>
@endif

@if($j =='4' AND Config::get('general.enable_ads') =='1') 
<article data-category="graphics photography" class="item">
@include('theme.'.$theme_folder.'.ads', array('ad_type'=>'content2'))
</article>

<?php $i++; ?>
@endif
<?php $j++; ?>
@endforeach