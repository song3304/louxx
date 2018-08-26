<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;
use Addons\Core\Controllers\AdminTrait;
use Carbon\Carbon;
use App\UserBankcard;

class BankcardController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bankcard= new UserBankcard;
		$builder = $bankcard->newQuery()->with(['users','bank_name'])->where('uid', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.salon-backend.'.$bankcard->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.bank-card.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$bankcard = new UserBankcard;
		$builder = $bankcard->newQuery()->with(['users','bank_name'])->where('uid', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$bankcard = new UserBankcard;
		$builder = $bankcard->newQuery()->with('bank_name')->where('uid', $this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $bankcard->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.bank-card.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'bank_type,cardholder,card_no,bank_branch';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('bankcard.store', $keys);
		return $this->view('salon-backend.bank-card.create');
	}

	public function store(Request $request)
	{
		$keys = 'bank_type,cardholder,card_no,bank_branch';
		$data = $this->autoValidate($request, 'bankcard.store', $keys);
		$data += ['uid' => $this->salon->getKey(),'used_at' => Carbon::now()];
		$bankcard = UserBankcard::create($data);
		return $this->success('', url('salon/bankcard'));
	}

	public function edit($id)
	{
		$bankcard = UserBankcard::find($id);
		if (empty($bankcard))
			return $this->failure_noexists();

		$keys = 'bank_type,cardholder,card_no,bank_branch';
		$this->_validates = $this->getScriptValidate('bankcard.store', $keys);
		$this->_data = $bankcard;
		return $this->view('salon-backend.bank-card.edit');
	}

	public function update(Request $request, $id)
	{
		$bankcard = UserBankcard::find($id);
		if (empty($bankcard))
			return $this->failure_noexists();

		$keys = 'bank_type,cardholder,card_no,bank_branch';
		$data = $this->autoValidate($request, 'bankcard.store', $keys, $bankcard);
		$data += ['used_at' => Carbon::now()];
		$bankcard->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v){
		   $bankcard = UserBankcard::destroy($v);
		}
		return $this->success('', count($id) > 5, compact('id'));
	}
}
