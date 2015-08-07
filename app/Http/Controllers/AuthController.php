<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//trait
use Addons\Core\Controller\ThrottlesLogins;

class AuthController extends Controller
{

	use ThrottlesLogins;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->login();
	}

	public function login()
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
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();

		if ($throttles && $this->hasTooManyLoginAttempts($request)) 
			return $this->sendLockoutResponse($request);


		$data = $this->tipsValidate($request, 'member.login', [$this->loginUsername(),'password']);
		$remember = $request->has('remember');
		if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $remember))
		{
			return $this->success_login('');
		} else {
			//记录重试次数
			$throttles && $this->incrementLoginAttempts($request);
			return $this->failure_login();
		}
	}

	public function create()
	{
		return redirect('member/create');
	}

	private function loginUsername()
	{
		return 'username';
	}

	/**
	 * Redirect the user after determining they are locked out.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendLockoutResponse(Request $request)
	{
		$seconds = (int) Cache::get($this->getLoginLockExpirationKey($request)) - time();

		return $this->failure(['content' => $this->getLockoutErrorMessage($seconds)], FALSE, compact('seconds'));
	}

	/**
	 * Determine if the class is using the ThrottlesLogins trait.
	 *
	 * @return bool
	 */
	protected function isUsingThrottlesLoginsTrait()
	{
		return in_array(
			ThrottlesLogins::class, class_uses_recursive(get_class($this))
		);
	}
}
