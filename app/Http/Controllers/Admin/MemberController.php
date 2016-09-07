<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Addons\Core\Controllers\AdminTrait;

class MemberController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'member';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$user = new User;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$user->getTable(), $this->site['pagesize']['common']);
		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request);
		return $this->view('admin.member.datatable');
	}

	public function data(Request $request)
	{
		$user = new User;
		$builder = $user->newQuery()->with(['_gender', 'roles']);
		$request->input('filters.role_id') && $builder->join('role_user', 'role_user.user_id', '=', 'users.id', 'LEFT');
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, null, ['users.*']);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$user = new User;
		$builder = $user->newQuery()->with(['_gender', 'roles'])->join('role_user', 'role_user.user_id', '=', 'users.id', 'LEFT');
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $user->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('admin.member.export');
		}

		$data = $this->_getExport($request, $builder, function(&$v){
			$v['_gender'] = !empty($v['_gender']) ? $v['_gender']['title'] : NULL;
		}, ['users.*']);
		return $this->api($data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'username,password,nickname,realname,gender,email,phone,idcard,avatar_aid,role_ids';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		return $this->view('admin.member.create');
	}

	public function store(Request $request)
	{
		$keys = 'username,password,nickname,realname,gender,email,phone,idcard,avatar_aid,role_ids';
		$data = $this->autoValidate($request, 'member.store', $keys);

		$role_ids = array_pull($data, 'role_ids');
		$user = (new User)->add($data);
		$user->roles()->sync($role_ids);
		return $this->success('', url('admin/member'));
	}

	public function edit($id)
	{
		$user = User::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'username,nickname,realname,gender,email,phone,idcard,avatar_aid,role_ids';
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		$this->_data = $user;
		return $this->view('admin.member.edit');
	}

	public function update(Request $request, $id)
	{
		$user = User::find($id);
		if (empty($user))
			return $this->failure_noexists();

		//modify the password
		if (!empty($request->input('password')))
		{
			$data = $this->autoValidate($request, 'member.store', 'password');
			$data['password'] = bcrypt($data['password']);
			$user->update($data);
		}
		$keys = 'nickname,realname,gender,email,phone,idcard,avatar_aid,role_ids';
		$data = $this->autoValidate($request, 'member.store', $keys, $user);
		$role_ids = array_pull($data, 'role_ids');
		$user->update($data);
		$user->roles()->sync($role_ids);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$user = User::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
