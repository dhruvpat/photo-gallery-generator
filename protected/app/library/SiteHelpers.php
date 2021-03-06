<?php
class SiteHelpers
{
/**
* Returns the last performed database query
*
* @return string
*/
	public static function menus( $position ='top',$active = '1')
	{
		$data = array();  
		$menu = self::nestedMenu(0,$position ,$active);		
		foreach ($menu as $row) 
		{
			$child_level = array();
			$p = json_decode($row->access_data,true);
			
			
			if($row->allow_guest == 1)
			{
				$is_allow = 1;
			} else {
				$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
			}
			if($is_allow ==1) 
			{
				
				$menus2 = self::nestedMenu($row->menu_id , $position ,$active );
				if(count($menus2) > 0 )
				{	 
					$level2 = array();							 
					foreach ($menus2 as $row2) 
					{
						$p = json_decode($row2->access_data,true);
						if($row2->allow_guest == 1)
						{
							$is_allow = 1;
						} else {
							$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
						}						
									
						if($is_allow ==1)  
						{						
					
							$menu2 = array(
									'menu_id'		=> $row2->menu_id,
									'module'		=> $row2->module,
									'menu_name'		=> $row2->menu_name,
									'menu_icons'	=> $row2->menu_icons,
									'childs'		=> array()
								);	
												
							$menus3 = self::nestedMenu($row2->menu_id , $position , $active);
							if(count($menus3) > 0 )
							{
								$child_level_3 = array();
								foreach ($menus3 as $row3) 
								{
									$p = json_decode($row3->access_data,true);
									if($row3->allow_guest == 1)
									{
										$is_allow = 1;
									} else {
										$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
									}										
									if($is_allow ==1)  
									{								
										$menu3 = array(
												'menu_id'		=> $row3->menu_id,
												'module'		=> $row3->module,
												'menu_name'		=> $row3->menu_name,
												'menu_icons'	=> $row3->menu_icons,
												'childs'		=> array()
											);	
										$child_level_3[] = $menu3;	
									}					
								}
								$menu2['childs'] = $child_level_3;
							}
							$level2[] = $menu2 ;
						}	
					
					}
					$child_level = $level2;
						
				}
				
				$level = array(
						'menu_id'		=> $row->menu_id,
						'module'		=> $row->module,
						'menu_name'		=> $row->menu_name,
						'menu_icons'	=> $row->menu_icons,
						'childs'		=> $child_level
					);			
				
				$data[] = $level;	
			}	
				
		}	
		//echo '<pre>';print_r($data); echo '</pre>'; exit;
		return $data;
	}
	
	public static function nestedMenu($parent=0,$position ='top',$active = '1')
	{
		$group_sql = " AND tb_menu_access.group_id ='".Session::get('gid')."' ";
		$active 	=  ($active =='all' ? "" : "AND active ='1' ");
		$Q = DB::select("
		SELECT 
			tb_menu.*
		FROM tb_menu WHERE parent_id ='". $parent ."' ".$active." AND position ='{$position}'
		GROUP BY tb_menu.menu_id ORDER BY ordering			
		");					
		return $Q;					
	}
	
	public static function CF_encode_json($arr) {
	  $str = json_encode( $arr );
	  $enc = base64_encode($str );
	  $enc = strtr( $enc, 'poligamI123456', '123456poligamI');
	  return $enc;
	}
	
	public static function CF_decode_json($str) {
	  $dec = strtr( $str , '123456poligamI', 'poligamI123456');
	  $dec = base64_decode( $dec );
	  $obj = json_decode( $dec ,true);
	  return $obj;
	}	
	
	
	public static function columnTable( $table )
	{	  
        $columns = array();
	    foreach(DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[] = $column->Field;
        }
	  

        return $columns;
	}	
	
	public static function encryptID($id,$decript=false,$pass='',$separator='-', & $data=array()) {
		$pass = $pass?$pass:Config::get('app.key');
		$pass2 = Config::get('app.url');;
		$bignum = 200000000;
		$multi1 = 500;
		$multi2 = 50;
		$saltnum = 10000000;
		if($decript==false){
			$strA = self::alphaid(($bignum+($id*$multi1)),0,0,$pass);
			$strB = self::alphaid(($saltnum+($id*$multi2)),0,0,$pass2);
			$out = $strA.$separator.$strB;
		} else {
			$pid = explode($separator,$id);
			
			
		//    trace($pid);
			$idA = (self::alphaid($pid[0],1,0,$pass)-$bignum)/$multi1;
			$idB = (self::alphaid($pid[1],1,0,$pass2)-$saltnum)/$multi2;
			$data['id A'] = $idA;
			$data['id B'] = $idB;
			$out = ($idA==$idB)?$idA:false;
		}
		return $out;
	}
	
public static function alphaID($in, $to_num = false, $pad_up = false, $passKey = null)
{
    $index = "abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    if ($passKey !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID
 
        for ($n = 0; $n<strlen($index); $n++) {
            $i[] = substr( $index,$n ,1);
        }
 
        $passhash = hash('sha256',$passKey);
        $passhash = (strlen($passhash) < strlen($index))
            ? hash('sha512',$passKey)
            : $passhash;
 
        for ($n=0; $n < strlen($index); $n++) {
            $p[] =    substr($passhash, $n ,1);
        }
 
        array_multisort($p,    SORT_DESC, $i);
        $index = implode($i);
    }
 
    $base    = strlen($index);
 
    if ($to_num) {
        // Digital number    <<--    alphabet letter code
        $in    = strrev($in);
        $out = 0;
        $len = strlen($in) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out     = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
        }
 
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
        $out = sprintf('%F', $out);
        $out = substr($out, 0, strpos($out, '.'));
    } else {
        // Digital number    -->>    alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;
            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }
 
