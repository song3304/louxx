<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Models\WechatAccount;
use Addons\Core\Models\WechatMessage;
use Addons\Core\Tools\Wechat\Send;
use Addons\Core\Controllers\AdminTrait;

class MessageController extends Controller
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$message = new WechatMessage;
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'video', 'voice', 'image', 'text']);
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$message->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $this->_getPaginate($request, $builder, ['*']);
		return $this->view('admin.wechat.message.list');
	}

	public function data(Request $request)
	{
		$message = new WechatMessage;
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'video', 'voice', 'image', 'text']);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $message->newQuery()->count();
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$message = new WechatMessage;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $message::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $message->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('admin.wechat.message.export');
		}

		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'video', 'voice', 'image', 'text']);
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function update(Request $request, $id)
	{
		$message = WechatMessage::find($id);
		if (empty($message))
			return $this->failure_noexists();

		$keys = 'type,content';
		$data = $this->autoValidate($request, 'wechat-message.store', $keys);
	
		//发送消息
		(new Send($message->account, $message->user))->add($data['content'])->send();
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$message = WechatMessage::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
