<?php

class UserController extends BaseController {

	
	protected $layout = "layouts.index";

	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		if(!Auth::check())
		{
			$this->layout = "layouts.index";	
		}
	} 

	public function getRegister() {
		$this->layout->content = View::make('user.register');
	}

	public function postCreate() {
	
		$rules = array(
			'firstname'=>'required|alpha_num|min:2',
			'lastname'=>'required|alpha_num|min:2',
			'email'=>'required|email|unique:tb_users',
			'password'=>'required|alpha_num|between:6,12|confirmed',
			'password_confirmation'=>'required|alpha_num|between:6,12'
			);		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$authen = new User;
			$authen->first_name = Input::get('firstname');
			$authen->last_name = Input::get('lastname');
			$authen->email = Input::get('email');
			$authen->password = Hash::make(Input::get('password'));
			$authen->active = '0';
			$authen->save();
			
			$data = array(
				'firstname'	=> Input::get('firstname') ,
				'lastname'	=> Input::get('lastname') ,
				'email'		=> Input::get('email') ,
				'password'	=> Input::get('password') ,
				
			);
			
			Mail::send('emails.registration', $data, function($message){
				$message->to(Input::get('email'), Input::get('firstname').' '.Input::get('lastname')
				)->subject('Welcome to '.CNF_APPNAME)->from(CNF_EMAIL, CNF_APPNAME);	;
			});

			return Redirect::to('user/login')->with('message',SiteHelpers::alert('success','Thanks for registering!'));
		} else {
			return Redirect::to('user/register')->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}
	}

	public function getLogin() {
		if(Auth::check())
		{
			return Redirect::to('')->with('message',SiteHelpers::alert('success','Thanks for registering!'));

		} else {
			$data = array();
			$this->layout->nest('content','user.login',$data);
			//$this->layout->content = View::make('user.login');
		}	
	}

	public function postSignin() {
		

		if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
			if(Auth::check())
			{
				$row = user::find(Auth::user()->id); 

				if($row->active =='0')
				{
					// inactive 
					Auth::logout();
					return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Your Account is not active'));

				} else if($row->active=='2')
				{
					// BLocked users
					Auth::logout();
					return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Your Account is BLocked'));
				} else {
					Session::put('uid', $row->id);
					Session::put('gid', $row->group_id);
					Session::put('eid', $row->group_email);
					Session::put('fid', $row->first_name.' '. $row->last_name);	
					return Redirect::to('');						
				}
				
				
			}
		
			
		} else {
			return Redirect::to('user/login')
				->with('message', SiteHelpers::alert('error','Your username/password combination was incorrect'))
				->withInput();
		}
	}

	public function getDashboard() {
		$data = array('menus'=> SiteHelpers::menus());
		$this->layout->nest('content','users.dashboard')->with('menus', SiteHelpers::menus());
	}
	
	public function getProfile() {
		
		if(!Auth::check()) return Redirect::to('user/login');
		
		
		$user_id = Auth::user()->id;
		$info =	user::find($user_id);
		$this->data = array(
			'pageTitle'	=> 'My Profile',
			'pageNote'	=> 'View Detail My Info',
			'info'		=> $info,
		);
		$this->layout->nest('content','user.profile',$this->data)->with('menus', SiteHelpers::menus());
	}
	
	public function postSaveprofile()
	{
		if(!Auth::check()) return Redirect::to('user/login');
		$rules = array(
			'first_name'=>'required|alpha_num|min:2',
			'last_name'=>'required|alpha_num|min:2',
			);		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes()) {
			$user = user::find(Session::get('uid'));
			$user->first_name 	= Input::get('first_name');
			$user->last_name 	= Input::get('last_name');
			$user->save();

			return Redirect::to('user/profile')->with('message',SiteHelpers::alert('success','Profile has been saved!'));
		} else {
			return Redirect::to('user/profile')->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postSavepassword()
	{
		$rules = array(
			'password'=>'required|alpha_num|between:6,12',
			'password_confirmation'=>'required|alpha_num|between:6,12'
			);		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			$user = user::find(Session::get('uid'));
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('user/profile')->with('message',SiteHelpers::alert('success','Password has been saved!'));
		} else {
			return Redirect::to('user/profile')->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}	
	
	}	
	
	public function getReminder()
	{
	
		$this->layout->content = View::make('user.remind');
	}	

	public function postRequest()
	{

		$rules = array(
			'credit_email'=>'required|email'
		);	
		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {	
	
			$user =  User::where('email','=',Input::get('credit_email'));
			if($user->count() >=1)
			{
				$user = $user->get();
				$user = $user[0];
				$data = array('token'=>Input::get('_token'));	
				$to = Input::get('credit_email');
				$subject = "[ " .CNF_APPNAME." ] REQUEST PASSWORD RESET "; 			
				$message = view::make('emails.auth.reminder', $data);
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.CNF_APPNAME.' <'.CNF_EMAIL.'>' . "\r\n";
					mail($to, $subject, $message, $headers);				
			
				
				$affectedRows = User::where('email', '=',$user->email)
								->update(array('reminder' => Input::get('_token')));
								
				return Redirect::to('user/login')->with('message', SiteHelpers::alert('success','Please check your email'));	
				
			} else {
				return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Cant find email address'));
			}

		}  else {
			return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}	 
	}	
	
	public function getReset( $token = '')
	{
		
		$user = User::where('reminder','=',$token);
		if($user->count() >=1)
		{
			$data = array('verCode'=>$token);
			$this->layout->nest('content','user.remind',$data);	
		} else {
			return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Cant find your reset code'));
		}
		
	}	
	
	public function postDoreset( $token = '')
	{
		$rules = array(
			'password'=>'required|alpha_num|between:6,12|confirmed',
			'password_confirmation'=>'required|alpha_num|between:6,12'
			);		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->passes()) {
			
			$user =  User::where('reminder','=',$token);
			if($user->count() >=1)
			{
				$data = $user->get();
				$user = user::find($data[0]->id);
				$user->reminder = '';
				$user->password = Hash::make(Input::get('password'));
				$user->save();			
			}

			return Redirect::to('user/login')->with('message',SiteHelpers::alert('success','Password has been saved!'));
		} else {
			return Redirect::to('user/reset/'.$token)->with('message', SiteHelpers::alert('error','The following errors occurred')
			)->withErrors($validator)->withInput();
		}	
	
	}	

	public function getLogout() {
		Auth::logout();
		Session::flush();
		return Redirect::to('')->with('message', SiteHelpers::alert('info','Your are now logged out!'));
	}
}