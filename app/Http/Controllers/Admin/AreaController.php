<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Addons\Core\Controllers\ApiTrait;
use DB;
use App\Area;

class AreaController extends Controller
{
	use ApiTrait;
	public function data(Request $request)
	{
		$area = new Area;
		$builder = $area->newQuery();
		
		$total = $this->_getCount($request, $builder, FALSE);
		$builder = $builder->orderBy('area_id','asc');
		
		$data = $this->_getData($request, $builder, null);
		$inputs = $request->input('f', []);
		if($inputs['parent_id']===''){
		    $data['data'] = [];
		    $data['recordsTotal'] = 0;
		    $data['recordsFiltered'] = 0;
		}else{
		    $data['recordsTotal'] = $total; //不带 f q 条件的总数
		    $data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		}
		return $this->api($data);
	}
}
