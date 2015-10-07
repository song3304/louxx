<?php

namespace App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Models\WechatAccount;
use Addons\Core\Models\WechatMessage;
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
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('admin.wechat.message.'. ($base ? 'list' : 'datatable'));
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

	public function create()
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		return $this->view('admin.wechat.message.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);

		WechatMessage::create($data);
		return $this->success('', url('admin/wechat-account'));
	}

	public function edit($id)
	{
		$message = WechatMessage::find($id);
		if (empty($message))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		$this->_data = $message;
		return $this->view('admin.wechat.message.edit');
	}

	public function update(Request $request, $id)
	{
		$message = WechatMessage::find($id);
		if (empty($message))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);
		$message->update($data);
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
