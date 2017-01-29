<div class="wrapper-header ">
    <div class="page-header container">
		<div class="col-sm-6 col-xs-6">
		  <div class="page-title">
			<h3> {{$pageTitle}} <small> {{$pageNote}} </small></h3>
		  </div>
		</div>
		<div class="col-sm-6 col-xs-6 ">
		  <ul class="breadcrumb pull-right">
			<li><a href="{{ URL::to('') }}">Home</a></li>
			<li class="active">About Us </li>
		  </ul>		
		</div>
		  
    </div>
</div>	
	
<div class="wrapper-container container">
	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>	
	<ul class="nav nav-tabs" >
	  <li class="active"><a href="#info" data-toggle="tab"> Info </a></li>
	  <li ><a href="#pass" data-toggle="tab"> Change Password </a></li>
	</ul>	
	
<div class="tab-content">
  <div class="tab-pane active use-padding" id="info">
	{{ Form::open(array('url'=>'user/saveprofile/', 'class'=>'form-horizontal ')) }}  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Username </label>
		<div class="col-md-8">
		<input name="username" type="text" id="username" disabled="disabled" class="form-control input-sm" required  value="{{ $info->username }}" />  
		 </div> 
	  </div>  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">Email Address </label>
		<div class="col-md-8">
		<input name="email" type="text" id="email" disabled="disabled" class="form-control input-sm" value="{{ $info->email }}" /> 
		 </div> 
	  </div> 	  
  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> First Name </label>
		<div class="col-md-8">
		<input name="first_name" type="text" id="first_name" class="form-control input-sm" required value="{{ $info->first_name }}" /> 
		 </div> 
	  </div>  
	  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Last Name </label>
		<div class="col-md-8">
		<input name="last_name" type="text" id="last_name" class="form-control input-sm" required value="{{ $info->last_name }}" />  
		 </div> 
	  </div>    

  

	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
		<div class="col-md-8">
			<button class="btn btn-success" type="submit"> Submit</button>
		 </div> 
	  </div> 	
	
	{{ Form::close() }}	
  </div>
  
  <div class="tab-pane use-padding" id="pass">
	{{ Form::open(array('url'=>'user/savepassword/', 'class'=>'form-horizontal ')) }}    
	  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> New Password </label>
		<div class="col-md-8">
		<input name="password" type="password" id="password" class="form-control input-sm" value="" /> 
		 </div> 
	  </div>  
	  
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4"> Confirm Password </label>
		<div class="col-md-8">
		<input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />  
		 </div> 
	  </div>    
	 
	
	  <div class="form-group">
		<label for="ipt" class=" control-label col-md-4">&nbsp;</label>
		<div class="col-md-8">
			<button class="btn btn-danger" type="submit"> Save New Password</button>
		 </div> 
	  </div>   
  	{{ Form::close() }}	
  </div>
  
</div>



	</div>	  