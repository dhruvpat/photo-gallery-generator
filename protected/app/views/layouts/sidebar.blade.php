<div class="sidebar-content">


      <!-- Main navigation -->
	  {{--*/ $sidebar = SiteHelpers::menus('sidebar') /*--}}
      <ul class="navigation">
	  	<li class="bg-grey" ><a href="{{ URL::to('config/dashboard')}}"><span>Dashboard</span> <i class="icon-home"></i> </a></li>
		@foreach ($sidebar as $menu)
			 <li @if(Request::is($menu['module'])) class="active" @endif>
			 	<a href="{{ URL::to($menu['module'])}}" 
			 
				 @if(count($menu['childs']) > 0 ) class="expand level-closed" @endif>
			 		<span>{{$menu['menu_name']}}</span>  <i class="{{$menu['menu_icons']}}"></i>
				</a> 
				@if(count($menu['childs']) > 0)
					<ul>
						@foreach ($menu['childs'] as $menu2)
						 <li @if(Request::is($menu2['module'])) class="active" @endif>
						 	<a href="{{ URL::to($menu2['module'])}}" >
								<span>{{$menu2['menu_name']}}</span>  
							</a> 
						</li>							
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach
      </ul>
      <!-- /main navigation -->
 </div>