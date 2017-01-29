<?php


class FrontController extends BaseController {
	protected $table = 'tb_posts';
	protected $data = array();	
	public $module = 'front';
	static $per_page	= '10';
	public function __construct() {
	parent::__construct();
	$this->beforeFilter('csrf', array('on'=>'post'));
	$this->model = new Front();
	} 

	
	public function indexDisplay()
	{

	
	$allposts = DB::table('tb_posts')->select('*')->where('publish_date', '<', date('Y-m-d H:i:s'))->where('active', '=', '1')->where('workflow_stage', '=', 'published')->orderBy('publish_date', 'desc')->paginate(Config::get('general.pagination'));
	

	foreach($allposts as $key =>&$post) 
		{
		$firstimagerow = DB::select("select *,sum(width_md) AS sumwidth from tb_images where post_id = '$post->id' and active ='1' order by featured desc limit 1");
		if(isset($firstimagerow[0]->filename) AND $firstimagerow[0]->sumwidth != 0) 
			{
			$post->img_slug = $firstimagerow[0]->slug;
			$post->img_filename = $firstimagerow[0]->filename;
			$post->img_extension = $firstimagerow[0]->extension;
			$post->img_title = $firstimagerow[0]->title;
			$post->width_sm = $firstimagerow[0]->width_sm;
			$post->height_sm = $firstimagerow[0]->height_sm;
			$post->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($post->keyword).'/'.Config::get('general.prefix_sm').$post->img_filename.Config::get('general.suffix_sm').'.'.$post->img_extension;
			} else {
			//Delete remove post from array
			unset($allposts[$key]);
			}

		}
	//Meta
	$this->data['meta_title'] = 'Welcome to Crazy Coloring Pages';
	$this->data['meta_description'] = 'The No.1 resource on hundreds of coloring pages for kids. Browse through all types of coloring pages from cartoons to animals to alphabet to numbers now...';
	$this->data['meta_h1'] = 'Welcome to Crazy Coloring Pages';
	
	$this->data['layout_type'] = 'index';
	$this->data['posts'] = $allposts;
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	$this->data['tag1_array'] = $this->model->getTagArray('tag1');
	
	
	//Load the views
	return View::make("theme.".Config::get('general.theme_folder').".layouts",$this->data);

	}	

	public function postDisplay($posturl)
	{
	
	$postinfo = DB::select('SELECT * FROM tb_posts where slug = "'.$posturl.'"');
	$this->data['post'] = $postinfo;
	
	if(count($postinfo) == 0) {
	// Throw 404 error
	$this->data['layout_type'] = '404'; $this->data['meta_title'] = "Page Not Found"; $this->data['meta_description'] = ""; $this->data['meta_h1'] = "";
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	return Response::view("theme.".Config::get('general.theme_folder').".layouts", $this->data, 404);
	}
	
	$allimages = DB::table('tb_images')->select('*')->where('post_id', '=', $postinfo[0]->id)->where('active', '=', '1')->paginate(Config::get('general.pagination'));

	
	foreach($allimages as &$image) 
		{
		$image->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($postinfo[0]->keyword).'/'.Config::get('general.prefix_sm').$image->filename.Config::get('general.suffix_sm').'.'.$image->extension;
		$image->tag1 = $postinfo[0]->tag1;
		}
	//Meta
	$this->data['meta_title'] = $postinfo[0]->title ." Coloring Pages";
	if($postinfo[0]->excerpt == '' ) {
	$this->data['meta_description'] = 'Browse through our gallery of '.$postinfo[0]->title.' coloring pages in the '.$postinfo[0]->tag1.' category. Find hundreds of printable free '.$postinfo[0]->title.' coloring pages now...';
	} else {
	$this->data['meta_description'] = $postinfo[0]->excerpt;
	}
	$this->data['meta_h1'] = $postinfo[0]->title . " Coloring Pages";
	$this->data['content'] = $postinfo[0]->content;
	$this->data['layout_type'] = 'post';
	$this->data['images'] = $allimages;
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	
	//Load the views
	return View::make("theme.".Config::get('general.theme_folder').".layouts",$this->data);

	
	}
	
