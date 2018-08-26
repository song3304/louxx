<?php

namespace App\Http\Controllers\Salon;

use App\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;
use Addons\Core\Controllers\AdminTrait;

class BannerController extends BaseController
{
    use AdminTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banner = new Banner();
        $builder = $banner->newQuery()->with(['salons','navigations'])->where('mid', $this->salon->getKey());
        $pagesize = $request->input('pagesize') ?: config('site.pagesize.salon.'.$banner->getTable(), $this->site['pagesize']['common']);
        $base = boolval($request->input('base')) ?: false;

        //view's variant
        $this->_base = $base;
        $this->_pagesize = $pagesize;
        $this->_filters = $this->_getFilters($request, $builder);
        $this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
        return $this->view('salon-backend.banner.'. ($base ? 'list' : 'datatable'));
    }

    public function data(Request $request)
    {
        $banner = new Banner();
        $builder = $banner->newQuery()->with(['salons','navigations'])->where('mid', $this->salon->getKey());
        $_builder = clone $builder;$total = $_builder->count();unset($_builder);
        $data = $this->_getData($request, $builder);
        $data['recordsTotal'] = $total;
        $data['recordsFiltered'] = $data['total'];
        return $this->success('', FALSE, $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keys = 'title,url,cover,status,nid,porder';
        $this->_data = [];
        $this->_validates = $this->getScriptValidate('banner.store', $keys);
        return $this->view('salon-backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = 'title,url,cover,status,nid,porder';
        $data = $this->autoValidate($request, 'banner.store', $keys);
        if(Banner::where('mid',$this->salon->getKey())->where('nid',$data['nid'])->count()>config('site.banner_max_cnt')){
            return $this->failure('banner.max_banner_cnt',url('salon/banner'));
        }else{
           $data += ['mid' => $this->salon->getKey()];
           Banner::create($data);
           return $this->success('', url('salon/banner'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        if (empty($banner))
            return $this->failure_noexists();

        $keys = 'title,url,cover,status,nid,porder';
        $this->_validates = $this->getScriptValidate('banner.store', $keys);
        $this->_data = $banner;
        return $this->view('salon-backend.banner.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (empty($banner))
            return $this->failure_noexists();

        $keys = 'title,url,cover,status,nid,porder';
        $data = $this->autoValidate($request, 'banner.store', $keys, $banner);
        $banner->update($data);
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        empty($id) && !empty($request->input('id')) && $id = $request->input('id');
        $id = (array) $id;

        foreach ($id as $v)
            $banner = Banner::destroy($v);
        return $this->success('');
    }
}
