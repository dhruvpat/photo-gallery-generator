<?php

class ConfigController extends BaseController  {

	protected $layout = "layouts.main";
	
	public function __construct() {
		$this->beforeFilter('csrf', array('on'=>'post'));
		parent::__construct();
		$this->data = array(
			'pageTitle'	=> 'Site Config',
			'pageNote'	=> 'Manage Setting COnfiguration'
		);
	} 	
	public function getDashboard()
	{
		$this->data['user_groups'] = Users::getUserStatus();
		$this->data['lastest_users'] = Users::getLatestUser();
		$this->layout->nest('content','admin/config/dashboard',$this->data);	
	}	

	public function getIndex()
	{
		$this->layout->nest('content','admin/config/index',$this->data)->with('menus', $this->menus );	
	}
	
	static function postSave()
	{

		$rules = array(
			'cnf_appname'=>'required|min:2',
			'cnf_appdesc'=>'required|min:2',
			'cnf_comname'=>'required|min:2',
			'cnf_email'=>'required|email',
		);
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$val  =		"<?php \n"; 
			$val .= 	"define('CNF_APPNAME','".Input::get('cnf_appname')."');\n";
			$val .= 	"define('CNF_APPDESC','".Input::get('cnf_appdesc')."');\n";
			$val .= 	"define('CNF_COMNAME','".Input::get('cnf_comname')."');\n";
			$val .= 	"define('CNF_EMAIL','".Input::get('cnf_email')."');\n";		
			$val .= 	"?>";
	
			$filename = 'setting.php';
			$fp=fopen($filename,"w+"); 
			fwrite($fp,$val); 
			fclose($fp); 
			return Redirect::to('config')->with('message',SiteHelpers::alert('success','Setting Has Been Save Successful') );
		} else {
			return Redirect::to('config')->with('message', SiteHelpers::alert('success','The following errors occurred'))
			->withErrors($validator)->withInput();
		}			
	
	}

	public function getHelp()
	{
		$this->data = array(
			'pageTitle'	=> 'Help Manual',
			'pageNote'	=> 'Documentation'
		);	
		$this->layout->nest('content','admin/config/help',$this->data)->with('menus', $this->menus );	
	}

	function getBlast()
	{
		$this->data = array(
			'groups'	=> Groups::all(),
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users'
		);	
		$this->layout->nest('content','admin/config/blast',$this->data)->with('menus', $this->menus );		
	}

	function postDoblast()
	{

		$rules = array(
			'subject'		=> 'required',
			'message'		=> 'required|min:10',
			'groups'		=> 'required',				
		);	
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) 
		{	

			if(!is_null(Input::get('groups')))
			{
				$groups = Input::get('groups');
				for($i=0; $i<count($groups); $i++)
				{
					if(Input::get('uStatus') == 'all')
					{
						$users = Users::all()->where('group_id','=',$groups[$i]);
					} else {
						$users = Users::where('active','=',Input::get('uStatus'))->where('group_id','=',$groups[$i]);
					}
					$count = 0;
					foreach($users as $row)
					{

						$to = $row->email;
						$subject = Input::get('subject');
						$message = Input::get('message');
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: '.CNF_APPNAME.' <'.CNF_EMAIL.'>' . "\r\n";
							mail($to, $subject, $message, $headers);
						
						$count = ++$count;					
					} 
					
				}
				return Redirect::to('config/blast')->with('message', SiteHelpers::alert('success','Total '.$count.' Message has been sent'));

			}
			return Redirect::to('config/blast')->with('message', SiteHelpers::alert('info','No Message has been sent'));
			

		} else {

			return Redirect::to('config/blast')->with('message', SiteHelpers::alert('error','The following errors occurred'))
			->withErrors($validator)->withInput();
		}	

	}

	function getTemplate( $page = 'general')
	{
		switch ($page) {

				case 'typography':
					$tmp = 'admin/config/template/Typography';
					break;

				case 'icon-moon':
					$tmp = 'admin/config/template/Iconmoon';
					break;

				case 'forms':
					$tmp = 'admin/config/template/Forms';
					break;

				case 'tables':
					$tmp = 'admin/config/template/Tables';
					break;

				case 'panel':
					$tmp = 'admin/config/template/Panel';
					break;		
								
				case 'grid':
					$tmp = 'admin/config/template/Grid';
					break;	
					
				case 'icons':
					$tmp = 'admin/config/template/Icons';
					break;

				default:
					$tmp = 'admin/config/template/Index';
					break;
			}	
		

		$this->data = array(
			'pageTitle'	=> 'Templates',
			'pageNote'	=> 'Elements for template',
			'page'		=> $page
				
		);	
		$this->layout->nest('content',$tmp,$this->data)->with('menus', $this->menus );	

	}		

}