	public function tagDisplay($tag1,$tag2 = '',$tag3 = '')
	{
	if($tag3 != '') {
	//All 3 tags present
	
	$allposts = DB::table('tb_posts')->select('*')->where('publish_date', '<', date('Y-m-d H:i:s'))->where('active', '=', '1')->where('tag1', '=', $tag1)->where('tag2', '=', $tag2)->where('workflow_stage', '=', 'published')->orderBy('publish_date', 'desc')->paginate(Config::get('general.pagination'));
	

	foreach($allposts as $key =>&$post) 
		{
		$firstimagerow = DB::select("select * from tb_images where post_id = '$post->id' and active ='1' order by featured desc limit 1");
		if(isset($firstimagerow[0]->filename)) 
			{
			$post->img_slug = $firstimagerow[0]->slug;
			$post->img_filename = $firstimagerow[0]->filename;
			$post->img_extension = $firstimagerow[0]->extension;
			$post->img_title = $firstimagerow[0]->title;
			$post->width_sm = $firstimagerow[0]->width_sm;
			$post->height_sm = $firstimagerow[0]->height_sm;
			$post->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($post->keyword).'/'.Config::get('general.prefix_sm').$post->img_filename.Config::get('general.suffix_sm').'.'.$post->img_extension;
			} else {
			//Delete remove post from array
			unset($allposts[$key]);
			}

		}
	//Meta
	$this->data['meta_title'] = ucwords(str_replace("-"," ",$tag2)) . " " . ucwords(str_replace("-"," ",$tag1)) . " Coloring Pages";
	$this->data['meta_description'] = "Discover new high quality ". ucwords(str_replace("-"," ",$tag2)) ." ".ucwords(str_replace("-"," ",$tag1)) . " images at our gallery. Browse through our various collections on different types of ".ucwords(str_replace("-"," ",$tag1)) . " now...";
	$this->data['meta_h1'] = "All " . Config::get('general.tag2_label') . " of " . ucwords(str_replace("-"," ",$tag2));
	
	$this->data['posts'] = $allposts;
	$this->data['layout_type'] = 'tag';
	$this->data['tag1'] = $tag1;
	$this->data['tag2'] = $tag2;
	$this->data['tag3'] = $tag3;
	$this->data['latestposts'] = $this->model->grabLatestPosts();
		
	
	} elseif($tag2 != '') {
	//Two tags present
	
	
	$allposts = DB::table('tb_posts')->select('*')->where('publish_date', '<', date('Y-m-d H:i:s'))->where('active', '=', '1')->where('tag1', '=', $tag1)->where('tag2', '=', $tag2)->where('workflow_stage', '=', 'published')->orderBy('publish_date', 'desc')->paginate(Config::get('general.pagination'));
	

	foreach($allposts as $key =>&$post) 
		{
		$firstimagerow = DB::select("select * from tb_images where post_id = '$post->id' and active ='1' order by featured desc limit 1");
		if(isset($firstimagerow[0]->filename)) 
			{
			$post->img_slug = $firstimagerow[0]->slug;
			$post->img_filename = $firstimagerow[0]->filename;
			$post->img_extension = $firstimagerow[0]->extension;
			$post->img_title = $firstimagerow[0]->title;
			$post->width_sm = $firstimagerow[0]->width_sm;
			$post->height_sm = $firstimagerow[0]->height_sm;
			$post->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($post->keyword).'/'.Config::get('general.prefix_sm').$post->img_filename.Config::get('general.suffix_sm').'.'.$post->img_extension;
			} else {
			//Delete remove post from array
			unset($allposts[$key]);
			}

		}
	//Meta
	$this->data['meta_title'] = ucwords(str_replace("-"," ",$tag2)) . " " . ucwords(str_replace("-"," ",$tag1)) . "  Coloring Pages";
	$this->data['meta_description'] = "Discover new high quality ". ucwords(str_replace("-"," ",$tag2)) ." ".ucwords(str_replace("-"," ",$tag1)) . " images at our gallery. Browse through our various collections on different types of ".ucwords(str_replace("-"," ",$tag1)) . " now...";
	$this->data['meta_h1'] = "All " . Config::get('general.tag2_label') . " of " . ucwords(str_replace("-"," ",$tag2));
	
	$this->data['tag3_array'] = $this->model->getTagArrayWhereTag2('tag3',$tag1,$tag2);
	
	if(count($this->data['tag3_array']) != '0') { $this->data['show_tag'] = '1';} else { $this->data['show_tag'] = '0';}
	$this->data['posts'] = $allposts;
	$this->data['layout_type'] = 'tag';
	$this->data['tag1'] = $tag1;
	$this->data['tag2'] = $tag2;
	$this->data['tag3'] = '';
	$this->data['latestposts'] = $this->model->grabLatestPosts();
		
	
	} else {
	//Only one tag present
	
	
	$allposts = DB::table('tb_posts')->select('*')->where('publish_date', '<', date('Y-m-d H:i:s'))->where('active', '=', '1')->where('tag1', '=', $tag1)->where('workflow_stage', '=', 'published')->orderBy('publish_date', 'desc')->paginate(Config::get('general.pagination'));
		if(count($allposts) == 0) {
	// Throw 404 error
	$this->data['layout_type'] = '404'; $this->data['meta_title'] = "Page Not Found"; $this->data['meta_description'] = ""; $this->data['meta_h1'] = "";
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	return Response::view("theme.".Config::get('general.theme_folder').".layouts", $this->data, 404);
	}

	foreach($allposts as $key =>&$post) 
		{
		$firstimagerow = DB::select("select * from tb_images where post_id = '$post->id' and active ='1' order by featured desc limit 1");
		if(isset($firstimagerow[0]->filename)) 
			{
			$post->img_slug = $firstimagerow[0]->slug;
			$post->img_filename = $firstimagerow[0]->filename;
			$post->img_extension = $firstimagerow[0]->extension;
			$post->img_title = $firstimagerow[0]->title;
			$post->width_sm = $firstimagerow[0]->width_sm;
			$post->height_sm = $firstimagerow[0]->height_sm;
			$post->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($post->keyword).'/'.Config::get('general.prefix_sm').$post->img_filename.Config::get('general.suffix_sm').'.'.$post->img_extension;
			} else {
			//Delete remove post from array
			unset($allposts[$key]);
			}

		}
	//Meta
	$this->data['meta_title'] = ucwords(str_replace("-"," ",$tag1)) . " Coloring Pages";
	$this->data['meta_description'] = "Discover new ".ucwords(str_replace("-"," ",$tag1)) . " coloring pages at our gallery. Browse through our various collections on different types coloring pages of ".ucwords(str_replace("-"," ",$tag1)) . " now...";
	$this->data['meta_h1'] = "All " . Config::get('general.tag1_label') . " of " . ucwords(str_replace("-"," ",$tag1));
	
	$this->data['tag2_array'] = $this->model->getTagArrayWhereTag1('tag2',$tag1);
	
	if(count($this->data['tag2_array']) != '0') { $this->data['show_tag'] = '1';} else { $this->data['show_tag'] = '0';}
	$this->data['posts'] = $allposts;
	$this->data['layout_type'] = 'tag';
	$this->data['tag1'] = $tag1;
	$this->data['tag2'] = '';
	$this->data['tag3'] = '';
		
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	
	
	}


	
	//Load the views
	return View::make("theme.".Config::get('general.theme_folder').".layouts",$this->data);
	
	}
	

