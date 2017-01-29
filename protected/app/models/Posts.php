<?php
class Posts extends BaseModel  {
	
	protected $table = 'tb_posts';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_posts.* FROM tb_posts  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_posts.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
