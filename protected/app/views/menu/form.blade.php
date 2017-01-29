
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
		<li><a href="{{ URL::to('menu') }}">{{ $pageTitle }}</a></li>
        <li class="active"> Add </li>
      </ul>
	</div>  
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
		
	<div class="panel panel-default">
		<div class="panel-heading"><div class="panel-title"> Create $pageTitle </div></div>
		<div class="panel-body">

		<ul class="errorItemValidate">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'menu/save/', 'class'=>'form-horizontal','files' => true)) }}
									
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Menu Id </label>
					<div class="col-md-8">
					  {{ Form::text('menu_id', $row['menu_id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Parent Id </label>
					<div class="col-md-8">
					  {{ Form::text('parent_id', $row['parent_id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Module </label>
					<div class="col-md-8">
					  {{ Form::text('module', $row['module'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Url </label>
					<div class="col-md-8">
					  {{ Form::text('url', $row['url'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Menu Name </label>
					<div class="col-md-8">
					  {{ Form::text('menu_name', $row['menu_name'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Menu Type </label>
					<div class="col-md-8">
					  {{ Form::text('menu_type', $row['menu_type'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Role Id </label>
					<div class="col-md-8">
					  {{ Form::text('role_id', $row['role_id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Deep </label>
					<div class="col-md-8">
					  {{ Form::text('deep', $row['deep'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Ordering </label>
					<div class="col-md-8">
					  {{ Form::text('ordering', $row['ordering'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Position </label>
					<div class="col-md-8">
					  {{ Form::text('position', $row['position'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Menu Icons </label>
					<div class="col-md-8">
					  {{ Form::text('menu_icons', $row['menu_icons'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Active </label>
					<div class="col-md-8">
					  {{ Form::text('active', $row['active'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 
			  <div class="row form-actions">
				<label class="col-sm-3 text-right">&nbsp;</label>
				<div class="col-sm-9">	
				<button type="submit" class="btn btn-primary ">  Submit </button>
				</div>	  
		
			  </div> 
		 
		 {{ Form::close() }}
		</div>
	</div>
	
</div>				 
		 