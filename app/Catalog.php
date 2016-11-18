<?php
namespace App;

use Addons\Core\Models\Tree;
use Illuminate\Support\Arr;
use Cache;
class Catalog extends Tree {
	//不能批量赋值
	public $fire_caches = ['catalogs'];
	public $orderKey = 'order_index';
	public $pathKey = NULL;
	public $levelKey = NULL;

	public $casts = [
		'extra' => 'array',
	];

	protected $guarded = ['id'];

	public static $catalogs;

	public static function getCatalogs()
	{
		empty(static::$catalogs) && static::$catalogs = Cache::remember('catalogs', config('cache.ttl'), function(){
			$model = new static;
			$catalogs = static::where($model->getKeyName(), '>', 0)->orderBy($model->getOrderKeyName())->get()->keyBy($model->getKeyName())->toArray();
			foreach ($catalogs as $item)
				$catalogs[ ($item[$model->getParentKeyName()]) ][ 'children' ][ ($item[$model->getKeyName()]) ] = &$catalogs[ ($item[$model->getKeyName()]) ];
			//得到一颗以id为key树
			$root = $catalogs[ 0 ][ 'children' ]; 

			//将树的key变为name
			$catalogs_with_name = [];
			$method = function(&$from_data, &$todata) use(&$method) {
				foreach($from_data as &$value)
				{
					$todata[$value['name']] = $value;
					unset($todata[$value['name']]['children']);
					!empty($value['children']) && $method($value['children'], $todata[$value['name']]['children']);
				}
			};
			$method($root, $catalogs_with_name);

			return ['id' => $catalogs, 'name' => $catalogs_with_name, 'null' => static::find(0)->toArray()];
		});
		return static::$catalogs;
	}

	public static function getCatalogsByName($name = NULL)
	{
		empty(static::$catalogs) && static::$catalogs = static::getCatalogs();
		$name = str_replace(['.', '.children.children', '.children.children'], ['.children.', '.children', '.children'], $name);
		return is_null($name) ? static::$catalogs['name'] : (empty($name) || in_array($name, ['none', 'null']) ? static::$catalogs['null'] : Arr::get(static::$catalogs['name'], $name));
	}

	public static function getCatalogsById($id = NULL)
	{
		empty(static::$catalogs) && static::$catalogs = static::getCatalogs();
		return is_null($id) ? static::$catalogs['id'][ 0 ][ 'children' ] : (empty($id) ? static::$catalogs['null'] : Arr::get(static::$catalogs['id'], $id));
	}
}

Catalog::saved(function(){
	Catalog::$catalogs = NULL;
});
Catalog::deleted(function(){
	Catalog::$catalogs = NULL;
});