<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Queue;
use Illuminate\Support\Str;
use App\User;
use Session;
use App\Area;
use App\OfficeBuilding as Buildings;
use DB;
use App\OfficeBuilding;
use App\OfficeFloor;
use App\Company;
use App\OfficePeriphery;
use App\HireInfo;
use GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Auth;

class HomeController extends WechatOAuth2Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $this->_city_name = $request->input('city_name',session('city_name',''));
	    $this->_city_id = session('city_id',null);;
	    $this->_keywords = $request->input('keywords');
	    $this->_area_id = $request->input('area_id');
	    $this->_distance_scope = $request->input('distance_scope');
	    $this->_price_scope = $request->input('price_scope');
	    
	    // 页面实时获取经纬度
	    $lat = $request->input('lat');
	    $lon = $request->input('lon');
	    
	    $building = new Buildings();
	    $builder = $building->newQuery();
	    if(!empty($this->_city_id)){
	        $builder->whereRaw("(province='".$this->_city_id."' or city='".$this->_city_id."')");
	        //分配区域
	        $areaList = [];
	        $areas= Area::with(['children'])->where('parent_id',$this->_city_id)->get();
	        foreach ($areas as $area){
	            if(!empty($area->children)){
	                foreach ($area->children as $child){
	                    $areaList[] = ['area_id'=>$child->area_id,'area_name'=>$child->area_name];
	                }
	            }
	        }
	        $this->_areaList = !empty($areaList)?$areaList:$areas;
	    }
	    // 处理关键字
	    if(!empty($this->_keywords)){
	        $builder->where('building_name','like','%'.$this->_keywords.'%');
	    }
	    //处理区域
	    if(!empty($this->_area_id)){
	        $builder->whereRaw("(city='".$this->_area_id."' or area='".$this->_area_id."')");
	    }
	    // 处理距离
	    if(!empty($this->_distance_scope) && !empty($lat) && !empty($lon)){
	        $juli = $this->__juli($lat, $lon);
	        $builder->select('*', DB::raw($juli.' as juli'));
	        $distance = [];
	        switch ($this->_distance_scope){
	            case 1:
	                $distance = [0,1000];
	                break;
	            case 2:
	                $distance = [1000,2000];
	                break;
	            case 3:
	                $distance = [2000,5000];
	                break;
	            case 4:
	                $distance = [5000,10000];
	                break;
	            default:
	                $distance = [0,3000];
	        }
	        $builder->whereRaw($juli.'>='.$distance[0].' and '.$juli.'<='.$distance[1]);
	    }
	    // 处理价格
	    if(!empty($this->_price_type)){
	        $prices = [];
	        switch ($this->_price_type){
	            case 1:
	                $prices = [0,10];
	                break;
	            case 1:
	                $prices = [10,20];
	                break;
	            case 3:
	                $prices = [20,30];
	                break;
	            default:
	                $prices = [0,30];
	                break;
	        }
	        $builder->ofPrice($prices);
	    }
	    if(!empty($this->_price_scope)){
	        $builder->ofPrice($this->_price_scope);
	    }
	    
	    $buildings = $builder->select('office_buildings.*')->with(['pics','tags','info','hires'])->get();
	    if($request->ajax()) return $this->success(null,null,['buildings'=>$buildings]);
	    //整理数据
	    $this->_buildings = $buildings;
	    //微信jssdk
	    $this->_wechat = $this->getJsParameters();
	    //dd($this->_wechat);
		return $this->view('index.index');
	}
    
	//距离查找sql
	private function __juli($lat,$lon){
	    $juli = 'ROUND(
            6378.138 * 2 * ASIN(
                SQRT(
                    POW(
                        SIN(
                            (
                                '.$lat.' * PI() / 180 - latitude * PI() / 180
                            ) / 2
                        ),
                        2
                    ) + COS('.$lat.' * PI() / 180) * COS(latitude * PI() / 180) * POW(
                        SIN(
                            (
                                '.$lon.' * PI() / 180 - longitude * PI() / 180
                            ) / 2
                        ),
                        2
                    )
                )
            ) * 1000
        )';
	    return $juli;
	}
	
    // 定位城市,保存
	public function setCity(Request $request){
	    $city_name = $request->input('city_name');
	    if(empty($city_name)){
	         $city_id = session('city_id',null);
	    }else{
	        session(['city_name'=>$city_name]);
	        $area = Area::where('area_name','like',$city_name.'%')->first();
	        if(empty($area)){
	            // 没有找到城市默认北京
	            session(['city_id'=>110000]);
                $city_id = 110000;
	        }else{
	            session(['city_id'=>$area->area_id]);
	            $city_id = $area->area_id;
	        }
	    }
	    return $this->success(null,null,['city_id'=>$city_id]);
	}
	// 获取区域
	public function getAreaList(Request $request){
	    $city_id = $request->input('city_id');
	    $areaList = [];
	    $areas= Area::with(['children'])->where('parent_id',$city_id)->select('area_id','area_name')->get();
	    foreach ($areas as $area){
	        if(!empty($area->children)){
	            foreach ($area->children as $child){
	                $areaList[] = ['area_id'=>$child->area_id,'area_name'=>$child->area_name];
	            }
	        }
	    }
	    $areaList = !empty($areaList)?$areaList:$areas;
	    return $this->success(null,null,['areaList'=>$areaList]);
	}
	// 办公楼详情
	public function office(Request $request)
	{
	    $oid = $request->input('oid');
	    if(empty($oid)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }
	    $this->_office = OfficeBuilding::with(['pics','tags','info','hires'])->find($oid);
	    if(empty($this->_office)){// 不存在
	        return $this->failure_noexists();
	    }
	    //楼层信息
	    $this->_floor_list = OfficeFloor::where('oid',$oid)->get();
	    //dd($this->_floor_list);
	    //周边
	    $peripheries_info = [
	        ['name'=>'餐厅','list'=>[]],
	        ['name'=>'酒店','list'=>[]],
	        ['name'=>'健身','list'=>[]],
	        ['name'=>'银行','list'=>[]]
	    ];
	    $this->_peripheries = OfficePeriphery::where('oid',$oid)->get();
	    foreach ($this->_peripheries as $periphery){
	        in_array($periphery->type,[0,1,2,3]) && $peripheries_info[$periphery->type]['list'][] = $periphery;
	    }
	    $this->_peripheries_info = $peripheries_info;
	    //招租信息
	    $this->_hire_info_list = HireInfo::with('pics')->where('oid',$oid)->orderBy('created_at','desc')->get();
	    //dd($this->_hire_info_list);
	    //dd($this->_office);
	    return $this->view('index.office');
	}
	// 楼层信息
	public function floor(Request $request)
	{
	    $fid = $request->input('fid');
	    if(empty($fid)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }
	    $this->_floor = OfficeFloor::with(['companies','tags'])->find($fid);
	    if(empty($this->_floor)){// 不存在
	        return $this->failure_noexists();
	    }
	    //dd($this->_floor);
	    return $this->view('index.floor');
	}
	//查找公司
	public function findCompany(Request $request)
	{
	    $keywords = $request->input('keywords');
	    if(empty($keywords)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }
	    $this->_keywords = $keywords;
	    $this->_company_list = Company::with('tags')->where('name','like','%'.$keywords.'%')->get();
	    return $this->view('index.search_company');
	}
	// 公司信息
	public function company(Request $request)
	{
	    $cid = $request->input('cid');
	    if(empty($cid)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }
	    $this->_company = Company::with('tags')->find($cid);
	    if(empty($this->_company)){
	        return $this->failure_noexists();
	    }
	    //dd($this->_company);
	    return $this->view('index.company');
	}
}
