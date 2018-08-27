<?php
namespace App\Http\Controllers\Property;

use Illuminate\Http\Request;
use App\OfficeBuilding as Building;
use Addons\Core\Controllers\ApiTrait;
use App\Role;
use DB;

class BuildingController extends BaseController
{
    // public $permissions = ['building'];
    use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$office_building = new Building;
		$size = $request->input('size') ?: config('size.models.'.$office_building->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('property.building.list');
	}

	public function data(Request $request)
	{
		$office_building = new Building;
		$builder = $office_building->newQuery()->with(['properter','pics','floors','hires','peripheries'])->property($this->properter->getKey());

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['pic'] = $value->pic();
    		     $tag_data = $value->tags;
    		     $tags = !empty($tag_data)?$tag_data->pluck('tag_name'):'';
    		     $value['tags'] = is_array($tags)?join(',',$tags):'-';
    		     $value['tag_ids'] = !empty($tag_data)?$tag_data->pluck('id'):'';
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$office_building = new Building;
		$builder = $office_building->newQuery()->property($this->properter->getKey())->with(['properter']);
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
		$office_building = Building::with(['properter'])->property($this->properter->getKey())->find($id);
		if (empty($office_building))
			return $this->failure_noexists();

		$this->_data = $office_building;
		return !$request->offsetExists('of') ? $this->view('property.building.show') : $this->api($office_building->toArray());
	}

	public function create()
	{
		$keys = 'village_name,building_name,province,city,area,address,longitude,latitude,pic_ids,tag_ids';
		$infoKey_str = 'occupancy_rate,owner_type,floor_cnt,level,floor_height,property_price,property_type,developer,avg_price,parking_space_cnt,parking_price,publish_time,area_covered,standard_area,upstairs_cnt,downstairs_cnt,plot_ratio,green_ratio';
		$keys .=','.$infoKey_str;
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('building.store', $keys);
		return $this->view('property.building.create');
	}

	public function store(Request $request)
	{
		$keys = 'village_name,building_name,province,city,area,address,longitude,latitude,pic_ids,tag_ids';
		$infoKey_str = 'occupancy_rate,owner_type,floor_cnt,level,floor_height,property_price,property_type,developer,avg_price,parking_space_cnt,parking_price,publish_time,area_covered,standard_area,upstairs_cnt,downstairs_cnt,plot_ratio,green_ratio';
		
		$keys .=','.$infoKey_str;
		$data = $this->autoValidate($request, 'building.store', $keys);

		$pic_ids = array_pull($data, 'pic_ids');
		$tag_ids = array_pull($data, 'tag_ids');
		
		$infoKeys = explode(',', $infoKey_str);
		$info = array_only($data, $infoKeys);

		$data = array_except($data, $infoKeys);
		DB::transaction(function() use ($infoKeys,$info,$data,$pic_ids,$tag_ids){
		    $office_building = Building::create($data+['property_id'=>$this->properter->getKey()]);
		    foreach ($pic_ids as $value){
		        $office_building->pics()->create(['pic_id' => $value]);
		    }
		    
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $office_building->tags()->sync($attach_data);

		    $office_building->info()->create($info);
		});
		
		return $this->success('', url('property/building'));
	}

	public function edit($id)
	{
		$office_building = Building::with(['pics','info'])->property($this->properter->getKey())->find($id);
		if (empty($office_building))
			return $this->failure_noexists();

		$keys = 'village_name,building_name,province,city,area,address,longitude,latitude,pic_ids,tag_ids';
		$infoKey_str = 'occupancy_rate,owner_type,floor_cnt,level,floor_height,property_price,property_type,developer,avg_price,parking_space_cnt,parking_price,publish_time,area_covered,standard_area,upstairs_cnt,downstairs_cnt,plot_ratio,green_ratio';
		
		$keys .=','.$infoKey_str;
		$this->_validates = $this->getScriptValidate('building.store', $keys);
		
		$office_building['tag_ids'] = !empty($office_building->tags)?$office_building->tags->pluck(['id'])->toArray():[];
		$this->_data = $office_building;
		return $this->view('property.building.edit');
	}

	public function update(Request $request, $id)
	{
		$office_building = Building::property($this->properter->getKey())->find($id);
		if (empty($office_building))
			return $this->failure_noexists();

		$keys = 'village_name,building_name,province,city,area,address,longitude,latitude,pic_ids,tag_ids';
		$infoKey_str = 'occupancy_rate,owner_type,floor_cnt,level,floor_height,property_price,property_type,developer,avg_price,parking_space_cnt,parking_price,publish_time,area_covered,standard_area,upstairs_cnt,downstairs_cnt,plot_ratio,green_ratio';
		
		$keys .=','.$infoKey_str;
		$data = $this->autoValidate($request, 'building.store', $keys, $office_building);
		
		$pic_ids = array_pull($data, 'pic_ids');
		$tag_ids = array_pull($data, 'tag_ids');
		
		$infoKeys = explode(',', $infoKey_str);
		$info = array_only($data, $infoKeys);

		$data = array_except($data, $infoKeys);
		DB::transaction(function() use ($office_building, $infoKeys,$info,$data,$pic_ids,$tag_ids){
		    $office_building->update($data);
		    $office_building->pics()->delete();
		    foreach ($pic_ids as $value){
		        $office_building->pics()->create(['pic_id' => $value]);
		    }
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $office_building->tags()->sync($attach_data);
		    
		    $office_building->info()->update($info);
		});
		
		return $this->success('', url('property/building/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$office_building = Building::property($this->properter->getKey())->where('id',$v)->delete();
		return $this->success('', count($id) > 5, compact('id'));
	}
}
