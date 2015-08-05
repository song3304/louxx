<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Auth::logout();
		return $this->view('login');
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return Response
	 */
	public function authenticate_query(Request $request)
	{
		//$this->validate($request, [
        //    $this->loginUsername() => 'required', 'password' => 'required',
        //]);
		$username = $request->input('username');
		$password = $request->input('password');
		$remember = $request->input('remember');
		if (Auth::attempt(['username' => $username, 'password' => $password], $remember))
		{
			return 'ok';
		} else {
			return $this->failure('');
		}
	}

	public function create()
	{
		return redirect('member/create');
	}

}
