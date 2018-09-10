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

class HomeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $this->_city_id = session('city_id',null);
	    $this->_keywords = $request->input('keywords');
	    $this->_area_id = $request->input('area_id');
	    $this->_distance_scope = $request->input('distance_scope');
	    $this->_price_scope = $request->input('price_scope');
	    
	    // 页面实时获取经纬度
	    $lat = $request->input('lat',session('lat'));
	    $lon = $request->input('lon',session('lon'));
	    
	    // 如果没有定位到城市，用地图定位到城市，刷新页面
	    
	    $building = new Buildings();
	    $builder = $building->newQuery();
	    if(!empty($this->_city_id)){
	        $builder->whereRaw("(province='".$this->_city_id."' or city='".$this->_city_id."')");
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
	    if(!empty($this->_distance_scope)){
	        $builder->select('*', DB::raw('ROUND(
                6378.138 * 2 * ASIN(
                    SQRT(
                        POW(
                            SIN(
                                (
                                    '.$lon.' * PI() / 180 - lat * PI() / 180
                                ) / 2
                            ),
                            2
                        ) + COS('.$lon.' * PI() / 180) * COS(lat * PI() / 180) * POW(
                            SIN(
                                (
                                    '.$lat.' * PI() / 180 - lon * PI() / 180
                                ) / 2
                            ),
                            2
                        )
                    )
                ) * 1000
            ) AS juli'));
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
	            default:
	                $distance = [0,3000];
	        }
	        $builder->whereBetween('juli',$distance);
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
	    
	    $buildings = $builder->with(['pics','tags','info','hires'])->get();
	    //整理数据
	    
	    $this->_buildings = $buildings;
		return $this->view('index.index');
	}

    // 定位城市,保存
	public function setCity(Request $request){
	    $city_name = $request->input('city_name');
	    $lat = $request->input('lat');
	    $lon = $request->input('lon');
	    if(!empty($lat)) session(['lat'=>$lat]);
	    if(!empty($lon)) session(['lon'=>$lon]);
	    if(empty($city_name)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }else{
	        $area = Area::where('area_name','like',$city_name.'%')->first();
	        if(!empty($area)){
	            // 没有找到城市默认北京
	            session(['city_id'=>110000]);
	            return $this->failure('home.fix_position_fail',url('home/index'),['msg'=>'定位失败']);
	        }else{
	            session(['city_id'=>$area->area_id]);
	            return $this->success('home.fix_position_success',url('home/index'),['msg'=>'定位成功']);
	        }
	    }
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
	    return $this->view('index.office');
	}
	// 楼层信息
	public function floor(Request $request)
	{
	    $fid = $request->input('fid');
	    if(empty($fid)){
	        return $this->error_param(url('home/index'),['msg'=>'参数错误']);
	    }
	    $this->_floor = OfficeFloor::with(['companies'])->find($fid);
	    if(empty($this->_floor)){// 不存在
	        return $this->failure_noexists();
	    }
	    return $this->view('index.floor');
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
	    return $this->view('index.company');
	}
}
