<?php

namespace App\Http\Controllers\salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use Addons\Core\Controllers\AdminTrait;
use App\ProductAttrType;
use Illuminate\Support\MessageBag;

class ProductAttrTypeController extends Controller
{

    use AdminTrait;
    function __construct(){
        parent::__construct();
        $this->_pid = app('request')->get('pid');
        if(!empty($this->_pid)){
            session(['pid'=>$this->_pid]);
            $this->_product = Product::findOrFail($this->_pid);
        }else{
            $this->_pid = session('pid');
            $this->_product = Product::findOrFail($this->_pid);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productAttrType = new ProductAttrType;
        $builder = $productAttrType->newQuery()->with(['attrs'])->where('pid',$this->_pid);
        $pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$productAttrType->getTable(), $this->site['pagesize']['common']);
        $base = boolval($request->input('base')) ?: false;

        //view's variant
        $this->_base = $base;
        $this->_pagesize = $pagesize;
        $this->_filters = $this->_getFilters($request, $builder);
        $this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
        return $this->view('salon-backend.product-attr-type.'. ($base ? 'list' : 'datatable'));
    }

    public function data(Request $request)
    {
        $productAttrType = new ProductAttrType;
        $builder = $productAttrType->newQuery()->with(['attrs'])->where('pid',$this->_pid);
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
        $this->_validates = $this->getScriptValidate('product-attr-type.store', $keys);
        return $this->view('salon-backend.product-attr-type.create');
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
        $data = $this->autoValidate($request, 'product-attr-type.store', $keys);
        $data += ['pid' => $this->_product->id];
        if($this->validProductUnique($this->_pid, $data['name']))
        {
            ProductAttrType::create($data);
            return $this->success('', url('salon/product-attr-type'));
        }else{
            return $this->failure_validate(new MessageBag(array('size_type'=>'同一件商品同一属性规格已存在')));
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
        $productAttrType = ProductAttrType::find($id);
        if (empty($productAttrType))
            return $this->failure_noexists();

        $keys = 'name';
        $this->_validates = $this->getScriptValidate('product-attr-type.store', $keys);
        $this->_data = $productAttrType;
        return $this->view('salon-backend.product-attr-type.edit');
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
        $productAttrType = ProductAttrType::find($id);
        if (empty($productAttrType))
            return $this->failure_noexists();

        $keys = 'name';
        $data = $this->autoValidate($request, 'product-attr-type.store', $keys, $productAttrType);
        if($this->validProductUnique($this->_pid, $data['name'],$id))
        {
            $productAttrType->update($data);
            return $this->success();
        }else{
            return $this->failure_validate(new MessageBag(array('size_type'=>'同一件商品同一属性规格已存在')));
        }
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
            $productAttrType = ProductAttrType::destroy($v);
        return $this->success('', count($id) > 5, compact('id'));
    }

    private function validProductUnique($pid,$name,$main_id=''){
        $productAttrType = new ProductAttrType;
        $builder = $productAttrType->newQuery()->where('pid','=',$pid)->where('name','=',$name);
        if(!empty($main_id)) $builder->where('id','!=',$main_id);
        return $builder->count()?false:true;
    }
}
