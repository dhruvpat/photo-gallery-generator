
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
        <li class="active">{{ $pageTitle }}</li>
      </ul>

	</div>  	
	@if(Session::has('message'))	  
		   {{ Session::get('message') }}
	@endif	
	<ul class="nav nav-tabs" style="margin-bottom:10px;">
		<li @if($active == 'top') class="active" @endif ><a href="{{ URL::to('menu?pos=top')}}"><i class="icon-paragraph-justify2"></i> Top Menu </a></li>
		<li @if($active == 'sidebar') class="active" @endif><a href="{{ URL::to('menu?pos=sidebar')}}"><i class="icon-paragraph-justify2"></i> Sidemenu</a></li>	
	</ul>  	
	
	
		<div class="col-sm-5">

		<div class="box well">
 <div class="infobox infobox-info fade in">
  <button type="button" class="close" data-dismiss="alert"> x </button>  
  <p> <strong>Tips !</strong> Drag and drop rows to re ordering lists </p>	
</div>

            <div id="list2" class="dd" style="min-height:350px;">
              <ol class="dd-list">
			@foreach ($menus as $menu)
				  <li data-id="{{$menu['menu_id']}}" class="dd-item dd3-item">
					<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu['menu_name']}}
						<span class="pull-right">
						<a href="{{ URL::to('menu/index/'.$menu['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a></span>
					</div>
					@if(count($menu['childs']) > 0)
						<ol class="dd-list" style="">
							@foreach ($menu['childs'] as $menu2)
							 <li data-id="{{$menu2['menu_id']}}" class="dd-item dd3-item">
								<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$menu2['menu_name']}}
									<span class="pull-right">
									<a href="{{ URL::to('menu/index/'.$menu2['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a></span>
								</div>
								@if(count($menu2['childs']) > 0)
								<ol class="dd-list" style="">
									@foreach($menu2['childs'] as $menu3)
									 	<li data-id="{{$menu3['menu_id']}}" class="dd-item dd3-item">
											<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{ $menu3['menu_name'] }}
												<span class="pull-right">
												<a href="{{ URL::to('menu/index/'.$menu3['menu_id'].'?pos='.$active)}}"><i class="icon-cogs"></i></a>
												</span>
											</div>
										</li>	
									@endforeach
								</ol>
								@endif
							</li>							
							@endforeach
						</ol>
					@endif
				</li>
			@endforeach			  
              </ol>
            </div>
		 {{ Form::open(array('url'=>'menu/saveorder/', 'class'=>'form-horizontal','files' => true)) }}	
			<input type="hidden" name="reorder" id="reorder" value="" />
 <div class="infobox infobox-danger fade in">
 <p> <strong>Please Note !</strong> , Menus only support 3 level !	</p>
