<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;

class MemberController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$keys = 'username,password,accept_license';
		$validates = $this->getScriptValidate('member.store', $keys);
		
		$this->_validates = $validates;
		return $this->view('member.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$keys = 'username,password,accept_license';
		$data = $this->autoValidate($request, 'member.store', $keys);

		$data['password'] = bcrypt($data['password']);unset($data['accept_license']);
		$user = User::create($data);
		//加入view组
		$user->attachRole($this->roles[Role::VIEWER]['id']);
		return $this->success(NULL, 'member', $user->toArray());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

}
