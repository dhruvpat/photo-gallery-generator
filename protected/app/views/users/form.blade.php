
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
		<li><a href="{{ URL::to('users') }}">{{ $pageTitle }}</a></li>
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
		 {{ Form::open(array('url'=>'users/save/'.SiteHelpers::encryptID($row['id']), 'class'=>'form-horizontal','files' => true ,'parsley-validate novalidate'=>'')) }}
									
				  <div class="form-group hidethis " style="display:none;">
					<label for="ipt" class=" control-label col-md-4 text-right"> Id </label>
					<div class="col-md-8">
					  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Group / Level </label>
					<div class="col-md-8">
					  <select name='group_id' rows='5' id='group_id' code='{$group_id}' 
							class='select2 form-control '  required  ></select> 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Username </label>
					<div class="col-md-8">
					  {{ Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> First Name </label>
					<div class="col-md-8">
					  {{ Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Last Name </label>
					<div class="col-md-8">
					  {{ Form::text('last_name', $row['last_name'],array('class'=>'form-control ')) }} 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Email </label>
					<div class="col-md-8">
					  {{ Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'' )) }} 
					 </div> 
				  </div> 										
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Status </label>
					<div class="col-md-8">
					  
					<label class='checked'>
					<input type='radio' name='active' value ='0' required @if($row['active'] == '0') checked="checked" @endif > Inactive </label>
					<label class='checked'>
					<input type='radio' name='active' value ='1' required @if($row['active'] == '1') checked="checked" @endif > Active </label> 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Avatar </label>
					<div class="col-md-8">
					  <input  type='file' name='avatar' id='avatar' class=''  
					 style='width:150px !important;'  />
					{{ SiteHelpers::showUploadedFile($row['avatar'],'/uploads/users/') }}
				 
					 </div> 
				  </div> 
		
	<div class="form-group">
		<hr />
	<label for="ipt" class=" control-label col-md-4 text-left" > </label>
	<div class="col-md-8">
		@if($row['id'] !='')
			Leave blank if you dont want to change current password
		@else
			Create Password
		@endif	 
	</div>
	</div>		  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> New Password </label>
		<div class="col-md-8">
		<input name="password" type="password" id="password" class="form-control input-sm" value=""
		@if($row['id'] =='')
			required
		@endif
		 /> 
		 </div> 
	  </div>  
	  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Confirm Password </label>
		<div class="col-md-8">
		<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value=""
		@if($row['id'] =='')
			required
		@endif		
		 />  
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
		

		$("#group_id").jCombo("{{ URL::to('users/comboselect?filter=tb_groups:group_id:name') }}",
		{  selected_value : '{{ $row['group_id'] }}' });
		 
	});
	</script>		 