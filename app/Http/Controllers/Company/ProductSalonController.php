<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Salon\BaseController;
use App\Product;
use Addons\Core\Controllers\AdminTrait;

class ProductSalonController extends BaseController
{
	use AdminTrait;
	//public $RESTful_permission = 'product';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->with(['covers'])->where('is_publish','=','1')->where('own_id','!=',$this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.salon-backend.'.$product->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.product-salon.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->with(['covers'])->where('is_publish','=','1')->where('own_id','!=',$this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder,function(&$v,$k){
		    $v['has_salon'] = intval($v->salons->contains($this->salon->getKey()));
		});
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->where('is_publish','=','1')->where('own_id','!=',$this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $product->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.product-salon.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}
	//添加
	public function edit($id)
	{
	    $product = Product::find($id);
		if (empty($product))
			return $this->failure_noexists();

		$product->salons()->attach($this->salon->getKey(),['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
		
		return $this->success('',url('salon/product-salon'));
	}
	//删除
	public function destroy(Request $request, $id)
	{
	    empty($id) && !empty($request->input('id')) && $id = $request->input('id');
	    $id = (array) $id;
	
	    foreach ($id as $v)
	        Product::find($v)->salons()->detach([$this->salon->getKey()]);
	    return $this->success('', count($id) > 5, compact('id'));
	}
}