	public function pageDisplay($pageurl)
	{
	
	$pageinfo = DB::select('SELECT filename, title FROM tb_pages where alias = "'.$pageurl.'"');
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	if(count($pageinfo) == 0) {
	
	// Throw 404 error
	$this->data['layout_type'] = '404'; $this->data['meta_title'] = "Page Not Found"; $this->data['meta_description'] = "Page not found"; $this->data['meta_h1'] = "";
	return Response::view("theme.".Config::get('general.theme_folder').".layouts", $this->data, 404);
	
	} else {
	// Page found
	
	//Meta
	$this->data['meta_title'] = $pageinfo[0]->title;
	$this->data['meta_description'] = $pageinfo[0]->title . " information and details. We would love to hear your comments and feedback, do get in touch with us.";
	$this->data['meta_h1'] = $pageinfo[0]->title;
	
	$this->data['layout_type'] = 'page';
	$this->data['pageurl'] = $pageurl;
	$this->data['filename'] = $pageinfo[0]->filename;
	//Load the views
	
	return View::make("theme.".Config::get('general.theme_folder').".layouts",$this->data);
	}
	


	
	}

	public function imageDisplay($imageurl)
	{
	
	$imageinfo = DB::select("select * from tb_images where slug = '".$imageurl."'");
	if(count($imageinfo) == 0) {
	// Throw 404 error
	$this->data['layout_type'] = '404'; $this->data['meta_title'] = ""; $this->data['meta_description'] = ""; $this->data['meta_h1'] = "";
	$this->data['latestposts'] = $this->model->grabLatestPosts();
	return Response::view("theme.".Config::get('general.theme_folder').".layouts", $this->data, 404);
	}
	$this->data['imageinfo'] = $imageinfo;
	
	$postinfo = DB::select('SELECT * FROM tb_posts where id = "'.$imageinfo[0]->post_id.'"');
	$this->data['post'] = $postinfo;
	$this->data['posturl'] = $postinfo[0]->slug;
	$this->data['keyword'] = ucwords(str_replace("-"," ",$postinfo[0]->keyword));
	
	foreach($imageinfo as &$info) 
	{
		$info->post_publish_date = $postinfo[0]->publish_date;
		$info->post_keyword = $postinfo[0]->keyword;
		$info->img_src = Config::get('general.image_folder_path_web').$info->keyword.'/'.Config::get('general.prefix_md').$info->filename.Config::get('general.suffix_md').'.'.$info->extension;
		$info->external_link = "/goto/".$info->id;
		if ($info->height_md == $info->height_bg) { 
		$info->img_src_big = Config::get('general.image_folder_path_web').$info->keyword.'/'.Config::get('general.prefix_md').$info->filename.Config::get('general.suffix_md').'.'.$info->extension;
		} else {
		$info->img_src_big = Config::get('general.image_folder_path_web').$info->keyword.'/'.Config::get('general.prefix_bg').$info->filename.Config::get('general.suffix_bg').'.'.$info->extension;
		}
	}
	
	
	
	$offset = round(substr($imageinfo[0]->id,-2)/2);
	$allimages = DB::select("select * from tb_images where post_id = '".$imageinfo[0]->post_id."' and active ='1' order by featured desc limit ".Config::get('general.number_of_related')." offset ".$offset."");
	if(count($allimages) < 4) { $allimages = DB::select("select * from tb_images where post_id = '".$imageinfo[0]->post_id."' and active ='1' order by featured desc limit ".Config::get('general.number_of_related').""); }
	
	
	foreach($allimages as &$image) 
	{
		$image->img_src = Config::get('general.image_folder_path_web').$image->keyword.'/'.Config::get('general.prefix_sm').$image->filename.Config::get('general.suffix_sm').'.'.$image->extension;
	}
		
	//Meta
	$this->data['meta_title'] = $imageinfo[0]->title;
	if($imageinfo[0]->excerpt == '') {
	$this->data['meta_description'] = "Check this ".$imageinfo[0]->title." image. Find similar images of ".$imageinfo[0]->title." in our various picture galleries now...";
	} else {
	$this->data['meta_description'] = $postinfo[0]->excerpt;
	}
	$this->data['meta_h1'] = $imageinfo[0]->title;
	
	$this->data['layout_type'] = 'image';
	$this->data['allimages'] = $allimages;
	
	$this->data['latestposts'] = $this->model->grabLatestPosts();

	//Load the views
	return View::make("theme.".Config::get('general.theme_folder').".layouts",$this->data);
	
	}
	
	



	


	
		
}