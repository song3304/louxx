<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfficeFloor as Floor;
use Addons\Core\Controllers\ApiTrait;
use DB;

class FloorController extends Controller
{
	use ApiTrait;
	//public $permissions = ['office_floor'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$office_floor = new Floor;
		$size = $request->input('size') ?: config('size.models.'.$office_floor->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.floor.list');
	}

	public function data(Request $request)
	{
		$office_floor = new Floor;
		$builder = $office_floor->newQuery()->with(['building','companies','tags']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder->orderBy('porder','desc'),function(&$datalist){
		    foreach ($datalist as &$value){
    		     $value['company_cnt'] = $value->companies->count();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$office_floor = new Floor;
		$builder = $office_floor->newQuery()->with(['building','companies','tags']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     
		    }
		}, ['*']);
		return $this->_export($data);
	}

	public function show(Request $request,$id)
	{
		$office_floor = Floor::with(['building','companies','tags'])->find($id);
		if (empty($office_floor))
			return $this->failure_noexists();

		$this->_data = $office_floor;
		return !$request->offsetExists('of') ? $this->view('admin.floor.show') : $this->api($office_floor->toArray());
	}

	public function create()
	{
		$keys = 'oid,name,description,porder,tag_ids';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('floor.store', $keys);
		return $this->view('admin.floor.create');
	}

	public function store(Request $request)
	{
		$keys = 'oid,name,description,porder,tag_ids';
		$data = $this->autoValidate($request, 'floor.store', $keys);
		
		$tag_ids = array_pull($data, 'tag_ids');
		DB::transaction(function() use ($data,$tag_ids){
		    $office_floor = Floor::create($data);
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $office_floor->tags()->attach($attach_data);
		});
		
		return $this->success('', url('admin/floor'));
	}

	public function edit($id)
	{
		$office_floor = Floor::with(['building','companies','tags'])->find($id);
		if (empty($office_floor))
			return $this->failure_noexists();

		$keys = 'oid,name,description,porder,tag_ids';
		$this->_validates = $this->getScriptValidate('floor.store', $keys);
		$this->_data = $office_floor;
		return $this->view('admin.floor.edit');
	}

	public function update(Request $request, $id)
	{
		$office_floor = Floor::find($id);
		if (empty($office_floor))
			return $this->failure_noexists();

		$keys = 'oid,name,description,porder,tag_ids';
		$data = $this->autoValidate($request, 'floor.store', $keys, $office_floor);
		$tag_ids = array_pull($data, 'tag_ids');
		
		DB::transaction(function() use ($office_floor,$data,$tag_ids){
		    $office_floor->update($data);
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $office_floor->tags()->sync($attach_data);
		});

		return $this->success('', url('admin/floor/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$office_floor = Floor::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
