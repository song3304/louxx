<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\Order;
use App\OrderDetail;
use Addons\Core\Controllers\AdminTrait;
use App\OrderExpress;
use App\Store;
use App\UserAddress;
use App\User;

class ExpressController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$order = new Order;
		$builder = $order->newQuery()->with(['order_express'])->where('mid', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$order->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.express.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$order = new Order;
		$builder = $order->newQuery()->with(['order_express'])->where('mid', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		//dd($data);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function create(){}

	public function store(Request $request){}

	public function edit($id)
	{
		$order = Order::with(['order_express','details'])->where('mid', $this->salon->getKey())->find($id);
		if (empty($order))
			return $this->failure_noexists();
		if(!empty($order->order_express->uaid)){
		    $this->_user_address = UserAddress::find($order->order_express->uaid)->getFullAddressAttribute();
		    $keys = 'express_name,no';
		    $this->_validates = $this->getScriptValidate('order.deliver', $keys);
		}else{		    
		    $this->_user_stores = $order->salon()->get()->toArray();
		    $keys = 'mid';
		    $this->_validates = $this->getScriptValidate('order.express_salon', $keys);
		}
		$this->_data = $order;
		return $this->view('salon-backend.express.edit');
	}

	public function update(Request $request, $id)
	{
		$express = OrderExpress::find($id);
		if (empty($express))
			return $this->failure_noexists();

		if(!empty($express->uaid)){
		    $keys = 'express_name,no';
		    $table = "order.deliver";
		}else{
		    $keys = 'mid';
		    $table = "order.express_store";
		}
		$data = $this->autoValidate($request, $table, $keys, $express);
		$express->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
// 		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
// 		$id = (array) $id;
		
// 		foreach ($id as $v)
// 			$order = Order::destroy($v);
// 		return $this->success('', count($id) > 5, compact('id'));
	}
}

