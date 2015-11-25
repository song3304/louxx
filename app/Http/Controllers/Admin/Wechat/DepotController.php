<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Models\WechatAccount;
use Addons\Core\Models\WechatDepot;
use Addons\Core\Controllers\AdminTrait;

class DepotController extends Controller
{
	use AdminTrait;
	//public $RESTful_permission = 'wechat-depot';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	private $types = ['news','text','image','callback','video','voice','music'];

	public function index(Request $request)
	{
		return $this->view('admin.wechat.depot.list');
	}

	public function data(Request $request)
	{
		$type = $request->input('type') ?: 'news';
		$account = new WechatDepot;
		$builder = $account->newQuery()->with($type);
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$account = new WechatAccount;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $account::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $account->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('admin.wechat.account.export');
		}

		$builder = $account->newQuery();
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		return $this->view('admin.wechat.account.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);

		WechatAccount::create($data);
		return $this->success('', url('admin/wechat-account'));
	}

	public function edit($id)
	{
		$account = WechatAccount::find($id);
		if (empty($account))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		$this->_data = $account;
		return $this->view('admin.wechat.account.edit');
	}

	public function update(Request $request, $id)
	{
		$account = WechatAccount::find($id);
		if (empty($account))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);
		$account->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		//foreach ($id as $v)
		//	$account = WechatDepot::destroy($v);
		return $this->success('', FALSE);
	}
}
