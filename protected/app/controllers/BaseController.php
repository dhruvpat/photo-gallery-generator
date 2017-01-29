<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	//public $menus =''; 
	
	public function __construct() {
		
		$this->menus = SiteHelpers::menus(); 
		$this->sidebar = SiteHelpers::menus('sidebar'); 
		$driver = Config::get('database.default');
		$database = Config::get('database.connections');
		$this->db = $database[$driver]['database'];		
		
		
	}
	 
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	function prepare()
	{
		
		$info = $this->model->makeInfo( $this->module);	
		$data = array(
			'tableGrid' => $this->info['grid']
		);	
		return $data;	
		
	}
	
	function infoTable()
	{
		$info = $this->model->makeInfo( $this->module);
		return $info['module_config']['grid'];
	}
	
	function getDownload()
	{
	
		$info = $this->model->makeInfo( $this->module);
		$results 	= $this->model->getRows( $params = array() );
		$fields		= $info['config']['grid'];
		$rows		= $results['rows'];
		
		$content = $this->data['pageTitle'];
		$content .= '<table border="1">';
		$content .= '<tr>';
		foreach($fields as $f )
		{
			if($f['download'] =='1') $content .= '<th style="background:#f9f9f9;">'. $f['label'] . '</th>';
		}
		$content .= '</tr>';
		
		foreach ($rows as $row)
		{
			$content .= '<tr>';
			foreach($fields as $f )
			{
				if($f['download'] =='1')	$content .= '<td>'. $row->$f['field'] . '</td>';
			}
			$content .= '</tr>';
		}
		$content .= '</table>';
		
		@header('Content-Type: application/ms-excel');
		@header('Content-Length: '.strlen($content));
		@header('Content-disposition: inline; filename="'.$title.' '.date("d/m/Y").'.xls"');
		
		echo $content;
		exit;
		
		
		//return View::make('excel',$this->data);		
	}
	
	function postSearch()
	{
		$keyword = $this->module;
		if(!is_null(Input::get('keyword')))
		{
			$keyword = $this->module.'?search='.str_replace(' ','_',Input::get('keyword'));		
		}
		return Redirect::to($keyword);
	
	}
	
	function postFilter()
	{
		$module = $this->module;
		$sort 	= (!is_null(Input::get('sort')) ? Input::get('sort') : '');
		$order 	= (!is_null(Input::get('order')) ? Input::get('order') : '');
		$rows 	= (!is_null(Input::get('rows')) ? Input::get('rows') : '');
		$filter = '?';
		if($sort!='') $filter .= '&sort='.$sort; 
		if($order!='') $filter .= '&order='.$order; 
		if($rows!='') $filter .= '&rows='.$rows; 
		 

		return Redirect::to($module . $filter);
	
	}	
	
	function injectPaginate()
	{
		$sort 	= (!is_null(Input::get('sort')) ? Input::get('sort') : '');
		$order 	= (!is_null(Input::get('order')) ? Input::get('order') : '');
		$rows 	= (!is_null(Input::get('rows')) ? Input::get('rows') : '');
		$search 	= (!is_null(Input::get('search')) ? Input::get('search') : '');
		$masterDetail 	= (!is_null(Input::get('md')) ? Input::get('md') : '');
		$appends = array();
		if($sort!='') 	$appends['sort'] = $sort; 
		if($order!='') 	$appends['order'] = $order; 
		if($rows!='') 	$appends['rows'] = $rows; 
		if($search!='') $appends['search'] = $search; 
		if($masterDetail!='') $appends['md'] = $masterDetail; 
		return $appends;
			
	}

	function infoFieldSearch()
	{
		$info =$this->model->makeInfo( $this->module);
		$forms = $info['config']['forms'];
		$data = array();
		foreach($forms as $f)
		{
			if($f['search'] ==1) 	
            	if($f['alias'] !='' )  {
				$data[] =  array('id'=> $f['alias'].".".$f['field']);
			}
		}
		return $data;		
	}	
	function buildSearch()
	{
		$keywords = '';
		$fields = '';
		$param ='';
	
		if(!is_null(Input::get('search')))
		{
			
			$i=0;
			$fields = $this->infoFieldSearch();
			if(count($fields) >=1)
			{
				foreach($fields as $val)
				{
						if(++$i ==1) {
								$param .= " AND ( {$val['id']} LIKE '%". Input::get('search') ."%%' ";
						} else { 
								$param .= " OR {$val['id']} LIKE '%". Input::get('search') ."%%' ";
						}
				}
				$param .= ")";
			}			
		} else {
			
		}	
		//echo $param;exit;
		
		return $param;
	
	}
	
	function buildMasterDetail( $template = null)
	{
		// check if url contain $_GET['md'] , that mean master detail
		if(!is_null(Input::get('md')))
		{
			
			$values 				= array();
			$data 					= explode(" ", Input::get('md') );
			// Split all param get 
			$master 				= ucwords($data[0]) ; $master_key = $data[1]; $module = $data[2]; $key = $data[3];  $val = $data[4];
			$val 					=  SiteHelpers::encryptID($val,true) ;
			$values['row'] 			= $master::getRow( $val );
			$loadInfo 				= $master::makeInfo( $master);
			$values['grid']         = $loadInfo ['config']['grid'];
			$filter 				= 	" AND  ".$this->info['table'].".".$key."='".$val."' ";	
			if($template != null)
			{
				$view 					= View::make($template, $values); 			
			} else {	
				$view 					= View::make('layouts/masterview', $values); 
			}	
			$result = array(
				'masterFilter' => $filter,
				'masterView'	=> $view
			);
			return $result;	
			
		} else {
			$result = array(
				'masterFilter' => '',
				'masterView'	=> ''
			);	
			return $result;		
		}
			
	
	}
	
	function getComboselect()
	{
		$param = explode(':',Input::get('filter'));
		$rows = $this->model->getComboselect($param);
		$items = array();
		foreach($rows as $row) 
		{
			$items[] = array($row->$param['1'] , $row->$param['2']); 	

		}
		
		return json_encode($items); 	
	}
	
	function getCombotable()
	{
		$rows = $this->model->getTableList($this->db);
		$items = array();
		foreach($rows as $row) $items[] = array($row , $row); 	
		return json_encode($items); 	
	}		
	
	function getCombotablefield()
	{
		$items = array();
		$table = Input::get('table');
		if($table !='')
		{
			$rows = $this->model->getTableField(Input::get('table'));			
			foreach($rows as $row) 
				$items[] = array($row , $row); 				 	
		} 
		return json_encode($items);	
	}		

	
	function validatePost(  $table )
	{		
		
//		$str = SiteHelpers::columnTable($table); 
		
		$str = $this->info['config']['forms'];
		$data = array();
		foreach($str as $f){
			$field = $f['field'];
			if($f['view'] ==1) 
			{
		
				if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
				{
					$data[$field] =  Purifier::clean(Input::get($field)); 
				} else {

					SiteHelpers::globalXssClean();
					if(!is_null(Input::get($field)))
					{
						$data[$field] = Input::get($field);				
					}
					// if post is file or image			
					if($f['type'] =='file')
					{				
						if(!is_null(Input::file($field)))
						{
							$file = Input::file($field); 
							$destinationPath = './'.str_replace('.','',$f['option']['path_to_upload']);
							$filename = $file->getClientOriginalName();
							//$extension =$file->getClientOriginalExtension(); //if you need extension of the file
							$uploadSuccess = Input::file($field)->move($destinationPath, $filename);
							 
							if( $uploadSuccess ) {
							   $data[$field] = $filename;
							} 
						}					
					}
					// if post is checkbox	
					if($f['type'] =='checkbox')
					{
						if(!is_null(Input::get($field)))
						{
							$data[$field] = implode(",",Input::get($field));
						}	
					}
					// if post is date						
					if($f['type'] =='date')
					{
						$data[$field] = date("Y-m-d",strtotime(Input::get($field)));
					}
				}	 						

			}	
		}
		 $global	= (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );
		
		if($global == 0 )
			$data['entry_by'] = Session::get('gid');
					
		return $data;
	}
	
	function validAccess( $methode )
	{

		if($this->model->validAccess( $methode ,$this->info['id']) == false)
		{
			return Redirect::to('home')
			->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));
			
		}
		
	}		
							

}