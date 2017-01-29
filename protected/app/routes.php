<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::controller('user', 'UserController'); 
#Route::get('/', 'HomeController@index');
#Route::get('/', function() { return '';});
Route::get('/', 'FrontController@indexDisplay');
Route::controller('home', 'HomeController');
Route::group(array('before' => 'auth'), function() 
{
	/* CORE APPLICATION DONT DELETE IT */
	Route::controller('pages', 'PagesController');
	Route::controller('users', 'UsersController');
	Route::controller('groups', 'GroupsController');
	Route::controller('menu', 'MenuController');
	Route::controller('module', 'ModuleController');
	Route::controller('config', 'ConfigController');
	
	/* END CORE APPLICATION  */
	
	/* Dynamic Routers */
	Route::get('process', 'ProcessController@getIndex');
	Route::get('process/start', 'ProcessController@startProcess');
	
	Route::get('bulk', 'BulkController@getIndex');
	Route::post('bulk/start', 'BulkController@startProcess');
	include('moduleroutes.php');
});	
Route::get('process/automatic', 'ProcessController@startProcess');
Route::get('sitemap/generate', 'SitemapController@generateSitemap');
Route::get('/goto/{imageid}', function($imageid)
{
$allimages = DB::select('SELECT original_page_url FROM tb_images where id = "'.$imageid.'"');

if(count($allimages) == 0) {
return Redirect::to('/', 302); 
 } else 
{
return Redirect::to($allimages[0]->original_page_url, 302); 
}
});

Route::post('/download', function()
{
    $data = Input::all();
	Input::flashOnly('width', 'height', 'effect');
	$ratio_original = $data['currentwidth']/$data['currentheight'];
	$ratio_required = $data['width']/$data['height'];
	$width_adjust = $data['width'] + 1;
	if ($ratio_required < 1 AND $ratio_original > 1) {
		//Image is landscape
		$rules = array(
		'width' => 'required|integer|min:'. $width_adjust .'|max:'.$data['currentwidth'].'',
		'height' => 'required|integer|min:'.Config::get('general.height_min').'|max:'.$data['currentheight'].''
		);
		$messages = array(
		'width.min' => 'The ratio of the :attribute is not in proportion to the height. Since the image is a landscape format then the height should be smaller than the width.',
		);
	}  elseif ($ratio_required > 1 AND $ratio_original < 1) {
		//Image is portrait
		$rules = array(
		'width' => 'required|integer|min:'. $width_adjust .'|max:'.$data['currentwidth'].'',
		'height' => 'required|integer|min:'.Config::get('general.height_min').'|max:'.$data['currentheight'].''
		);
		$messages = array(
		'width.min' => 'The ratio of the :attribute is not in proportion to the height. Since the image is a portrait format then the height should be larger than the width.',
		);
	} else {
		$rules = array(
		'width' => 'required|integer|min:'.Config::get('general.width_min').'|max:'.$data['currentwidth'].'',
		'height' => 'required|integer|min:'.Config::get('general.height_min').'|max:'.$data['currentheight'].''
		);
		$messages = array(
		'width.required' => 'The :attribute is required.',
		);
	}
    // Create a new validator instance.
    $validator = Validator::make($data, $rules,  $messages);
	
	if ($validator->passes()) {
     return with(new Front)->imageDownload($data['currentwidth'],$data['currentheight'],$data['width'],$data['height'],$data['path'],$data['slug'],$data['extension'],$data['effect'],$ratio_original,$ratio_required);
    } else {
    return Redirect::to($data['slug'].'#error')->withErrors($validator);
	}
});

Route::get('indexpage', 'FrontController@indexDisplay');
Route::get('post/{posturl}', 'FrontController@postDisplay');
Route::get('page/{pageurl}', 'FrontController@pageDisplay');
Route::get('tags/{tag1}/{tag2?}/{tag3?}', 'FrontController@tagDisplay');
Route::get('{imageurl}', 'FrontController@imageDisplay');