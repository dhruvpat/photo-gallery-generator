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
		<li><a href="{{ URL::to('Posts') }}">{{ $pageTitle }}</a></li>
        <li class="active"> view </li>
      </ul>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>	  
	   <ul class="breadcrumb-buttons collapse">
	   		<li><a href="{{ URL::to('Posts') }}" class="tips" title="Back"><i class="icon-table"></i>&nbsp;</a></li>
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('Posts/add/'.$id) }}" class="tips" title="Edit"><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();" class="tips"  title="remove"><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
	 {{ Form::open(array('url'=>'Posts/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
	 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
	{{ Form::close() }}
	<div class="table-responsive">
	<table class="table table-striped table-bordered" >
		<tbody>	
	
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Title</td>
						<td>{{ $row->title }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Excerpt</td>
						<td>{{ $row->excerpt }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Content</td>
						<td>{{ $row->content }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Slug</td>
						<td>{{ $row->slug }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Keyword</td>
						<td>{{ $row->keyword }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tag1</td>
						<td>{{ $row->tag1 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tag2</td>
						<td>{{ $row->tag2 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tag3</td>
						<td>{{ $row->tag3 }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Featured</td>
						<td>{{ $row->featured }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Hits</td>
						<td>{{ $row->hits }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>User Id</td>
						<td>{{ $row->user_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Workflow Stage</td>
						<td>{{ $row->workflow_stage }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Active</td>
						<td>{{ $row->active }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Post Type</td>
						<td>{{ $row->post_type }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Publish Date</td>
						<td>{{ $row->publish_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ $row->updated_at }} </td>
						
					</tr>
				
		</tbody>	
	</table>    
	</div>
</div>
	  