        $out = "";
        for ($t = floor(log($in, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a     = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in    = $in - ($a * $bcp);
        }
        $out = strrev($out); // reverse
    }
 
    return $out;
}	
		
	
	public static function toForm($forms)
	{
		$f = '';
	//	echo '<pre>'; print_r($forms);echo '</pre>';
		//usort($forms,"_sort"); 

		$group = array(); 
		
		foreach($forms as $form)
		{
			$tooltip ='';
			if($form['view'] != 0)
			{
				if($form['field'] !='entry_by')
				{
					if(isset($form['option']['tooltip']) && $form['option']['tooltip'] !='') 	
					$tooltip = '<a href="#" data-toggle="tooltip" placement="left" class="showTooltip" title="'. $form['option']['tooltip'] .'"><i class="icon-question-sign"></></a>';	
					$hidethis = ""; if($form['type'] =='hidden') $hidethis ='hidethis';
					$inhide = ''; if(count($group) >1) $inhide ='inhide';
					//$ebutton = ($form['type'] =='radio' || $form['option'] =='checkbox') ? "ebutton-radio" : "";
					$show = '';
					if($form['type'] =='hidden') $show = 'style="display:none;"';					
					$f .= '					
					  <div class="form-group '.$hidethis.' '.$inhide.'" '.$show .'>
						<label for="ipt" class=" control-label col-md-4 text-right"> '.$form['label'].' </label>
						<div class="col-md-8">
						  '.self::formShow($form['type'],$form['field'],$form['required'],$form['option']).' '.$tooltip.'
						 </div> 
					  </div> '; 
				}	  
				
			}					
		}

		return $f;
	
	}
	
