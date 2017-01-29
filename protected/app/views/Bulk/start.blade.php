
<div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3>Process<small>Start</small></h3>
      </div>
    </div>

	<div class="table-responsive">

	 <div class=".col-md-12">
	 @foreach($set as $row)
		Title - {{ $row['title'] }}<br>Slug- {{ $row['slug'] }}<br>User ID - {{ $row['user_id'] }}<br>Publish Date - {{ $row['publish_date'] }}<br><br>
	 @endforeach
	 </div>
	
	</div>
		
	
</div>	  