
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
		<li><a href="{{ URL::to('Staticpages') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'Staticpages/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
									
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
						  <textarea name='content' rows='2' id='editor' class='form-control editor '  
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
						<label for="ipt" class=" control-label col-md-4 text-right"> Active </label>
						<div class="col-md-8">
						  
					<label class='radio radio-inline'>
					<input type='radio' name='active' value ='1'  @if($row['active'] == '1') checked="checked" @endif > active </label>
					<label class='radio radio-inline'>
					<input type='radio' name='active' value ='0'  @if($row['active'] == '0') checked="checked" @endif > inactive </label> 
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
		 
	});
	</script>		 