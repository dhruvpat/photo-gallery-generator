<!-- Login wrapper -->
<div class="login-wrapper">
<div class="panel panel-success">
<div class="panel-heading"><span class="text-semibold"><i class="icon-user-plus"></i> Register New Account </span></div>
<div class="panel-body">
 {{ Form::open(array('url'=>'user/create', 'class'=>'form-signup')) }}

	<ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>	
	
	<div class="form-group has-feedback">
		<label>First Name </label>
	  {{ Form::text('firstname', null, array('class'=>'form-control', 'placeholder'=>'First Name')) }}
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label>Last Name </label>
	 {{ Form::text('lastname', null, array('class'=>'form-control', 'placeholder'=>'Last Name')) }}
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label>Email </label>
	 {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label>Password</label>
	 {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
		<i class="icon-lock form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback">
		<label>Password</label>
	 {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
		<i class="icon-lock form-control-feedback"></i>
	</div>
					

      <div class="row form-actions">
        <div class="col-xs-6">
          
			
         
        </div>
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary pull-right"><i class="icon-menu2"></i> Sign Up</button>
        </div>
      </div>
   
 {{ Form::close() }}
 </div>
</div> 
</div>
<!-- /login wrapper -->