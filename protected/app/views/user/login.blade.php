
<!-- Login wrapper -->
<div class="login-wrapper">
<div class="panel panel-primary">
<div class="panel-heading"><span class="text-semibold"><i class="icon-user-plus"></i>  {{ CNF_APPNAME}}</span></div>


<div class="panel-body ">
 {{ Form::open(array('url'=>'user/signin', 'class'=>'form-vertical')) }}
	    	@if(Session::has('message'))
				{{ Session::get('message') }}
			@endif
				
	<div class="form-group has-feedback">
		<label>Email Address </label>
		{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
		<i class="icon-users form-control-feedback"></i>
	</div>
	
      <div class="form-group has-feedback">
        <label>Password <a  id="or"  href="javascript://ajax"> forgot password ? </a>	   </label>
       {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
        <i class="icon-lock form-control-feedback"></i>
		</div>
 	<div class="panel-footer " style="padding:10px;">
      <div class="form-group  has-feedback" >
        <div class="col-xs-6">         
         
         <button type="submit" class="btn btn-primary ">Sign in</button>
        </div>
        <div class="col-xs-6">         
           <a class="btn btn-default"  href="{{ URL::to('user/register')}}"> Create Account </a>
         
        </div>
      </div>	
	</div>
	  <div class="clr"></div>
 {{ Form::close() }}	  
 
{{ Form::open(array('url' => 'user/request', 'class'=>'form-vertical box bg-success','id'=>'fr' , 'style'=>'margin-top:20px; display:none; ')) }}

 	
       <div class="form-group has-feedback">
	   <div class="">
			<label>Enter Your Email Address </label>
		   {{ Form::text('credit_email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
			<i class="icon-envelope form-control-feedback"></i>
		</div> 	
		</div>
		<div class="form-group has-feedback">        
          <button type="submit" class="btn btn-default pull-right"> Reset My Password </button>        
      </div>
	  
	  <div class="clr"></div>
 {{ Form::close() }}		 

</div>	 	  
 

 
</div> 
</div>
<!-- /login wrapper -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#or').click(function(){
			$('#fr').toggle();
		});
	});
</script>