<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Queue;
use Illuminate\Support\Str;
use App\User;

use Addons\Wechat\Models\WechatMessage;
use Addons\Wechat\Jobs\WechatSend;
class HomeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$message = WechatMessage::find(67);
		(new WechatSend($message->account, $message->user, Attachment::find(55)))->handle();
		return $this->view('index');
	}

}
