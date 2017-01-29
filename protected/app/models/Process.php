<?php

class Process extends Eloquent  {
	


	public function __construct() {
		parent::__construct();
		
	}

	//Get Bing Json
	public static function getBingJson($keyword,$offset)
	{
	$rootUri = 'https://api.datamarket.azure.com/Bing/Search';
	$query = str_replace("-", " ", trim($keyword));
	$serviceOp = 'Image';$query = urlencode("'$query'");$market = urlencode("'".Config::get('general.bing_market')."'");$adult = urlencode("'Strict'"); 
	$imagefilters = urlencode("'".Config::get('general.bing_filters')."'");
	// Construct the full URL for the query. https://api.datamarket.azure.com/Bing/Search/Web?format=json&Adult=Moderate&Query=Webmaster&Market=en-gb
	// https://api.datamarket.azure.com/Bing/Search/Image?format=json&Adult=Strict&Query=flights&Market=en-gb
	$requestUri = "$rootUri/$serviceOp?\$format=json&Adult=$adult&ImageFilters=$imagefilters&Query=$query&Market=$market&\$skip=$offset";
	
	echo $requestUri;
	// Encode the credentials and create the stream context.
	$auth = base64_encode(Config::get('general.bing_key').":".Config::get('general.bing_key'));

	$data = array(

	'http' => array('request_fulluri' => true,
	// ignore_errors can help debug – remove for production. This option added in PHP 5.2.10
	'ignore_errors' => true,'header' => "Authorization: Basic $auth")
	);
	$context = stream_context_create($data);
	$response = file_get_contents($requestUri, 0, $context);
	return json_decode($response, TRUE);
	}
	
	public static function getPostCount(){
	$count =  DB::table("tb_posts")->count();
	return $count;
	}
	
	public static function getPostNewKeywordCount(){
	$count =  DB::table("tb_posts")->where('workflow_stage', 'new_keyword')->count();
	return $count;
	}
	

	
	public function grab_image($url,$image_temp_location){
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout in seconds
		$agents = array(
		'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
		'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
		'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
		'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
		);
		curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);
		$raw=curl_exec($ch);
		curl_close ($ch);

		if(file_exists($image_temp_location)){
			unlink($image_temp_location);
		}

	$fp = fopen($image_temp_location,'x');
	fwrite($fp, $raw);
	fclose($fp);
	if(file_exists($image_temp_location)) {
		return TRUE;
		} else {
		return FALSE;
		}
	}
	
	
	
	
	// Grab Multiple Images at once
	
	public function grab_bulk_images($all_image_urls, $opts = array()) {
	
	$aURLs = $all_image_urls;
	//$aURLs = array('http://www.imcdb.org/res/lng_de.png', 'http://www.imcdb.org/res/lng_uk.png', 'http://www.imcdb.org/res/lng_fr.png'); // array of URLs
    $mh = curl_multi_init(); // init the curl Multi
   
    $aCurlHandles = array(); // create an array for the individual curl handles

    foreach ($aURLs as $id=>$url) { //add the handles for each url
        //$ch = curl_setup($url,$socks5_proxy,$usernamepass);
        $ch = curl_init(); // init curl, and then setup your options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // returns the result - very important
        curl_setopt($ch, CURLOPT_HEADER, 0); // no headers in the output

        $aCurlHandles[$url] = $ch;
        curl_multi_add_handle($mh,$ch);
    }
   
    $active = null;
    //execute the handles
    do {
        $mrc = curl_multi_exec($mh, $active);
    }
    while ($mrc == CURLM_CALL_MULTI_PERFORM);

    while ($active && $mrc == CURLM_OK) {
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }
   
/* This is the relevant bit */
        // iterate through the handles and get your content
    foreach ($aCurlHandles as $url=>$ch) {
        $raw_content = curl_multi_getcontent($ch); // get the content
		
        // do what you want with the HTML
		//echo $html;
		$fp = fopen(Config::get('general.image_folder_path') . 'temp/temp'.md5($url),'x');
		fwrite($fp, $raw_content);
		fclose($fp);
		
        curl_multi_remove_handle($mh, $ch); // remove the handle (assuming  you are done with it);
    }
/* End of the relevant bit */

    curl_multi_close($mh); // close the curl multi handler
	return TRUE;
	
	}
	

}
