<?php

namespace App\Http\Controllers\salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ProductAttr;
use Addons\Core\Controllers\AdminTrait;
use App\ProductAttrType;

class ProductAttrController extends Controller
{
    use AdminTrait;

    function __construct(){
        parent::__construct();
        $this->_tid = app('request')->get('tid');
        isset($this->_tid)&&session(['tid'=>$this->_tid]);
        !isset($this->_tid)&&$this->_tid = session('tid');
        $this->_attr_type= ProductAttrType::findOrFail($this->_tid);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $product_attr = new ProductAttr;
        $builder = $product_attr->newQuery()->with('attr_types')->where('tid',$this->_tid);
        $pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$product_attr->getTable(), $this->site['pagesize']['common']);
        $base = boolval($request->input('base')) ?: false;
        //view's variant
        $this->_base = $base;
        $this->_pagesize = $pagesize;
        $this->_filters = $this->_getFilters($request, $builder);
        $this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
        return $this->view('salon-backend.product-attr.'. ($base ? 'list' : 'datatable'));
    }


    public function data(Request $request)
    {
        $product_attr = new ProductAttr;
        $builder = $product_attr->newQuery()->with(['attr_types'])->where('tid', $this->_tid);
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
        $keys = 'name';
        $this->_data = [];
        $this->_validates = $this->getScriptValidate('product-attr.store', $keys);
        return $this->view('salon-backend.product-attr.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = 'name';
        $data = $this->autoValidate($request, 'product-attr.store', $keys);
        $data += ['tid' => $this->_tid];
        $product = ProductAttr::create($data);
        return $this->success('', url('salon/product-attr'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productAttr = ProductAttr::find($id);
        if (empty($productAttr))
            return $this->failure_noexists();

        $keys = 'name';
        $this->_validates = $this->getScriptValidate('product-attr.store', $keys);
        $this->_data = $productAttr;
        return $this->view('salon-backend.product-attr.edit');
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
        $productAttr = ProductAttr::find($id);
        if (empty($productAttr))
            return $this->failure_noexists();

        $keys = 'name';
        $data = $this->autoValidate($request, 'product-attr.store', $keys, $productAttr);
        $productAttr->update($data);
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
            $productAttr = ProductAttr::destroy($v);
        return $this->success('', count($id) > 5, compact('id'));
    }
}
