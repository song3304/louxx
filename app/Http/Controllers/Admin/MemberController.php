<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

class MemberController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.member-list', $this->site['pagesize']['common']);
		$this->_table_data = User::paginate($pagesize);

		return $this->view('admin.member.list');
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'username,password,nickname,realname,gender,email,phone,avatar_aid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		return $this->view('admin.member.create');
	}

	public function edit($id)
	{
		$user = User::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'username,nickname,realname,gender,email,phone,avatar_aid';
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
		$keys = 'nickname,realname,gender,email,phone,avatar_aid';
		$data = $this->autoValidate($request, 'member.store', $keys);
		$user->update($data);
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
