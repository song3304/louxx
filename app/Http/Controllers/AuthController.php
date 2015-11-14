<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//trait
use Addons\Core\Controllers\ThrottlesLogins;

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
		$keys = [$this->loginUsername(), 'password'];
		$validates = $this->getScriptValidate('member.store', $keys);
		
		$this->_validates = $validates;
		return $this->view('login');
	}

	public function logout()
	{
		Auth::logout();
		return $this->success_logout(''); // redirect to homepage
	}

	public function choose()
	{
		$user = Auth::user();
		$this->_roles = $user->roles()->whereIn('roles.name',['admin','manager','owner','leader'])->get();
		return $this->_roles->count() == 1 ? redirect($this->_roles[0]->url) : $this->view('auth.choose');
	}

	/**
	 * Handle an authentication attempt.
	 *
	 * @return Response
	 */
	public function authenticateQuery(Request $request)
	{
		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		$throttles = $this->isUsingThrottlesLoginsTrait();

		if ($throttles && $this->hasTooManyLoginAttempts($request)) 
			return $this->sendLockoutResponse($request);

		$keys = [$this->loginUsername(),'password'];
		$data = $this->autoValidate($request, 'member.login', $keys);
		$remember = $request->has('remember');
		if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $remember))
		{
			$user = Auth::user();
			$roles = $user->roles()->whereIn('roles.name',['admin','manager','owner','leader'])->get();
			return $this->success_login($roles->count() >= 1 ? 'auth/choose' :$request->session()->pull('url.intended', '')); // redirect to the prevpage or homepage
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
