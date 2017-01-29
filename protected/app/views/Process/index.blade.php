
<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> Process <small>Dashboard</small></h3>
      </div>
    </div>

	<div class="table-responsive">

	 <div class=".col-md-12">
	 <h5>Currently <strong>{{ $postnewkeywordcount }}</strong> of {{ $postcount }} pending to be processed...</h5>
	 </div>
	
	</div>
	
	<div class="table-responsive">
	 <div class="col-md-5 box">
	 
	 {{ Form::open(array('url' => 'process/start','files' => true,'method' => 'get')) }}
	 	<div class="form-group">
		{{ Form::label('keywords_process', 'Keywords to be processed?') }} <br />
		{{ Form::text('keywords_process',null,array('class' => 'form-control')) }}
		</div>
	 	
		<div class="form-group">		
		<button class="btn btn-primary" type="submit">Submit</button>
		{{ Form::close() }}
		</div>
	 
	 </div>
	</div>
		
	
</div>	  