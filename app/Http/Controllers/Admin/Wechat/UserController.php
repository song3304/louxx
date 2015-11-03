<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Models\WechatUser;
use Addons\Core\Controllers\AdminTrait;

class UserController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-user';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = new WechatUser;
		$builder = $user->newQuery()->with('gender');
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$user->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('admin.wechat.user.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$user = new WechatUser;
		$builder = $user->newQuery()->with('gender');
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$user = new WechatUser;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $user::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $user->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('admin.wechat.user.export');
		}

		$builder = $user->newQuery()->with('gender');
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$this->_data = $user;
		return $this->view('admin.wechat.user.show');
	}

	public function create()
	{
		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-user.store', $keys);
		return $this->view('admin.wechat.user.create');
	}

	public function store(Request $request)
	{
		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$data = $this->autoValidate($request, 'wechat-user.store', $keys);

		WechatUser::create($data);
		return $this->success('', url('admin/wechat/user'));
	}

	public function edit($id)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$this->_validates = $this->getScriptValidate('wechat-user.store', $keys);
		$this->_data = $user;
		return $this->view('admin.wechat.user.edit');
	}

	public function update(Request $request, $id)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$data = $this->autoValidate($request, 'wechat-user.store', $keys);
		$user->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$user = WechatUser::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
