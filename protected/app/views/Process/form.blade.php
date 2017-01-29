
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>

    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
		<li><a href="{{ URL::to('Images') }}">{{ $pageTitle }}</a></li>
        <li class="active"> Add </li>
      </ul>
	</div>  
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
		
	<div class="panel panel-default">
		<div class="panel-heading"><div class="panel-title"> Create {{ $pageTitle }} </div></div>
		<div class="panel-body">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'Images/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
									
					  <div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label col-md-4 text-right"> Id </label>
						<div class="col-md-8">
						  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Title </label>
						<div class="col-md-8">
						  {{ Form::text('title', $row['title'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Excerpt </label>
						<div class="col-md-8">
						  {{ Form::text('excerpt', $row['excerpt'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Content </label>
						<div class="col-md-8">
						  <textarea name='content' rows='2' id='content' class='form-control '  
				           >{{ $row['content'] }}</textarea> 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Slug </label>
						<div class="col-md-8">
						  {{ Form::text('slug', $row['slug'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Post Id </label>
						<div class="col-md-8">
						  <select name='post_id' rows='5' id='post_id' code='{$post_id}' 
							class='select2 form-control '    ></select> 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Filename </label>
						<div class="col-md-8">
						  {{ Form::text('filename', $row['filename'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Extension </label>
						<div class="col-md-8">
						  {{ Form::text('extension', $row['extension'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Active </label>
						<div class="col-md-8">
						  <?php $active = explode(",",$row['active']); ?>
					 <label class='checked checkbox-inline'>  
					<input type='checkbox' name='active[]' value ='1'   class='' 
					@if(in_array('1',$active))checked @endif 
					 /> Yes </label>  
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Featured </label>
						<div class="col-md-8">
						  <?php $featured = explode(",",$row['featured']); ?>
					 <label class='checked checkbox-inline'>  
					<input type='checkbox' name='featured[]' value ='1'   class='' 
					@if(in_array('1',$featured))checked @endif 
					 /> Yes </label>  
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Width Sm </label>
						<div class="col-md-8">
						  {{ Form::text('width_sm', $row['width_sm'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Height Sm </label>
						<div class="col-md-8">
						  {{ Form::text('height_sm', $row['height_sm'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Width Md </label>
						<div class="col-md-8">
						  {{ Form::text('width_md', $row['width_md'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Height Md </label>
						<div class="col-md-8">
						  {{ Form::text('height_md', $row['height_md'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Width Bg </label>
						<div class="col-md-8">
						  {{ Form::text('width_bg', $row['width_bg'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Height Bg </label>
						<div class="col-md-8">
						  {{ Form::text('height_bg', $row['height_bg'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Original Image Url </label>
						<div class="col-md-8">
						  {{ Form::text('original_image_url', $row['original_image_url'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Original Page Url </label>
						<div class="col-md-8">
						  {{ Form::text('original_page_url', $row['original_page_url'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Original Domain </label>
						<div class="col-md-8">
						  {{ Form::text('original_domain', $row['original_domain'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Hits </label>
						<div class="col-md-8">
						  {{ Form::text('hits', $row['hits'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label col-md-4 text-right"> Created At </label>
						<div class="col-md-8">
						  {{ Form::text('created_at', $row['created_at'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group hidethis " style="display:none;">
						<label for="ipt" class=" control-label col-md-4 text-right"> Updated At </label>
						<div class="col-md-8">
						  {{ Form::text('updated_at', $row['updated_at'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  Submit </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>
	
</div>				 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		$("#post_id").jCombo("{{ URL::to('Images/comboselect?filter=tb_posts::title') }}",
		{  selected_value : '{{ $row['post_id'] }}' });
		 
	});
	</script>		 