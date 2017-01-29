<?php

class Front extends Eloquent  {
	


	public function __construct() {
		parent::__construct();
		
	}
	
	public function grabLatestPosts()
    {
	$index = 0;
    $latestposts =  DB::select("SELECT * FROM tb_posts WHERE publish_date < DATE(NOW()) AND active = '1' AND workflow_stage = 'published' order by publish_date DESC LIMIT 4");	
	foreach($latestposts as &$post) 
		{
		$firstimagerow = DB::select("select * from tb_images where post_id = '$post->id' and active ='1' order by featured desc limit 1");
		if(isset($firstimagerow[0]->filename)) 
			{
			$post->img_filename = $firstimagerow[0]->filename;
			$post->img_extension = $firstimagerow[0]->extension;
			$post->img_title = $firstimagerow[0]->title;
			$post->img_width = $firstimagerow[0]->width_sm;
			$post->img_height = $firstimagerow[0]->height_sm;
			$post->img_src = Config::get('general.image_folder_path_web').GeneralHelpers::slugify($post->keyword).'/'.Config::get('general.prefix_sm').$post->img_filename.Config::get('general.suffix_sm').'.'.$post->img_extension;
			} else {
			//Delete remove post from array
			unset($latestposts[$index]);
			}
		$index++;
		}

	return $latestposts;
    }
	
	public function getStaticPageContent($pageurl)
    {
    $pages =  DB::select("SELECT * FROM tb_staticpages WHERE slug = '".$pageurl."' LIMIT 1");	
	foreach($pages as $page) 
		{
		return $page->content;
		}


    }
	
	public function getTagArray($tag_no)
    {
    return  DB::select("SELECT DISTINCT ".$tag_no." FROM tb_posts WHERE ".$tag_no." != '' AND workflow_stage = 'published'");	
    }
	
	public function getTagArrayWhereTag1($tag_no,$tag1)
    {
    return  DB::select("SELECT DISTINCT ".$tag_no." FROM tb_posts WHERE tag1 = '".$tag1."' AND ".$tag_no." != '' AND workflow_stage = 'published' Order by tag2 ASC");	
    }
	
	public function getTagArrayWhereTag2($tag_no,$tag1,$tag2)
    {
    return  DB::select("SELECT DISTINCT ".$tag_no." FROM tb_posts WHERE tag1 = '".$tag1."' AND tag2 = '".$tag2."' AND ".$tag_no." != '' AND workflow_stage = 'published' Order by tag3 ASC");	
    }
	
	public function imageDownload($width_original,$height_original,$width_required,$height_required,$image_path,$image_slug,$image_extension,$image_effect,$ratio_original,$ratio_required)
	{
	$temp_file_path = Config::get('general.image_folder_path') . 'temp/download_'.$image_slug.'_'.$image_effect.'_'.$width_required.'x'.$height_required.'.'.$image_extension;
	if(file_exists($temp_file_path)) { 
	//Do nothing and serve the existing file
	} else 
	{
		//Crop? - Add a hook

		if($ratio_original == $ratio_required) {
			$height_resize = $height_required;
			$width_resize = $width_required;
		} elseif($ratio_original > $ratio_required) {
			$height_resize = $height_required;
			$width_resize = $height_resize*$width_original/$height_original;
		} else {
			$width_resize = $width_required;
			$height_resize = $width_resize*$height_original/$width_original;
			
		}

		//$new_dimension_array = extract(GeneralHelpers::get_new_dimension_array($width, $height,'dl'));

		$imagedetails = Imagemanipulate::make(Config::get('general.image_folder_path').''.$image_path)->resize($width_resize,$height_resize)->grab($width_required,$height_required);
		
		if($image_effect == 'bw') {
		
			$imagedetails->greyscale()->contrast(10);

		} elseif ($image_effect == 'sp') {
		
			$imagedetails->greyscale()->colorize(100, 50, 0);
		
		} else { }
		
		$imagedetails->save($temp_file_path,Config::get('general.image_quality'));
	}
	return Response::download($temp_file_path);

	}


	

}
