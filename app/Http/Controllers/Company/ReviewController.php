<?php

namespace App\Http\Controllers\Salon;

use Addons\Core\Controllers\AdminTrait;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;
use App\Review;
use App\Product;
use App\SalonProduct;

class ReviewController extends BaseController
{

    use AdminTrait;
    //要评论的项目
    function __construct(){
        parent::__construct();
        if(app('request')->get('tag')){
            session(['pro_id'=>0]);
            $this->_pro_id = 0;
            $this->_product= false;
        }else{
            $this->_pro_id = app('request')->get('pro_id');
            isset($this->_pro_id)&&session(['pro_id'=>$this->_pro_id]);
            !isset($this->_pro_id)&&$this->_pro_id = session('pro_id');
            $this->_product= $this->_pro_id?SalonProduct::find($this->_pro_id):false;
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $review = new Review;
        $builder = $review->newQuery()->with(['products','users']);
        !empty($this->_pro_id) && $builder = $builder->where('product_id',$this->_pro_id);
        $pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$review->getTable(), $this->site['pagesize']['common']);
        $base = boolval($request->input('base')) ?: false;

        //view's variant
        $this->_base = $base;
        $this->_pagesize = $pagesize;
        $this->_filters = $this->_getFilters($request, $builder);
        $this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
        return $this->view('salon-backend.review.'. ($base ? 'list' : 'datatable'));
    }

    public function data(Request $request)
    {
        $review = new Review;
        $builder = $review->newQuery()->with(['products','users']);
        $product_ids = SalonProduct::where('mid',$this->salon->getKey())->get()->pluck('id')->toArray();
        if(!empty($this->_pro_id))
            $builder = $builder->where('product_id',$this->_pro_id);
        else 
            $builder = $builder->whereIn('product_id',$product_ids);
        
        if(!empty($request->input('filters.pid'))){
            $builder->where('pid',$request->input('filters.pid'));
        }else{
            $builder->where('pid',0);
        }
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
    public function create(Request $request)
    {
        $pid=intval($request->get('pid'));
        $review = Review::find($pid);
        if (empty($review))
            return $this->failure_noexists();
        $this->_data = ['pid'=>$pid,'pcontent'=>$review->content,'product_id'=>$review->product_id,'user_id'=>$review->user_id,'products'=>$review->products,'users'=>$review->users];
        $keys = 'product_id,user_id,content,pid';
        $this->_validates = $this->getScriptValidate('review.store', $keys);
        return $this->view('salon-backend.review.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = 'product_id,user_id,content,pid';
        $data = $this->autoValidate($request, 'review.store', $keys);

        $data['user_id'] = $this->user->getKey();
        $review = Review::create($data);
        $review->moveInner($data['pid']);
        return $this->success('', url('salon/review'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);
        if (empty($review))
            return $this->failure_noexists();

        $keys = 'product_id,user_id,content';
        $this->_validates = $this->getScriptValidate('review.store', $keys);

        $this->_data = $review;
        return $this->view('salon-backend.review.edit');
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
        $review = Review::find($id);
        if (empty($review))
            return $this->failure_noexists();

        $keys = 'product_id,user_id,content';
        $data = $this->autoValidate($request, 'review.store', $keys, $review);
        $review->update($data);

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
            $review = Review::destroy($v);
        return $this->success('', count($id) > 5, compact('id'));
    }
}
