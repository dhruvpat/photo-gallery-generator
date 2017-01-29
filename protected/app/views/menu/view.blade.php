
  <div class="page-content">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
    </div>
 	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons">
		<i class="icon-menu2"></i></a>
	</div>
    <div class="breadcrumb-line">
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('') }}">Home</a></li>
		<li><a href="{{ URL::to('items') }}">{{ $pageTitle }}</a></li>
        <li class="active"> view </li>
      </ul>
	  
	   <ul class="breadcrumb-buttons collapse">
			@if($access['is_add'] ==1)
	   		<li><a href="{{ URL::to('menu/add/'.$id) }}" title=""><i class="icon-pencil3"></i>&nbsp;</a></li>
			@endif  
			@if($access['is_remove'] ==1)
			<li ><a href="javascript://ajax"  onclick="SximoDelete();"  title=""><i class="icon-bubble-trash"></i>&nbsp;</a></li>
			@endif 	   
	   </ul>
	   	  
	</div>  
 {{ Form::open(array('url'=>'menu/destroy/', 'class'=>'form-horizontal' ,'ID' =>'SximoTable' )) }}
 <input type="checkbox" style="display:none" checked="checked" class="ids"  name="id[]" value="{{ $id }}" />
{{ Form::close() }}

<table class="table table-striped table-bordered" >
	<tbody>	

					<tr>
						<td width='30%' class='label-view text-right'>Parent Id</td>
						<td>{{ $row->parent_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Module</td>
						<td>{{ $row->module }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Menu Name</td>
						<td>{{ $row->menu_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Role Id</td>
						<td>{{ $row->role_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Deep</td>
						<td>{{ $row->deep }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ord</td>
						<td>{{ $row->ordering }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'> Icon</td>
						<td>{{ $row->menu_icons }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Active</td>
						<td>{{ $row->active }} </td>
						
					</tr>
				
	</tbody>	
</table>    

  