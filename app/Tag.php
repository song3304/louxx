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

	//办公楼
	public function buildings()
	{
	    return $this->belongsToMany('App\\OfficeBuilding', 'office_tag_relations', 'oid', 'tid');
	}

	//公司 
	public function companies()
	{
	    return $this->belongsToMany('App\\Company', 'company_tag_relations', 'cid', 'tid');
	}
}
