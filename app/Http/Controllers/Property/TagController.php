<?php
namespace App\Http\Controllers\Property;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Addons\Core\Controllers\ApiTrait;
use DB;

class TagController extends BaseController
{
	use ApiTrait;
	//public $permissions = ['tag'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function data(Request $request)
	{
		$tag = new Tag;
		$builder = $tag->newQuery()->with(['buildings','companies']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['type_name'] = $value->type_name();
    		     $value['building_cnt'] = $value->buildings->count();
    		     $value['company_cnt'] = $value->companies->count();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}
}
