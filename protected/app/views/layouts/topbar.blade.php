{{--*/ $menus = SiteHelpers::menus('top') /*--}}
 	  <ul class="nav navbar-nav navbar-collapse collapse"  id="topmenu">
		@foreach ($menus as $menu)
			 <li class="@if(Request::is($menu['module'])) active @endif" >
			 	<a href="{{ URL::to($menu['module'])}}" 
			 
				 @if(count($menu['childs']) > 0 ) class="dropdown-toggle" data-toggle="dropdown" @endif>
			 		<i class="{{$menu['menu_icons']}}"></i><span>{{$menu['menu_name']}}</span>
					@if(count($menu['childs']) > 0 )
					 <b class="caret"></b> 
					@endif  
				</a> 
				@if(count($menu['childs']) > 0)
					 <ul class="dropdown-menu">
						@foreach ($menu['childs'] as $menu2)
						 <li class=" 
						 @if(count($menu2['childs']) > 0) dropdown-submenu @endif
						 @if(Request::is($menu2['module'])) active @endif">
						 	<a href="{{ URL::to($menu2['module'])}}" >
								<i class="{{$menu2['menu_icons']}}"></i> {{$menu2['menu_name']}}
							</a> 
							@if(count($menu2['childs']) > 0)
							<ul class="dropdown-menu dropdown-menu-right">
								@foreach($menu2['childs'] as $menu3)
									<li @if(Request::is($menu3['module'])) class="active" @endif>
										<a href="{{ URL::to($menu3['module'])}}" >
											<span>{{$menu3['menu_name']}}</span>  
										</a>
									</li>	
								@endforeach
							</ul>
							@endif							
							
						</li>							
						@endforeach
					</ul>
				@endif
			</li>
		@endforeach  
  </ul> 
  
    <ul class="nav navbar-nav navbar-collapse collapse  navbar-right" id="toolmenu">
	@if(!Auth::check())  
		<li><a href="{{ URL::to('user/login')}}"><i class="icon-arrow-right12"></i> Sign In</a></li>   
	@else
		@if(Session::get('gid') ==1)
		<li class="user dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-screen"></i> <span>Control Panel</span><i class="caret"></i></a>
		  <ul class="dropdown-menu dropdown-menu-right icons-right">
		   <li><a href="{{ URL::to('config/dashboard')}}"><i class="icon-stats-up"></i> Dashboard</a></li>
		  	<li><a href="{{ URL::to('config')}}"><i class="icon-cog"></i> Settings</a></li>
			
			<li class="dropdown-submenu "><a href="{{ URL::to('users')}}" class="dropdown-toggle" data-toggle="dropdown" ><i class="icon-user"></i> Users & Groups</a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="{{ URL::to('users')}}"><i class="icon-user"></i> Users </a></li>
					<li><a href="{{ URL::to('groups')}}"><i class="icon-user"></i> Groups </a></li>
					<li><a href="{{ URL::to('config/blast')}}"><i class="icon-envelop"></i> Blast Email </a></li>	
				</ul>
			</li>
					
			<li class="divider"></li>
			<li><a href="{{ URL::to('pages')}}"><i class="icon-envelop"></i> Page CMS </a></li>
			<li><a href="{{ URL::to('module')}}"><i class="icon-bubble4"></i> Module & Builder</a></li>			
			<li><a href="{{ URL::to('menu')}}"><i class="icon-paragraph-left"></i> Menu Management</a></li>
			<li><a href="{{ URL::to('bulk')}}"><i class="icon-paragraph-left"></i> Bulk Upload Keywords</a></li>
			<li><a href="{{ URL::to('process')}}"><i class="icon-paragraph-left"></i> Process Images</a></li>
			<li class="divider"></li>
			<li><a href="{{ URL::to('config/template')}}"><i class="icon-grid"></i> Template Elements</a></li>
			
		  </ul>
		</li>
		@endif	
		<li class="user dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-profile"></i> <span>Account</span><i class="caret"></i></a>
		  <ul class="dropdown-menu dropdown-menu-right icons-right">
			<li><a href="{{ URL::to('user/profile')}}"><i class="icon-user"></i> Profile</a></li>
			<li><a href="{{ URL::to('user/logout')}}"><i class="icon-exit"></i> Logout</a></li>
		  </ul>
		</li>			
		
	@endif 
  </ul>	 