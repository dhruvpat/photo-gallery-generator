<?php


class SitemapController extends BaseController {
	protected $table = 'tb_posts';
	//protected $layout = "theme.".Config::get('general.theme_folder').".sitemap";
	protected $data = array();	
	//public $module = 'Sitemap';
	//static $per_page	= '10';
	public function __construct() {
	parent::__construct();
	$this->beforeFilter('csrf', array('on'=>'post'));

	} 

	
	public function generateSitemap()
	{
	$sitemaps_list = array();
	
	//Create Sitemap for Posts
	$posts_list = '';
	$total_posts = 0;
	$posts_published = DB::table('tb_posts')->select('*')->where('publish_date', '<', date('Y-m-d H:i:s'))->where('active', '=', '1')->get();
	foreach($posts_published as $post) 
		{
		$posts_list .= Config::get('general.base_url')."/post/".$post->slug ."\n";
		$total_posts++;
		}
	$fp = fopen(Config::get('general.sitemap_folder') .'/sitemap-posts.txt', 'w');
	fwrite($fp,$posts_list);
	fclose($fp);
	array_push($sitemaps_list,Config::get('general.base_url')."/".Config::get('general.sitemap_folder') ."/sitemap-posts.txt");
	
	//Create Sitemap for Singles
	$limit = 40000;
	$offset = 0;
	$limit_counter = 0;
	$page_count = 1;
	$images_list = '';
	$post_counter = 0;
	
	foreach($posts_published as $post) 
		{
		$post_counter++;
		$images = DB::table('tb_images')->select('*')->where('post_id', '=', $post->id)->where('active', '=', '1')->get();
		foreach($images as $image) 
			{
			$images_list .= Config::get('general.base_url')."/".$image->slug ."\n";
			$limit_counter++;
			}
		if($limit_counter > $limit) 
			{
			$limit_counter = 0;
			$fp = fopen(Config::get('general.sitemap_folder') .'/sitemap-images-'.$page_count.'.txt', 'w');
			fwrite($fp,$images_list);
			fclose($fp);
			$images_list = '';
			array_push($sitemaps_list,Config::get('general.base_url')."/".Config::get('general.sitemap_folder') ."/sitemap-images-".$page_count.".txt");

			$page_count++;
			} else 
			{
				if($total_posts == $post_counter) 
				{
				$fp = fopen(Config::get('general.sitemap_folder') .'/sitemap-images-'.$page_count.'.txt', 'w');
				fwrite($fp,$images_list);
				fclose($fp);
				array_push($sitemaps_list,Config::get('general.base_url')."/".Config::get('general.sitemap_folder') ."/sitemap-images-".$page_count.".txt");
				}
			
			}
		}

	//Write main sitemap file
	header("Content-Type: text/xml;charset=iso-8859-1");
	$header = '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	$footer = '</sitemapindex>';
	$output = '';
	foreach ($sitemaps_list as $key => $value) {
    $output .= "<sitemap><loc>". $value . "</loc></sitemap>" . "\n";
	}
	
	file_put_contents(Config::get('general.sitemap_folder'). '/sitemap.xml',$header .  $output .  $footer);

	return View::make("theme.".Config::get('general.theme_folder').".sitemap");
	}		

		
		
}