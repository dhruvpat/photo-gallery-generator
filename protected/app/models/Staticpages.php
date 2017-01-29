<?php
class Staticpages extends BaseModel  {
	
	protected $table = 'tb_staticpages';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_staticpages.* FROM tb_staticpages  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_staticpages.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
