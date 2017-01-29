
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
		<li><a href="{{ URL::to('groups') }}">{{ $pageTitle }}</a></li>
        <li class="active"> Add </li>
      </ul>
	</div>  
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
		
	<div class="panel panel-default">
		<div class="panel-heading"><div class="panel-title"> Create {{ $pageTitle }} </div></div>
		<div class="panel-body">

		<ul class="errorItemValidate">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		 {{ Form::open(array('url'=>'groups/save/', 'class'=>'form-horizontal','files' => true)) }}
									
				  <div class="form-group hidethis " style="display:none;">
					<label for="ipt" class=" control-label col-md-4 text-right"> Group Id </label>
					<div class="col-md-8">
					  {{ Form::text('group_id', $row['group_id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Name </label>
					<div class="col-md-8">
					  {{ Form::text('name', $row['name'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Description </label>
					<div class="col-md-8">
					  <textarea name='description' rows='2' id='description' class='form-control '  
				           >{{ $row['description'] }}</textarea> 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Level </label>
					<div class="col-md-8">
					  {{ Form::text('level', $row['level'],array('class'=>'form-control', 'placeholder'=>'')) }} 
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
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 