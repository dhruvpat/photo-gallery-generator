<?php


class BulkController extends BaseController {
	protected $table = 'tb_posts';
	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Posts';
	static $per_page	= '10';
	public function __construct() {
	parent::__construct();
	$this->beforeFilter('csrf', array('on'=>'post'));

	} 

	
	public function getIndex()
	{
			$params = array(
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);	

		// Master detail link if any 
		$this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		$this->layout->nest('content','Bulk.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	
	public function startProcess()
	{

	// Moves csv file to folder on server
	$todaydate = new \DateTime;
	$this->data['set'] = array();
	if (Input::hasFile('file')){
	$file = Input::file('file');
	$name = date('m-d-Y-His') . '-' . $file->getClientOriginalName();
	$file->move(Config::get('general.image_folder_path') ."temp/", $name);
	$totalrows = count(file(Config::get('general.image_folder_path') ."temp/" . $name));
	
	$rowcount = '1';
	$publish_start_year = Input::get('publish_start_year');
	$publish_end_year = Input::get('publish_end_year');
	$publish_start_month = Input::get('publish_start_month');
	$publish_end_month = Input::get('publish_end_month');
	$total_years = $publish_end_year - $publish_start_year + 1;
	$counter = 0; $years = array();
	$skew = floatval(Input::get('skew'))/100;
	$probability = $skew;
	while ($counter < $total_years)
	{
	$years[$publish_start_year + $counter] = $probability;
	$counter++;
	$probability = (1-$probability)/2*$probability + $probability;
	}
	
	
	//Process CSV file
	if (($handle = fopen(Config::get('general.image_folder_path') . "temp/" . $name, "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000)) !== FALSE) 
		{
		$post = new Posts();
		$post->title = ucwords(GeneralHelpers::cleanInput($data[0]));
		$post->excerpt = trim($data[1]);
		$post->content = trim($data[2]);
		$post->keyword = strtolower(GeneralHelpers::cleanInput($data[3]));
		if(isset($data[4])) {$post->tag1 = GeneralHelpers::slugify($data[4]);} else {$post->tag1 = '';};
		if(isset($data[5])) {$post->tag2 = GeneralHelpers::slugify($data[5]);} else {$post->tag2 = '';};
		if(isset($data[6])) {$post->tag3 = GeneralHelpers::slugify($data[6]);} else {$post->tag3 = '';};
		$post->slug = GeneralHelpers::slugify($post->title);
		$post->workflow_stage = 'new_keyword';
		if(Input::get('auto_enable') == 1) {$post->active = 1;} else { $post->active = 0 ;};
		$post->user_id = Input::get('user_id');
		$post->post_type = 'auto';
		
		//Figure out publish date
		if(Input::get('skew') == 1) 
			{
			$rand_year = rand($publish_start_year,$publish_end_year);
			if($rand_year == $publish_start_year)
				{
				$rand_month = rand($publish_start_month,12);
				} elseif ($rand_year == $publish_end_year) 
				{
				$rand_month = rand(1,$publish_end_month);
				} else 
				{
				$rand_month = rand(1,12);
				}
			$post->publish_date = $rand_year ."-" . $rand_month . "-" . rand(1,28);
			
			} else 
			{
			$probability_no = rand(1,100)/100;
			
			$year = intval($publish_start_year);
			
			//Loop through array and check the probability
			foreach($years as $key => $value) 
			{
				if($probability_no < $value)
				{
				$year = $key;
				
				break;
				}
			}
			
			if($year == $publish_start_year)
				{
				$rand_month = rand($publish_start_month,12);
				} elseif ($year == $publish_end_year) 
				{
				$rand_month = rand(1,$publish_end_month);
				} else 
				{
				$rand_month = rand(1,12);
				}

			
			$post->publish_date = $year ."-" . $rand_month . "-" . rand(1,28);
			}
		
		// TEST Data
		$this->data['set'][$rowcount] = array(
		'publish_date' => $post->publish_date,
		'title' => $post->title,
		'slug' => $post->slug,
		'user_id' => $post->user_id

		);
		
		
		$rowcount++;
		
		// Save the post
		$post->save();
		}
		
	}
		 
	
	// Render into template
	$this->layout->nest('content','Bulk.start',$this->data)
				->with('menus', SiteHelpers::menus());
	}
	
	}

	
		
}