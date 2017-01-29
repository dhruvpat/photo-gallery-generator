<?php


class ProcessController extends BaseController {
	protected $table = 'tb_posts';
	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'Process';
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
	
		$this->data['postcount'] = with(new Process)->getPostCount(); 
		
		$this->data['postnewkeywordcount'] = with(new Process)->getPostNewKeywordCount(); 
		
		// Master detail link if any 
		$this->data['subgrid'] = (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		$this->layout->nest('content','Process.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	
	public function startProcess($method = 'web')
	{
	$todaydate = new \DateTime;
	$time_start = microtime(true);
	if(Input::get('keywords_process')) {
	$keywords_process = Input::get('keywords_process');
	} else {
	$keywords_process = '';
	}
	if ($keywords_process != '') {$no_of_keywords = $keywords_process;} else {$no_of_keywords = Config::get('general.automatic_posts');}
	$postnewkeywordarray = DB::table('tb_posts')->where('publish_date', '<', date('Y-m-d H:i:s',strtotime("+30 days")))->where('workflow_stage', Config::get('general.pre_process_stage'))->take($no_of_keywords)->get();
	//$postnewkeywordarray = DB::table('tb_posts')->take($no_of_keywords)->get();
	if(count($postnewkeywordarray) != '0')
	{
		foreach($postnewkeywordarray as $row) 
		{
		
		// Update workflow_stage to 'in progress'
		$rowupdate = DB::table('tb_posts')->where('id', $row->id)->update(array('workflow_stage' => Config::get('general.in_process_stage'),'updated_at' => $todaydate));
		
			$postid = $row->id;
			$keyword = $row->keyword;
			$json_array = array();
			
			if(Config::get('general.max_images_per_keyword') < '51') {
			$json_string = with(new Process)->getBingJson($keyword,'0');
			array_push($json_array,$json_string);
			} else {


			$i = 0;
			while($i < Config::get('general.max_images_per_keyword')) 
				{
				$json_string = with(new Process)->getBingJson($keyword,$i);
				array_push($json_array,$json_string);
				$i = $i + 50;
				}
			}
			$this->data['set'] = array();
			$all_image_urls = array();
			$counter = 0;
			//Process the Json
			foreach($json_array as $bingjson)
			{
			
				foreach($bingjson['d']['results'] as $imagerow)
				{
					
					$parse = parse_url($imagerow["SourceUrl"]);
					
					if (Config::get('general.width_min') > $imagerow['Width'] OR GeneralHelpers::domain_banned($parse['host']) OR (substr($imagerow["MediaUrl"], -3) != 'jpg' AND substr($imagerow["MediaUrl"], -3) != 'gif' AND substr($imagerow["MediaUrl"], -3) != 'png')) {

					} else 
					{
					// Start Image Process	
					$image = new Images();
					$image->post_id = $postid;
					$image->title = ucwords(GeneralHelpers::image_name_decide($keyword,$imagerow["Title"],$imagerow["SourceUrl"],$imagerow["MediaUrl"]));
					$image->excerpt = '';
					$image->content = '';
					$image->slug = GeneralHelpers::slugify($image->title);
					if($image->slug == '') { $image->slug = GeneralHelpers::slugify($image->title) . "-" . rand(100000,999999); }
					//Check if image slug is duplicate 
					if(DB::table('tb_images')->where('slug', $image->slug)->count() != 0)
						{
						$image->slug = $image->slug . "-" . rand(100000,999999);
						}
					$image->keyword = GeneralHelpers::slugify($keyword);
					$image->filename = $image->slug;
					$image->extension = strtolower(GeneralHelpers::get_extension($imagerow["MediaUrl"])); 
					$image->active =  '1';

					$image->original_image_url =  $imagerow["MediaUrl"];
					$image->original_page_url =  $imagerow["SourceUrl"];
					$image->original_domain =  $parse['host'];
					$image->hits = '0';
					$image->created_at = $todaydate;
					$image->updated_at = $image->created_at;
					//Add the image url to array
					array_push($all_image_urls,$image->original_image_url);
					
					//Save all Image details
					$image->save();
					
					// If Max limit reached then move onto next keyword
					if($counter == Config::get('general.max_images_per_keyword')) { break;}
					
					$counter++;
					}
				}
			}
		
		//Download all Image for keyword in one shot
		$download_done = with(new Process)->grab_bulk_images($all_image_urls);
		
		//Get all images
		//$images = Images::where('post_id', '=', '2')->get();
		$imagesbucket = DB::table('tb_images')->where('post_id', '=', $postid)->get();
	
		foreach($imagesbucket as $imagerow)
			{
			$image = Images::where('id', '=', $imagerow->id)->first();
			//$image = DB::table('tb_images')->where('id', '=', $imagerow->id)->get();
			
				
				////////////////////////Image Creation - Start////////////////////
				$image_temp_location = Config::get('general.image_folder_path') . "temp/temp" . md5($image->original_image_url);

				//$image_downloaded = with(new Process)->grab_image($imagerow["MediaUrl"],$image_temp_location);
				//$image_temp_location = Config::get('general.image_folder_path') . 'temp/'.$image->slug.'.'.$image->extension;
				if (file_exists($image_temp_location)) { 
				$imagetype = @exif_imagetype($image_temp_location); 
					if($imagetype == IMAGETYPE_JPEG OR $imagetype == IMAGETYPE_PNG OR $imagetype == IMAGETYPE_GIF) {} else {$imagetype = '';}
				} else {$imagetype = '';}
				
				if ($imagetype != '') 
				{
				if(filesize($image_temp_location)) 
					{
					//Add the image extension
					$image_temp_location_full = $image_temp_location.'.'.$image->extension;
					rename($image_temp_location,$image_temp_location_full);
					
					
					// Get original image height and width
					list($width, $height) = getimagesize($image_temp_location_full);
					
					//Check if folder from keyword slug exists
					if (File::isWritable(Config::get('general.image_folder_path') . $image->keyword)) { } else {
					//Create the directory
					File::makeDirectory(Config::get('general.image_folder_path') . $image->keyword,0777);
					}
					
					//Big image processing
					$new_dimension_array = extract(GeneralHelpers::get_new_dimension_array($width, $height,'bg'));
					$image->width_bg = $new_width;
					$image->height_bg = $new_height;
					$imagedetails = Imagemanipulate::make($image_temp_location_full)->resize($image->width_bg,$image->height_bg);
					$imagedetails->save(Config::get('general.image_folder_path') . $image->keyword .'/'.Config::get('general.prefix_bg').$image->slug.Config::get('general.suffix_bg').'.'.$image->extension,Config::get('general.image_quality'));
					
					//Medium image processing
					$new_dimension_array = extract(GeneralHelpers::get_new_dimension_array($width, $height,'md'));
					$image->width_md = $new_width;
					$image->height_md = $new_height;
					$imagedetails = Imagemanipulate::make($image_temp_location_full)->resize($image->width_md,$image->height_md);
					$imagedetails->save(Config::get('general.image_folder_path') . $image->keyword .'/'.Config::get('general.prefix_md').$image->slug.Config::get('general.suffix_md').'.'.$image->extension,Config::get('general.image_quality'));
					
					//Small image processing
					$new_dimension_array = extract(GeneralHelpers::get_new_dimension_array($width, $height,'sm'));
					if(Config::get('general.autocrop_sm')) {
					//Cropping
						$image->width_sm = $new_width;
						$image->height_sm = $new_height;
						$imagedetails = Imagemanipulate::make($image_temp_location_full)->grab(Config::get('general.width_sm_max'),Config::get('general.height_sm_max'));
						$imagedetails->save(Config::get('general.image_folder_path') . $image->keyword .'/'.Config::get('general.prefix_sm').$image->slug.Config::get('general.suffix_sm').'.'.$image->extension,Config::get('general.image_quality'));
					} else {
					//No cropping
						$image->width_sm = $new_width;
						$image->height_sm = $new_height;
						$imagedetails = Imagemanipulate::make($image_temp_location_full)->resize($image->width_sm,$image->height_sm);
						$imagedetails->save(Config::get('general.image_folder_path') . $image->keyword .'/'.Config::get('general.prefix_sm').$image->slug.Config::get('general.suffix_sm').'.'.$image->extension,Config::get('general.image_quality'));
					}
					
					//Save all Image details
					$image->save();
					
						//Delete temporary images
						if(file_exists($image_temp_location_full)){
						unlink($image_temp_location_full);
						}
					}	
				} else { 
				
					//Delete temporary hash image
					if(file_exists($image_temp_location)){
					unlink($image_temp_location);
					}
					
					//Delete image row from db
					$image->delete();

				}
				
				//Delete temporary images
				if(file_exists($image_temp_location)){
				unlink($image_temp_location);
				}

				////////////////////////Image Creation - End////////////////////
						
			}
		
		
		$rowupdate = DB::table('tb_posts')->where('id', $row->id)->update(array('workflow_stage' => Config::get('general.post_process_stage'),'updated_at' => $todaydate));
		
		//Delete posts that have less than 20 images

		$images_count = DB::table('tb_images')->where('post_id', $row->id)->where('active', '1')->count();
		if($images_count < 20) 
			{ 
			$post = Post::find($row->id);
			$post->delete();
			}
		
		
		//Send post data to view
			$time_end = microtime(true);
			$this->data['set'][$counter] = array(
			'post_id' =>  $row->id,
			'post_title' => $row->title,
			'post_keyword' => $row->keyword,
			'post_slug' => $row->slug,
			'time' => round(($time_end - $time_start)/60,1)
			);
			
			
		}
		

		
		
		} 
	
	
	//delete temp image
	//unlink('images/' . $filename . '.' . $extension);	
	
	// Render into template
	$this->layout->nest('content','Process.start',$this->data)
				->with('menus', SiteHelpers::menus());
	}
	

	
			
		
}