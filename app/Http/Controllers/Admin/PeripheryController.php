<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfficePeriphery as Periphery;
use Addons\Core\Controllers\ApiTrait;
use DB;

class PeripheryController extends Controller
{
	use ApiTrait;
	//public $permissions = ['office_periphery'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$office_periphery = new Periphery;
		$size = $request->input('size') ?: config('size.models.'.$office_periphery->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.periphery.list');
	}

	public function data(Request $request)
	{
		$office_periphery = new Periphery;
		$builder = $office_periphery->newQuery()->with(['building']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     $value['type_tag'] = $value->type_tag();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$office_periphery = new Periphery;
		$builder = $office_periphery->newQuery()->with(['building']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     
		    }
		}, ['*']);
		return $this->_export($data);
	}

	public function show(Request $request,$id)
	{
		$office_periphery = Periphery::with(['building'])->find($id);
		if (empty($office_periphery))
			return $this->failure_noexists();

		$this->_data = $office_periphery;
		return !$request->offsetExists('of') ? $this->view('admin.periphery.show') : $this->api($office_periphery->toArray());
	}

	public function create()
	{
		$keys = 'oid,name,type,longitude,latitude';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('periphery.store', $keys);
		return $this->view('admin.periphery.create');
	}

	public function store(Request $request)
	{
		$keys = 'oid,name,type,longitude,latitude';
		$data = $this->autoValidate($request, 'periphery.store', $keys);

		$office_periphery = Periphery::create($data);
		return $this->success('', url('admin/periphery'));
	}

	public function edit($id)
	{
		$office_periphery = Periphery::find($id);
		if (empty($office_periphery))
			return $this->failure_noexists();

		$keys = 'oid,name,type,longitude,latitude';
		$this->_validates = $this->getScriptValidate('periphery.store', $keys);
		$this->_data = $office_periphery;
		return $this->view('admin.periphery.edit');
	}

	public function update(Request $request, $id)
	{
		$office_periphery = Periphery::find($id);
		if (empty($office_periphery))
			return $this->failure_noexists();

		$keys = 'oid,name,type,longitude,latitude';
		$data = $this->autoValidate($request, 'periphery.store', $keys, $office_periphery);
		$office_periphery->update($data);

		return $this->success('', url('admin/periphery/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$office_periphery = Periphery::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
