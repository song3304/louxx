<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Models\WechatAccount;
use Addons\Core\Models\WechatMenu;
use Addons\Core\Controllers\AdminTrait;
use Addons\Core\Tools\Wechat\Account;

class MenuController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-menu';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$account = new WechatAccount;
		$builder = $account->newQuery()->where('waid', $account->getAccountID());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$account->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('admin.wechat.account.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request, Account $account)
	{
		$account = new WechatAccount;
		$builder = $account->newQuery()->where('waid', $account->getAccountID());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request, Account $account)
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

		$builder = $account->newQuery()->where('waid', $account->getAccountID());
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

	public function store(Request $request, Account $account)
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);

		WechatAccount::create($data + ['waid' => $account->getAccountID()]);
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
		
		foreach ($id as $v)
			$account = WechatAccount::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
