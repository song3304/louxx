<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Properter;
use Addons\Core\Controllers\ApiTrait;
use App\Role;
use DB;

class ProperterController extends Controller
{
	use ApiTrait;
	//public $permissions = ['properter'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$properter = new Properter;
		$size = $request->input('size') ?: config('size.models.'.$properter->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.properter.list');
	}

	public function data(Request $request)
	{
		$properter = new Properter;
		$builder = $properter->newQuery()->with(['user']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$properter = new Properter;
		$builder = $properter->newQuery()->with(['user']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['properter_status'] =  $value->status_tag();
		    }
		}, ['properters.*']);
		return $this->export($data);
	}

	public function show(Request $request,$id)
	{
		$properter = Properter::with(['user'])->find($id);
		if (empty($properter))
			return $this->failure_noexists();

		$this->_data = $properter;
		return !$request->offsetExists('of') ? $this->view('admin.properter.show') : $this->api($properter->toArray());
	}

	public function create()
	{
		$keys = 'id,name,province,city,area,address,phone';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('properter.store', $keys);
		return $this->view('admin.properter.create');
	}

	public function store(Request $request)
	{
		$keys = 'id,name,province,city,area,address,phone';
		$data = $this->autoValidate($request, 'properter.store', $keys);

		Properter::create($data);
		$properter = Properter::find($data['id']);
		if(!$properter->user->hasRole('properter')) $properter->user->attachRole(Role::findByName('properter'));
		return $this->success('', url('admin/properter'));
	}

	public function edit($id)
	{
		$properter = Properter::find($id);
		if (empty($properter))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone';
		$this->_validates = $this->getScriptValidate('properter.store', $keys);
		$this->_data = $properter;
		return $this->view('admin.properter.edit');
	}

	public function update(Request $request, $id)
	{
		$properter = Properter::find($id);
		if (empty($properter))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone';
		$data = $this->autoValidate($request, 'properter.store', $keys, $properter);
		$properter->update($data);
		if(!$properter->user->hasRole('properter')) $properter->user->attachRole(Role::findByName('properter'));
		return $this->success('', url('admin/properter/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$properter = Properter::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
