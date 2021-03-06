
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
		<li><a href="{{ URL::to('Posts') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Posts/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
									
					  <div class="form-group  " >
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
						<label for="ipt" class=" control-label col-md-4 text-right"> Keyword </label>
						<div class="col-md-8">
						  {{ Form::text('keyword', $row['keyword'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Tag1 </label>
						<div class="col-md-8">
						  {{ Form::text('tag1', $row['tag1'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Tag2 </label>
						<div class="col-md-8">
						  {{ Form::text('tag2', $row['tag2'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Tag3 </label>
						<div class="col-md-8">
						  {{ Form::text('tag3', $row['tag3'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Featured </label>
						<div class="col-md-8">
						  {{ Form::text('featured', $row['featured'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Hits </label>
						<div class="col-md-8">
						  {{ Form::text('hits', $row['hits'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> User Id </label>
						<div class="col-md-8">
						  {{ Form::text('user_id', $row['user_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Workflow Stage </label>
						<div class="col-md-8">
						  {{ Form::text('workflow_stage', $row['workflow_stage'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Active </label>
						<div class="col-md-8">
						  {{ Form::text('active', $row['active'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Post Type </label>
						<div class="col-md-8">
						  {{ Form::text('post_type', $row['post_type'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Publish Date </label>
						<div class="col-md-8">
						  
				{{ Form::text('publish_date', $row['publish_date'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Created At </label>
						<div class="col-md-8">
						  
				{{ Form::text('created_at', $row['created_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
						 </div> 
					  </div> 					
					  <div class="form-group  " >
						<label for="ipt" class=" control-label col-md-4 text-right"> Updated At </label>
						<div class="col-md-8">
						  
				{{ Form::text('updated_at', $row['updated_at'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }} 
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
		 
	});
	</script>		 