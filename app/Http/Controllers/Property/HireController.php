<?php
namespace App\Http\Controllers\Property;

use Illuminate\Http\Request;
use App\HireInfo;
use Addons\Core\Controllers\ApiTrait;
use DB;

class HireController extends BaseController
{
	use ApiTrait;
	//public $permissions = ['hire'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$hire = new HireInfo;
		$size = $request->input('size') ?: config('size.models.'.$hire->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('property.hire.list');
	}

	public function data(Request $request)
	{
		$hire = new HireInfo;
		$builder = $hire->newQuery()->with(['building','floor'])->buildings($this->building_ids);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		        $value['pic'] = $value->pic();
    		    $value['status_tag'] = $value->status_tag();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$hire = new HireInfo;
		$builder = $hire->newQuery()->with(['building','floor','pics'])->buildings($this->building_ids);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     
		    }
		}, ['hires.*']);
		return $this->export($data);
	}

	public function show(Request $request,$id)
	{
		$hire = HireInfo::with(['building','floor','pics'])->buildings($this->building_ids)->find($id);
		if (empty($hire))
			return $this->failure_noexists();

		$this->_data = $hire;
		return !$request->offsetExists('of') ? $this->view('property.hire.show') : $this->api($hire->toArray());
	}

	public function create()
	{
		$keys = 'oid,fid,rent,per_rent,acreage,min_station_cnt,max_station_cnt,note,status,pic_ids';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('hire.store', $keys);
		return $this->view('property.hire.create');
	}

	public function store(Request $request)
	{
		$keys = 'oid,fid,rent,per_rent,acreage,min_station_cnt,max_station_cnt,note,status,pic_ids';
		$data = $this->autoValidate($request, 'hire.store', $keys);

		$pic_ids = array_pull($data, 'pic_ids');
		
		DB::transaction(function() use ($data,$pic_ids){
		    $hire = HireInfo::create($data);
		    foreach ($pic_ids as $value){
		        $hire->pics()->create(['pic_id' => $value]);
		    }
		});
		
		return $this->success('', url('property/hire'));
	}

	public function edit($id)
	{
		$hire = HireInfo::with(['building','floor','pics'])->find($id);
		if (empty($hire))
			return $this->failure_noexists();

		$keys = 'oid,fid,rent,per_rent,acreage,min_station_cnt,max_station_cnt,note,status,pic_ids';
		$this->_validates = $this->getScriptValidate('hire.store', $keys);
		$this->_data = $hire;
		//dd($hire);
		return $this->view('property.hire.edit');
	}

	public function update(Request $request, $id)
	{
		$hire = HireInfo::buildings($this->building_ids)->find($id);
		if (empty($hire))
			return $this->failure_noexists();

		$keys = 'oid,fid,rent,per_rent,acreage,min_station_cnt,max_station_cnt,note,status,pic_ids';
		$data = $this->autoValidate($request, 'hire.store', $keys, $hire);
		
		$pic_ids = array_pull($data, 'pic_ids');
		
		DB::transaction(function() use ($hire,$data,$pic_ids){
		    $hire->update($data);
		    $hire->pics()->delete();
		    foreach ($pic_ids as $value){
		        $hire->pics()->create(['pic_id' => $value]);
		    }
		});

		return $this->success('', url('property/hire/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$hire = HireInfo::buildings($this->building_ids)->where('id',$v)->delete();
		return $this->success('', count($id) > 5, compact('id'));
	}
	
	public function toggle($id){
	    $hire = HireInfo::buildings($this->building_ids)->find($id);
	    if (empty($hire)||$hire->status == -1)
	        return $this->failure_noexists();
	
	    $hire->update(['status'=>$hire->status?0:1]);
	    return $this->success('', url('property/hire'));
	}
}
