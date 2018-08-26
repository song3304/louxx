<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Salon\BaseController;
use App\Product;
use Addons\Core\Controllers\AdminTrait;
use App\SalonProduct;

class ProductController extends BaseController
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
		$builder = $product->newQuery()->join('salon_productss', 'salon_productss.pid', '=', 'products.id')->where('salon_productss.mid', '=', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.salon.'.$product->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.product.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->join('salon_products', 'salon_products.pid', '=', 'products.id')->where('salon_products.mid', '=', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
	
		$data = $this->_getData($request, $builder,function(&$v,$k){
		    $v['covers'] = Product::find($v['pid'])->covers()->get();
		});
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$product = new Product;
		$builder = $product->newQuery()->join('salon_products', 'salon_products.pid', '=', 'products.id')->where('salon_products.mid', '=', $this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $product->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.product.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'title,content,cover_aids,beautician_rate,big_rate,middle_rate,little_rate,express_price,market_price,price,count,keywords,description,talk_rate,times,instructions,pv_rate,nid,porder';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('product.store', $keys);
		$this->_is_choose = 0;
		return $this->view('salon-backend.product.create');
	}

	public function store(Request $request)
	{
		$keys = 'title,content,cover_aids,beautician_rate,big_rate,middle_rate,little_rate,express_price,market_price,price,count,keywords,description,talk_rate,times,instructions,pv_rate,nid,porder';
		$data = $this->autoValidate($request, 'product.store', $keys);
		$cover_aids = array_pull($data, 'cover_aids');
		$data += ['own_id' => $this->salon->getKey()];
		$nid = !empty($data['nid'])?$data['nid']:0;unset($data['nid']);
		$porder = !empty($data['porder'])?$data['porder']:0;unset($data['porder']);
		
		$product = Product::create($data);
		foreach ($cover_aids as $value)
			$product->covers()->create(['cover_aid' => $value]);
		$product->salons()->sync([$this->salon->getKey()=>['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'nid'=>intval($nid),'porder'=>intval($porder)]]);
			
		return $this->success('', url('salon/product'));
	}

	public function edit($id)
	{
		$product = Product::join('salon_products', 'salon_products.pid', '=', 'products.id')->where('salon_products.id',$id)->where('salon_products.mid', '=', $this->salon->getKey())->first();
		if (empty($product))
			return $this->failure_noexists();

		$keys = 'title,content,cover_aids,beautician_rate,big_rate,middle_rate,little_rate,express_price,market_price,price,count,keywords,description,talk_rate,times,instructions,pv_rate,nid,porder';
		$this->_validates = $this->getScriptValidate('product.store', $keys);
		$this->_data = $product;
		$this->_data['covers'] = Product::find($product['pid'])->covers()->get();
		$this->_is_choose = $product->own_id != $this->salon->getKey()?1:0;
		return $this->view('salon-backend.product.edit');
	}

	public function update(Request $request, $id)
	{
		$product = Product::join('salon_products', 'salon_products.pid', '=', 'products.id')->where('salon_products.id',$id)->where('salon_products.mid', '=', $this->salon->getKey())->first();
		if (empty($product))
			return $this->failure_noexists();
        if($product->own_id != $this->salon->getKey())
        {
            //return $this->failure('product.failure_edit');
            $keys = 'nid,porder';
            $data = $this->autoValidate($request, 'product.store', $keys, $product);
            $nid = !empty($data['nid'])?$data['nid']:0;
            $porder = !empty($data['porder'])?$data['porder']:0;
        }else{
    		$keys = 'title,content,cover_aids,beautician_rate,big_rate,middle_rate,little_rate,express_price,market_price,price,count,keywords,description,talk_rate,times,instructions,pv_rate,nid,porder';
    		$data = $this->autoValidate($request, 'product.store', $keys, $product);
    		$cover_aids = $data['cover_aids'];unset($data['cover_aids']);
    
    		$nid = !empty($data['nid'])?$data['nid']:0;unset($data['nid']);
    		$porder = !empty($data['porder'])?$data['porder']:0;unset($data['porder']);
    		
    		$product_item = Product::find($product->pid);
    		$product_item->update($data);
    		$product_item->covers()->delete();
    		foreach ($cover_aids as $value)
    			$product_item->covers()->create(['cover_aid' => $value]);
        }
        SalonProduct::where('mid',$this->salon->getKey())->where('pid',$product->pid)->update(['nid'=>intval($nid),'porder'=>intval($porder)]);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v){
	        $product = Product::join('salon_products', 'salon_products.pid', '=', 'products.id')->where('salon_products.id',$id)->where('salon_products.mid', '=', $this->salon->getKey())->first();
	        $product_item = Product::find($product->pid);
		    if($product->own_id == $product->mid){
		        $product_item->salons()->detach($product->mid);
			    Product::destroy($product->pid);
		    }else{
		        $product_item->salons()->detach($product->mid);
		    }
		}
		return $this->success('', count($id) > 5, compact('id'));
	}
}
