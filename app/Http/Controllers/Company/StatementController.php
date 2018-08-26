<?php

namespace App\Http\Controllers\Salon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\Order;
use Addons\Core\Controllers\AdminTrait;
use App\Bill;

class StatementController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bill = new Bill;
		$builder = $bill->newQuery()->where('uid', $this->salon->getKey())->where('is_dealt',1);
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$bill->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.statement.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$bill = new Bill;
		$builder = $bill->newQuery()->where('uid', $this->salon->getKey())->where('is_dealt',1);
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$bill = new Bill;
		$builder = $bill->newQuery();
		$page = $bill->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $bill->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.statement.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}
}

