<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Properter;
use App\ProperterApply;
use Addons\Core\Controllers\ApiTrait;
use App\Role;
use DB;

class ProperterAuditController extends Controller
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
		$properterApply = new ProperterApply;
		$size = $request->input('size') ?: config('size.models.'.$properterApply->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.properter_apply.list');
	}

	public function data(Request $request)
	{
		$properterApply = new ProperterApply;
		$builder = $properterApply->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['status_tag'] =  $value->status_tag();
		      $value['username'] =  !empty($value->user)?$value->user->username:'';
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$properterApply = new ProperterApply;
		$builder = $properterApply->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		      $value['status_tag'] =  $value->status_tag();
		    }
		}, ['*']);
		return $this->_export($data);
	}

	public function show(Request $request,$id)
	{
		$properterApply = ProperterApply::find($id);
		if (empty($properterApply))
			return $this->failure_noexists();

		$this->_data = $properterApply;
		return !$request->offsetExists('of') ? $this->view('admin.properter_apply.show') : $this->api($properterApply->toArray());
	}

	public function create()
	{
		$keys = 'id,name,province,city,area,address,phone';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('properter-apply.store', $keys);
		return $this->view('admin.properter_apply.create');
	}

	public function store(Request $request)
	{
		$keys = 'id,name,province,city,area,address,phone';
		$data = $this->autoValidate($request, 'properter-apply.store', $keys);

		ProperterApply::create($data);//
		$properterApply = ProperterApply::find($data['id']);
		if(!$properterApply->user->hasRole('properter')) $properterApply->user->attachRole(Role::findByName('properter'));
		return $this->success('', url('admin/properterApply'));
	}

	public function edit($id)
	{
		$properterApply = ProperterApply::find($id);
		if (empty($properterApply))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone,audit_note,status,uid';
		$this->_validates = $this->getScriptValidate('properter-apply.store', $keys);
		$this->_data = $properterApply;
		return $this->view('admin.properter_apply.edit');
	}
    //审核
	public function update(Request $request, $id)
	{
		$properterApply = ProperterApply::find($id);
		if (empty($properterApply))
			return $this->failure_noexists();

		$keys = 'id,name,province,city,area,address,phone,audit_note,status,uid';
		$data = $this->autoValidate($request, 'properter-apply.store', $keys, $properterApply);		
		$properterApply->update($data);
		
		//if(!$properterApply->user->hasRole('properter')) $properterApply->user->attachRole(Role::findByName('properter'));
		return $this->success('', url('admin/properterApply'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$properterApply = ProperterApply::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
