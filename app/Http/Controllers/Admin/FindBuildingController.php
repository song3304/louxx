<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FindBuilding as Building;
use Addons\Core\Controllers\ApiTrait;
use App\Role;
use DB;

class FindBuildingController extends Controller
{
	use ApiTrait;
	//public $permissions = ['office_building'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$find_building = new Building;
		$size = $request->input('size') ?: config('size.models.'.$find_building->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.find_building.list');
	}

	public function data(Request $request)
	{
		$find_building = new Building;
		$builder = $find_building->newQuery()->with(['province_name','city_name','area_name']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$office_building = new Building;
		$builder = $office_building->newQuery()->with(['province_name','city_name','area_name']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      //$value['building_status'] =  $value->status_tag();
		    }
		}, ['*']);
		return $this->_export($data);
	}


	public function show(Request $request,$id)
	{
		$office_building = Building::with(['province_name','city_name','area_name'])->find($id);
		if (empty($office_building))
			return $this->failure_noexists();

		$this->_data = $office_building;
		return !$request->offsetExists('of') ? $this->view('admin.find_building.show') : $this->api($office_building->toArray());
	}

	public function create()
	{
		$keys = 'province,city,area,rent_low,rent_high,phone,note';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('find-building.store', $keys);
		return $this->view('admin.find_building.create');
	}

	public function store(Request $request)
	{
		$keys = 'province,city,area,rent_low,rent_high,phone,note';
		$data = $this->autoValidate($request, 'find-building.store', $keys);
        $find_building = Building::create($data);
		return $this->success('', url('admin/find-building'));
	}

	public function edit($id)
	{
		$find_building = Building::find($id);
        if (empty($find_building))
            return $this->failure_noexists();

        $keys = 'province,city,area,rent_low,rent_high,phone,note';
        $this->_validates = $this->getScriptValidate('find-building.store', $keys);
        $this->_data = $find_building;
        return $this->view('admin.find_building.edit');
	}

	public function update(Request $request, $id)
	{
		$find_building = Building::find($id);
        if (empty($find_building))
            return $this->failure_noexists();

        $keys = 'province,city,area,rent_low,rent_high,phone,note';
        $data = $this->autoValidate($request, 'find-building.store', $keys, $find_building);
        $find_building->update($data);
        return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$find_building = Building::destroy($v);
		return $this->success('');
	}
}
