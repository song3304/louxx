<?php

namespace App\Http\Controllers\Salon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\Order;
use App\OrderDetail;
use Addons\Core\Controllers\AdminTrait;
use App\OrderExpress;
use App\UserAddress;
use App\BeautySalon;
use App\User;
use App\Beautician;

class OrderController extends BaseController
{
	use AdminTrait;
	//public $RESTful_permission = 'order';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$order = new Order;
		$builder = $order->newQuery()->with(['details','bills','order_express'])->where('mid', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$order->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.order.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$order = new Order;
		$builder = $order->newQuery()->with(['details','bills','order_express'])->where('mid', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder,function(&$v,$k){
			$products = $v->toArray()['details'];
			$name = [];
			foreach($products as $p) {
				$pro_title = $p['product']['title'];
				$count = $p['count'];
				$name[] = $pro_title . 'X' . $count;
			}
			$v->name = implode('<br/>',$name);
			
			//美容院
			$v->salon_name = BeautySalon::find($v->mid)->name;
			//美容师//推荐人
			$root_user = User::find($v->uid)->getRoot();
			$big_user = User::find($v->uid)->getParent();
			$v->recommender = $root_user->hasRole('beautician')?Beautician::find($root_user->getKey())->name.'(美)':$big_user->nickname.'(荐)';
		});
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$order = new Order;
		$builder = $order->newQuery()->with('details')->where('mid', $this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $order->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.order.export');
		}

		$data = $this->_getExport($request, $builder, function(&$v){
			$products = $v->toArray()['details'];
			$name = [];
			foreach($products as $p) {
				$pro_title = $p['product']['title'];
				$count = $p['count'];
				$name[] = $pro_title . 'X' . $count;
			}
			$v->name = implode('<br/>',$name);
			
			//美容院
			$v->salon_name = BeautySalon::find($v->mid)->name;
			//美容师//推荐人
			$big_user = User::find($v->uid)->getParent();
			$v->recommender = $big_user->hasRole('beautician')?Beautician::find($big_user->getKey())->name.'(美)':$big_user->nickname.'(荐)';
			$v->buyer = $v->users->nickname;
			$v->status = $v->order_status();
			unset($v['users']);unset($v['details']);
		}, ['orders.*']);
		return $this->success('', FALSE, $data);
	}
    //订单查看
	public function show($id)
	{
		return '';
	}
    //取消
    public function cancel($id)
    {
        $order = Order::find($id);
        if($order->count()<1) return $this->failure_noexists();
        if($order->canceled())
            return $this->success('', url('salon/order'));
    }
    //发货显示
    public function deliver($id)
    {
        $order = Order::with(['details','order_express'])->where('mid', $this->salon->getKey())->find($id);
        $this->_data = $order;
        if($order->order_express->uaid){
            $this->_user_address = UserAddress::find($order->order_express->uaid)->getFullAddressAttribute();
        }else{
            $this->_user_store = BeautySalon::find($order->order_express->mid);
        }
        if($order->order_express->uaid){
            $keys = 'express_name,no';
            $this->_validates = $this->getScriptValidate('order.deliver', $keys);
        }
        return $this->view('salon-backend.order.deliver');
    }

    //保存发货
    public function save_deliver($id,Request $request)
    {
        $order = Order::with('order_express')->find($id);
        if(empty($order)) return $this->failure_noexists();
        $data = ['express_name'=>'','no'=>''];
        if($order->order_express->uaid){
            $keys = 'express_name,no';
            $data = $this->autoValidate($request, 'order.deliver', $keys, $order);
        }
        $order->express($data['express_name'],$data['no']);
        $this->dispatch((new \App\Jobs\OrderDeal($order))->delay($this->site['order']['deal']));
        return $this->success('', url('salon/order'));
    }
	public function create(){}

	public function store(Request $request){}

	public function edit($id)
	{
		$order = Order::with(['details','order_express'])->where('mid', $this->salon->getKey())->find($id);
		if (empty($order))
			return $this->failure_noexists();

        if(!empty($order->order_express->uaid)){
            $this->_express_address = UserAddress::find($order->order_express->uaid)->getFullAddressAttribute();
        }else{
            $user_salons = BeautySalon::with('user')->find($order->order_express->mid);
            $this->_express_address = $user_salons->name.'-店主:'.$user_salons->user->realname.'-电话:'.$user_salons->phone.'-地址:'.($user_salons->address)?:'无';
        }
		$keys = 'expresses_money';
		$this->_validates = $this->getScriptValidate('order.express', $keys);
		$this->_data = $order;
		return $this->view('salon-backend.order.edit');
	}
    //线下支付
	public function pay($id){
	    $order = Order::where('mid', $this->salon->getKey())->find($id);
	    if(empty($order)) return $this->failure_noexists();
	    $order->pay($order->total_money * 100,true,false);
	    return $this->success('salon.pay_success', url('salon/order'));
	}
	
	public function update(Request $request, $id)
	{
		$order = Order::find($id);
		if (empty($order))
			return $this->failure_noexists();

		$keys = 'expresses_money';
		$data = $this->autoValidate($request, 'order.express', $keys, $order);
		$order->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$order = Order::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}

