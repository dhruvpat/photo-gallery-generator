<?php
class GeneralHelpers
{
/**
* Returns the last performed database query
*
* @return string
*/

	static public function domain_banned($domain)
	{ 
	$domain_ban = Config::get('general.domain_ban');
	return in_array($domain, $domain_ban);
	}
	
	static public function cleanInput($input) {
	return trim(preg_replace("/[^a-zA-Z0-9 ]/", "", $input));
	}
	
	static public function slugify($text)
	{ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

	  // trim
	  $text = trim($text, '-');

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // lowercase
	  $text = strtolower($text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  if (empty($text))
	  {
		return rand(10000,99999);
	  }
	
	 //remove trailing unwanted keywords

		return GeneralHelpers::remove_trailing_words($text);
	}
	
	static public function remove_trailing_words($text)
	{
		if(substr($text, -3) == 'jpg') { $text = substr($text, 0, -3); }
		if(substr($text, -3) == 'gif') { $text = substr($text, 0, -3); }
		if(substr($text, -3) == 'php') { $text = substr($text, 0, -3); }
		if(substr($text, -3) == 'htm') { $text = substr($text, 0, -3); }
		if(substr($text, -3) == ' asp') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == 'png') { $text = substr($text, 0, -3); }
		if(substr($text, -4) == 'html') { $text = substr($text, 0, -4); }
		if(substr($text, -4) == 'aspx') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == ' com') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == 'with') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == ' and') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == 'free') { $text = substr($text, 0, -4); }
		if(substr($text, -3) == 'online') { $text = substr($text, 0, -6); }
	return rtrim($text, "-");
	
	}
	
	
	static public function get_extension($fullurl)
	{ 
	$array = explode("/", $fullurl);
	$info = new SplFileInfo(end($array));
	return $info->getExtension();
	}
	
	static public function get_filename($fullurl)
	{ 
	$array = explode("/", $fullurl);
	$info = new SplFileInfo(end($array));
	return $info->getFilename();
	}
	
	
	static public function get_last_segment($fullurl)
	{ 
	$array = explode("/", $fullurl);
	return end($array);
	}
	
	static public function convert_to_array($text)
	{ 
	$text = GeneralHelpers::slugify($text);
	$text = trim(str_replace("-"," ",$text));
	$array = explode(" ", $text);
	
	// Clean number and words with less than 2 characters
	$outputarray = array();
	foreach($array as $value) {
		if(!preg_match('/[0-9]/i', $value) AND strlen($value) > 2) {
			array_push($outputarray, $value);
		}
		}

	return $outputarray;
	}
	
	static public function get_rank($option,$keyword)
	{ 
	$keywordarray = GeneralHelpers::convert_to_array($keyword);
	$optionarray = GeneralHelpers::convert_to_array($option);
	return count(array_intersect($optionarray,$keywordarray))/count($keywordarray) + count($optionarray)*.00025;
	}
	
	//Decided which label to use the title
	static public function image_name_decide($keyword,$option1,$option2,$option3)
	{ 
	$option2 = GeneralHelpers::get_filename($option2);
	$option3 = GeneralHelpers::get_filename($option3);

	$option1array = GeneralHelpers::convert_to_array($option1);
	$option2array = GeneralHelpers::convert_to_array($option2);
	$option3array = GeneralHelpers::convert_to_array($option3);

	
	if (GeneralHelpers::get_rank($option1,$keyword) >= GeneralHelpers::get_rank($option2,$keyword) AND GeneralHelpers::get_rank($option1,$keyword) >= GeneralHelpers::get_rank($option3,$keyword)) {
			if(count($option1array) > 1) {
			return GeneralHelpers::remove_trailing_words(implode(" ", array_slice($option1array, 0, rand(6,8))));
			} else {
			return $keyword;
			}
		} elseif (GeneralHelpers::get_rank($option2,$keyword) >= GeneralHelpers::get_rank($option3,$keyword) AND GeneralHelpers::get_rank($option2,$keyword) >= GeneralHelpers::get_rank($option1,$keyword)) {
			if(count($option2array) > 1) {
			return GeneralHelpers::remove_trailing_words(implode(" ", array_slice($option2array, 0, rand(6,8))));
			} else {
			return $keyword;
			}
		} else {
				if(count($option3array) > 1) {
			return GeneralHelpers::remove_trailing_words(implode(" ", array_slice($option3array, 0, rand(6,8))));
			} else {
			return $keyword;
			}
	}
	
	}
	
	//Get Image
	static public function  get_new_dimension_array($width,$height,$size_type)
	{
	
		if((Config::get('general.width_' . $size_type . '_max') == $width AND Config::get('general.height_' . $size_type . '_max') == $height) OR
			(Config::get('general.width_' . $size_type . '_max') == $width AND Config::get('general.height_' . $size_type . '_max') > $height) OR
			(Config::get('general.width_' . $size_type . '_max') > $width AND Config::get('general.height_' . $size_type . '_max') == $height) OR
			(Config::get('general.width_' . $size_type . '_max') > $width AND Config::get('general.height_' . $size_type . '_max') > $height))
		{
		//Retain same dimensions
		$new_height = $height;
		$new_width = $width;
		} elseif ((Config::get('general.width_' . $size_type . '_max') < $width AND Config::get('general.height_' . $size_type . '_max') == $height) OR
			(Config::get('general.width_' . $size_type . '_max') < $width AND Config::get('general.height_' . $size_type . '_max') > $height))
		{
		//Reduce width dimension
		$difference = $width - Config::get('general.width_' . $size_type . '_max');
		$new_width = $width - $difference;
		$new_height = $height - $difference/$width*$height;
		
		} elseif((Config::get('general.width_' . $size_type . '_max') == $width AND Config::get('general.height_' . $size_type . '_max') < $height) OR
			(Config::get('general.width_' . $size_type . '_max') > $width AND Config::get('general.height_' . $size_type . '_max') < $height)) {
		//Reduce height dimension
		$difference = $height - Config::get('general.height_' . $size_type . '_max');
		$new_height = $height - $difference;
		$new_width = $width - $difference/$height*$width;

		} else {
		//Reduce both dimension
			//Check ratio of extra/original, whichever is higher use that ratio
			if($width/Config::get('general.width_' . $size_type . '_max') > $height/Config::get('general.height_' . $size_type . '_max'))
			{
			//Use ratio of Width
			$difference = $width - Config::get('general.width_' . $size_type . '_max');
			$new_width = $width - $difference;
			$new_height = $height - $difference/$width*$height;
			} else {
			//Use ratio of Height
			$difference = $height - Config::get('general.height_' . $size_type . '_max');
			$new_height = $height - $difference;
			$new_width = $width - $difference/$height*$width;
			
			}
		
		}
		
	//Thumbnail Crop? - Add a hook
		if(Config::get('general.autocrop_sm') AND $size_type == 'sm') {
		$crop_ratio = Config::get('general.width_sm_max')/Config::get('general.height_sm_max');
		$current_ratio = $width/$height;
			if($crop_ratio == $current_ratio) {
				$new_height = Config::get('general.height_sm_max');
				$new_width = Config::get('general.width_sm_max');
			} elseif($crop_ratio > $current_ratio) {
				$difference = $width - Config::get('general.width_' . $size_type . '_max');
				$new_width = $width - $difference;
				$propotional_height = $height - $difference/$width*$height;
			} else {
				$difference = $height - Config::get('general.height_' . $size_type . '_max');
				$new_height = $height - $difference;
				$propotional_width = $width - $difference/$height*$width;
			}
		}
	
	
	$new_width = floor($new_width); $new_height = floor($new_height);
	return array('new_width' => $new_width,'new_height' => $new_height,);
	}
	

	
  			
}
