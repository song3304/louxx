<?php
namespace App;

use Addons\Core\Models\Tree;
use Addons\Core\Models\TreeCacheTrait;
use Illuminate\Support\Arr;
use Cache;
use Laravel\Scout\Searchable;
class Catalog extends Tree {
	use TreeCacheTrait;
	//use Searchable;
	//不能批量赋值
	public $orderKey = 'order_index';
	public $pathKey = NULL;
	public $levelKey = NULL;

	public $casts = [
		'extra' => 'array',
	];

	protected $guarded = ['id'];

	public static function getCatalogsByName($name = NULL)
	{
		empty(static::$cacheTree) && static::getAll('name');
		$name = str_replace(['.', '.children.children', '.children.children'], ['.children.', '.children', '.children'], $name);
		return is_null($name) ? static::$cacheTree['name'] : 
			(empty($name) || in_array($name, ['none', 'null']) ? static::find(0)->toArray() : Arr::get(static::$cacheTree['name'], $name));
	}

	public static function getCatalogsById($id = NULL)
	{
		empty(static::$cacheTree) && static::getAll();
		return is_null($id) ? static::$cacheTree['id'][ 0 ][ 'children' ] : 
			(empty($id) ? static::find(0)->toArray() : Arr::get(static::$cacheTree['id'], $id));
	}
}
