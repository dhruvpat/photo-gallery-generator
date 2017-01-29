<?php
class Images extends BaseModel  {
	
	protected $table = 'tb_images';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_images.* FROM tb_images  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_images.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