	public static function formShow( $type , $field , $required ,$option = array()){
		//print_r($option);
		$mandatory = '';$attribute = ''; $extend_class ='';
		if(isset($option['attribute']) && $option['attribute'] !='') {
				$attribute = $option['attribute']; }
		if(isset($option['extend_class']) && $option['extend_class'] !='') {
			$extend_class = $option['extend_class']; 
		}				
				
		$show = '';
		if($type =='hidden') $show = 'style="display:none;"';	
				
		if($required =='required') {
			$mandatory = "'required'=>'true'";
		} else if($required =='email') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'email' ";
		} else if($required =='url') {
			$mandatory = "required parsley-type='url' ";
		} else if($required =='date') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'dateIso' ";
		} else if($required =='numeric') {
			$mandatory = "'required'=>'true', 'parsley-type'=>'number' ";
		} else {
			$mandatory = '';
		}		
		
		switch($type)
		{
			default;
				$form = "{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control', 'placeholder'=>'', {$mandatory}  )) }}";
				break;
				
			case 'textarea';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='2' id='{$field}' class='form-control {$extend_class}'  
				         {$mandatory} {$attribute} >{{ \$row['{$field}'] }}</textarea>";
				break;

			case 'textarea_editor';
				if($required !='0') { $mandatory = 'required'; }
				$form = "<textarea name='{$field}' rows='2' id='editor' class='form-control editor {$extend_class}'  
						{$mandatory}{$attribute} >{{ \$row['{$field}'] }}</textarea>";
				break;				
				

			case 'text_date';
				$form = "
				{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control date', 'style'=>'width:150px !important;')) }}";
				break;
				
			case 'text_time';
				$form = "<input  type='text' name='{$field}' id='{$field}' value='{{ \$row['{$field}'] }}' 
						{$mandatory}  {$attribute} style='width:150px !important;'  class='form-control {$extend_class}'
						data-date-format='yyyy-mm-dd'
						 />";
				break;				

			case 'text_datetime';
				if($required !='0') { $mandatory = 'required'; }
				$form = "
				{{ Form::text('{$field}', \$row['{$field}'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) }}";
				break;				

			case 'select';
				if($required !='0') { $mandatory = 'requred'; }
				if($option['opt_type'] =='datalist')
				{
					$optList ='';
					$opt = explode("|",$option['lookup_query']);
					for($i=0; $i<count($opt);$i++) 
					{					
						
						$row =  explode(":",$opt[$i]);
						$optList .= "
							<option  value ='".trim($row[0])."' 
							@if(\$row['".$field."'] =='".trim($row[0])."')
								selected=\"selected\"
							@endif
							>".ltrim(rtrim($row[1]))."</option>";
					}
					$form = "
					<select name='{$field}' rows='5' id='{$field}' code='{\${$field}}' {$mandatory}  
					class='select2 form-control {$extend_class}'  {$attribute} >
						$optList
					</select>";
				} else {
					$form = "<select name='{$field}' rows='5' id='{$field}' code='{\${$field}}' 
							class='select2 form-control {$extend_class}'  {$mandatory} {$attribute} ></select>";
				}
				break;	
				
			case 'file';
				if($required !='0') { $mandatory = 'requred'; }
				$form = "<input  type='file' name='{$field}' id='{$field}' class='{$extend_class}'  
					{$mandatory} style='width:150px !important;' {$attribute} />
					{{ SiteHelpers::showUploadedFile(\$row['{$field}'],'$option[path_to_upload]') }}
				";
				break;						
				
			case 'radio';
				if($required !='0') { $mandatory = 'requred'; }
				$opt = explode("|",$option['lookup_query']);
				$form = '';
				for($i=0; $i<count($opt);$i++) 
				{
					$checked = '';
					$row =  explode(":",$opt[$i]); 
					$form .= "
					<label class='radio radio-inline'>
					<input type='radio' name='{$field}' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute}";
					$form .= "@if(\$row['".$field."'] == '".ltrim(rtrim($row[0]))."') checked=\"checked\" @endif";
					$form .= " > ".$row[1]." </label>";
				}
				break;
				
			case 'checkbox';
				if($required !='0') { $mandatory = 'requred'; }
				$opt = explode("|",$option['lookup_query']);
				$form = "<?php \$".$field." = explode(\",\",\$row['".$field."']); ?>";
				for($i=0; $i<count($opt);$i++) 
				{
					
					$checked = '';
					$row =  explode(":",$opt[$i]);					
					 $form .= "
					 <label class='checked checkbox-inline'>  
					<input type='checkbox' name='{$field}[]' value ='".ltrim(rtrim($row[0]))."' {$mandatory} {$attribute} class='{$extend_class}' ";
					$form .= "
					@if(in_array('".trim($row[0])."',\$".$field."))checked @endif 
					";
					$form .= " /> ".$row[1]." </label> ";					
				}
				break;				
			
		}
		
		return $form;		
	}
	
	public static function toView( $grids )
	{
		$f = '';
		foreach($grids as $grid)
		{
			if($grid['detail'] =='1')  
			{
				if($grid['attribute']['image']['active'] =='1')
				{	
					$val = "{{ SiteHelpers::showUploadedFile(\$row->".$grid['field'].",'".$grid['attribute']['image']['path']."') }}";	
				} else {
					$val = "{{ \$row->".$grid['field']." }}"; 
				}
				$f .= "
					<tr>
						<td width='30%' class='label-view text-right'>".$grid['label']."</td>
						<td>".$val." </td>
						
					</tr>
				";
			}
		}
		return $f;
	}
	

	public static function blend($str,$data) {
		$src = $rep = array();
		
		foreach($data as $k=>$v){
			$src[] = "{".$k."}";
			$rep[] = $v;
		}
		
		if(is_array($str)){
			foreach($str as $st ){
				$res[] = trim(str_ireplace($src,$rep,$st));
			}
		} else {
			$res = str_ireplace($src,$rep,$str);
		}
		
		return $res;
		
	}			
		
	public static function toJavascript( $forms , $app , $class )
	{
		$f = '';
		foreach($forms as $form){
			if($form['view'] != 0)
			{			
				if(preg_match('/(select)/',$form['type'])) 
				{
					if($form['option']['opt_type'] == 'external') 
					{
						$table 	=  $form['option']['lookup_table'] ;
						$val 	=  $form['option']['lookup_value'];
						$key 	=  $form['option']['lookup_key'];
						$lookey = '';
						if($form['option']['is_dependency']) $lookey .= $form['option']['lookup_dependency_key'] ;
						$f .= self::createPreCombo( $form['field'] , $table , $key , $val ,$app, $class , $lookey  );
							
					}
									
				}
				
			}	
		
		}
		return $f;	
	
	}
	
	public static function createPreCombo( $field , $table , $key ,  $val ,$app ,$class ,$lookey = null)
	{


		
		$parent = null;
		$parent_field = null;
		if($lookey != null)  
		{	
			$parent = " parent: '#".$lookey."',";
			$parent_field =  "&parent={$lookey}&parent_val=";
		}	
		$pre_jCombo = "
		\$(\"#{$field}\").jCombo(\"{{ URL::to('{$class}/comboselect?filter={$table}:{$key}:{$val}') }}\",
		{ ".$parent." selected_value : '{{ \$row['{$field}'] }}' });
		";	
		return $pre_jCombo;
	}	
	
	public static function alert( $task , $message)
	{
		if($task =='error') {
			$alert ='
			<div class="alert alert-danger  fade in block-inner">
				<button data-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-cancel-circle"></i> '. $message.' </div>
			';			
		} elseif ($task =='success') {
			$alert ='
			<div class="alert alert-success fade in block-inner">
				<button data-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-checkmark-circle"></i> '. $message.' </div>
			';			
		} elseif ($task =='warning') {
			$alert ='
			<div class="alert alert-warning fade in block-inner">
				<button data-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-warning"></i> '. $message.' </div>
			';			
		} else {
			$alert ='
			<div class="alert alert-info  fade in block-inner">
				<button data-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-info"></i> '. $message.' </div>
			';			
		}
		return $alert;
	
	} 		

	public static function _sort($a, $b) {
	 
		if ($a['sortlist'] == $a['sortlist']) {
		return strnatcmp($a['sortlist'], $b['sortlist']);
		}
		return strnatcmp($a['sortlist'], $b['sortlist']);
	}
	
	public static function showUploadedFile($file,$path) {
	
		$files =  public_path().str_replace('.','',$path). $file ;
		if(file_exists('./'.$files ) && $file !="") {
		//	echo $files ;
			$info = pathinfo($files);		
			if($info['extension'] == "jpg" || $info['extension'] == "jpeg" ||  $info['extension'] == "png" || $info['extension'] == "gif") {
				$path_file = str_replace("./","",$path);
				return '<p><a href="'.URL::to(''). $path_file . $file.'" target="_blank">
				<img src="'.URL::to(''). $path_file . $file.'" border="0" width="75" /></a></p>';
			} else {
				$path_file = str_replace("./","",$path);
				return '<p> <a href="'.URL::to(''). $path_file . $file.'" target="_blank"> '.$file.' </a>';
			}
	
		}

	}	

	public static function globalXssClean()
	{
	    // Recursive cleaning for array [] inputs, not just strings.
	    $sanitized = static::arrayStripTags(Input::get());
	    Input::merge($sanitized);
	}
	 
	public static function arrayStripTags($array)
	{
	    $result = array();
	 
	    foreach ($array as $key => $value) {
	        // Don't allow tags on key either, maybe useful for dynamic forms.
	        $key = strip_tags($key);
	 
	        // If the value is an array, we will just recurse back into the
	        // function to keep stripping the tags out of the array,
	        // otherwise we will set the stripped value.
	        if (is_array($value)) {
	            $result[$key] = static::arrayStripTags($value);
	        } else {
	            // I am using strip_tags(), you may use htmlentities(),
	            // also I am doing trim() here, you may remove it, if you wish.
	            $result[$key] = trim(strip_tags($value));
	        }
	    }
	 
	    return $result;
	}
	
	public static function writeEncoder($val) {
		return base64_encode($val);
	}
	
	public static function readEncoder($val) {
		return base64_decode($val);
	}
  			
}