</div>			
		
			<button type="submit" class="btn btn-primary ">  Re Order Menu </button>	
		 {{ Form::close() }}	
		 </div>
		</div>
		<div class="col-sm-7">
		 {{ Form::open(array('url'=>'menu/save/', 'class'=>'form-horizontal','files' => true)) }}
				<div class=" box">	

				<div class="header"> <h3> Form Add / Edit Menu </h3></div>
				<input type="hidden" name="menu_id" id="menu_id" value="{{ $row['menu_id'] }}" />									
				  <div class="form-group  ">
					<label for="ipt" class=" control-label col-md-4 text-right">  </label>
					<div class="col-md-8">
		 				<ul class="parsley-error-list">
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					 </div> 
				  </div> 
				
				<input type="hidden" name="menu_id" id="menu_id" value="{{ $row['menu_id'] }}" />									
				  <div class="form-group  " style="display:none;">
					<label for="ipt" class=" control-label col-md-4 text-right"> Parent Id </label>
					<div class="col-md-8">
					  {{ Form::text('parent_id', $row['parent_id'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Menu Name </label>
					<div class="col-md-8">
					  {{ Form::text('menu_name', $row['menu_name'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					 </div> 
				  </div> 
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Type </label> 
					<div class="col-md-8 ">
					<label class="radio-inline">
						
					<input type="radio" name="menu_type" onclick="mType(this.value)" value="internal" class="styled" 
					@if($row['menu_type']=='internal' || $row['menu_type']=='') checked="checked" @endif />
					
					Internal
					</label>
					<label class="radio-inline">
					<input type="radio" name="menu_type" onclick="mType(this.value)" value="external"  class="styled" 
					@if($row['menu_type']=='external' || $row['menu_type']=='') checked="checked" @endif  /> External 
					</label>	  
					 </div> 
				  </div> 	
				  			  					
				  <div class="form-group  ext-link" >
					<label for="ipt" class=" control-label col-md-4 text-right"> Url  </label>
					<div class="col-md-8">
					   {{ Form::text('url', $row['url'],array('class'=>'form-control', 'placeholder'=>' Type External Url')) }} 
					 </div> 
				  </div> 	
								  					
				  <div class="form-group  int-link" >
					<label for="ipt" class=" control-label col-md-4 text-right"> Module </label>
					<div class="col-md-8">
					  <select name='module' rows='5' id='module'  style="width:100%" 
							class='select-liquid '    >
							<option value=""> -- Select Module or Page -- </option>
							<optgroup label="Module ">
							@foreach($modules as $mod)
								<option value="{{ $mod->module_name}}"
								@if($row['module']== $mod->module_name ) selected="selected" @endif
								>{{ $mod->module_title}}</option>
							@endforeach
							</optgroup>
					
					</select> 		
					 </div> 
				  </div> 										
					

				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Position </label>
					<div class="col-md-8">
						<input type="radio" name="position"  value="top" required 
						@if($row['position']=='top' ) checked="checked" @endif /> Top Menu 
						<input type="radio" name="position"  value="sidebar"  required
						@if($row['position']=='sidebar' ) checked="checked" @endif  /> Side Menu 
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Icons Class </label>
					<div class="col-md-8">
					  {{ Form::text('menu_icons', $row['menu_icons'],array('class'=>'form-control', 'placeholder'=>'')) }} 
					  <p> you can use <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"> Font Awesome </a>  and <a href="http://icomoon.io/" target="_blank"> Icomoon </a> class name</p>
					 </div> 
				  </div> 					
				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4 text-right"> Active </label>
					<div class="col-md-8">
					<input type="radio" name="active"  value="1" 
					@if($row['active']=='1' ) checked="checked" @endif /> Active 
					<input type="radio" name="active" value="0" 
					@if($row['active']=='0' ) checked="checked" @endif  /> Inactive 
										
					 
					 </div> 
				  </div> 

			  <div class="form-group">
				<label for="ipt" class=" control-label col-md-4">Menu Access <code>*</code></label>
				<div class="col-md-8">
						<?php 
					$pers = json_decode($row['access_data'],true);
					foreach($groups as $group) {
						$checked = '';
						if(isset($pers[$group->group_id]) && $pers[$group->group_id]=='1')
						{
							$checked= ' checked="checked"';
						}						
							?>		
				  <label class="checkbox">
				  <input type="checkbox" name="groups[<?php echo $group->group_id;?>]" value="<?php echo $group->group_id;?>" <?php echo $checked;?>  />   
				  <?php echo $group->name;?>  
				  </label>
			
				  <?php } ?>
						 </div> 
			  </div> 

				  <div class="form-group  " >
					<label for="ipt" class=" control-label col-md-4"> Guest Mode ( Unlogged )  </label>
					<div class="col-md-8">
					<label class="checkbox"><input  type='checkbox' name='allow_guest' 
 						@if($row['allow_guest'] ==1 ) checked  @endif	
					   value="1"	/> Yes  </lable>
					</label>   
				  </div>
				</div>
				  
			  <div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
				<button type="submit" class="btn btn-primary ">  Submit </button>
				@if($row['menu_id'] !='')
					<button type="button"onclick="SximoConfirmDelete('{{ URL::to('menu/destroy/'.$row->menu_id)}}')" class="btn btn-danger ">  Delete </button>
				@endif	
				</div>	  
		
			  </div> 
			
		</div>	  
		 
		 {{ Form::close() }}		
		
		
		
		</div>
	
	</div>


	
	
<script>
$(document).ready(function(){

    update_out('#list2',"#reorder");
    
    $('#list2').on('change', function() {
		var out = $('#list2').nestable('serialize');
		$('#reorder').val(JSON.stringify(out));	  

    });
		$('.ext-link').hide(); 
		
});	

function mType(val) {
	if(val == 'external') {
		$('.ext-link').show(); 
		$('.int-link').hide();
	} else {
		$('.ext-link').hide(); 
		$('.int-link').show();
	}
}


function update_out(selector, sel2){
	
	var out = $(selector).nestable('serialize');
	$(sel2).val(JSON.stringify(out));

}
</script>		 
		 	  