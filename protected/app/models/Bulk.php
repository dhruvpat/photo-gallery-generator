<?php

class Bulk extends Eloquent  {
	


	public function __construct() {
		parent::__construct();
		
	}

	public static function getPostCount(){
	$count =  Process::all()->count();
	return $count;
	}
	
	public static function getPostNewKeywordCount(){
	$count =  DB::select("SELECT * FROM tb_posts WHERE workflow_status = 'new keyword'")->count();
	return $count;
	}
	

	
	public function grab_image($url,$imagename){
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
		$saveto = "/var/www2/cal/cal.calamarine.org/images/temp/" . $imagename;
		if(file_exists($saveto)){
			unlink($saveto);
		}

	$fp = fopen($saveto,'x');
	fwrite($fp, $raw);
	fclose($fp);
	if(file_exists($saveto)) {
		return $saveto;
		} else {
		return FALSE;
		}
	}
	

}
