<?php
namespace App;

use App\Model;

class Tag extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public static function covertToIds($keywords_list)
	{
		$id = array();
		if (empty($keywords_list)) return $id;
		foreach ($keywords_list as $keywords)
			$id[] = self::firstOrCreate(compact('tag_name','type'))->getKey();
		return $id;
	}

	public function type_name()
	{
	    if($this->type == 0) return '办公楼';
	    else return '公司';
	}
	
	//办公楼
	public function buildings()
	{
	    return $this->belongsToMany('App\\OfficeBuilding', 'office_tag_relations', 'tid','oid');
	}

	//公司 
	public function companies()
	{
	    return $this->belongsToMany('App\\Company', 'company_tag_relations','tid','cid');
	}
}
