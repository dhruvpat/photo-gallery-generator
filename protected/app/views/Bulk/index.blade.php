
<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3>Bulk<small>Upload CSV option</small></h3>
      </div>
    </div>

	<div class="table-responsive">

	 <div class="col-md-5 box">
	{{ Form::open(array('url' => 'bulk/start','files' => true)) }}
	
	<div class="form-group">
		{{ Form::label('publish_start', 'Publish Start Date') }} <br />
		<small>Month</small> {{ Form::selectRange('publish_start_month', 1, 12) }} | <small>Year</small> {{ Form::selectRange('publish_start_year', 2010, 2030) }}
		
	</div>
	<div class="form-group">	
		{{ Form::label('publish_end', 'Publish End Date') }} <br />
		<small>Month</small> {{ Form::selectRange('publish_end_month', 1, 12) }} | <small>Year</small> {{ Form::selectRange('publish_end_year', 2010, 2030) }}
		
	</div>
	<div class="form-group">	
		{{ Form::label('skew', '% Probability of publishing in First Year') }}
		{{ Form::select('skew', array(
		'1' => 'Normal',
		'20' => '20%',
		'30' => '30%',
		'40' => '40%',
		'50' => '50%',
		'60' => '60%',
		'70' => '70%',
		'80' => '80%',
		'90' => '90%',
		'100' => '100%'

		),null,array('class' => 'form-control')) }}
	</div>
	<div class="form-group">
	<small><strong>Sample Probability Chart</strong><br>
	E.g. - If you select 70% for 5 years, the 5th year has a cumulative probability of 97% hanece remaining 3% will be added to the first year. 
	So probability of 1 yr - (70%+ 3% = 73%), 2 yr - (81% - 73% = 8%), 3 yr - (88% - 81% = 7%), 4 yr - (93% - 88% = 5%), 5 yr - (97% - 93% = 4%).
	</small><br />
	<img src="/sximo/images/probability-chart.png" width="436">
	
	</div>
	<div class="form-group">	
		{{ Form::label('auto_enable', 'Auto Enable all posts? ') }} 
		 {{ Form::checkbox('auto_enable', '1', true) }}
	 </div>
	<div class="form-group">	
		{{ Form::label('user_id', 'Enter ID of User') }}
		{{ Form::text('user_id','5',array('class' => 'form-control')) }}
		
		{{ $errors->first('user_id') }}
	</div>
	<div class="form-group">		
		{{ Form::label('file', 'Select CSV File') }}
		<small>CSV should be in format - title,excerpt,content,keyword,tag1,tag2,tag3</small>
		{{ Form::file('file') }}
		{{ $errors->first('file') }}
	</div>
	<div class="form-group">		
		<button class="btn btn-primary" type="submit">Submit</button>
	 {{ Form::close() }}
	 </div>
	
	</div>
		
	
</div>	  