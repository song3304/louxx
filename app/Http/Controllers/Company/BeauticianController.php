<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Salon\BaseController;
use App\Beautician;
use Addons\Core\Controllers\AdminTrait;
use DB;
class BeauticianController extends BaseController
{
	use AdminTrait;
	//public $RESTful_permission = 'beautician';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$beautician = new Beautician;
		$builder = $beautician->newQuery()->with(['user','salons'])->join('salon_beautician', 'salon_beautician.bid', '=', 'beauticians.id')->where('salon_beautician.mid', '=', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.salon.'.$beautician->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['beauticians.*', DB::raw('COUNT(`salon_beautician`.`mid`) as `salons-count`')], ['base' => $base]) : [];
		return $this->view('salon-backend.beautician.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$beautician = new Beautician;
		$builder = $beautician->newQuery()->with(['user','salons'])->join('salon_beautician', 'salon_beautician.bid', '=', 'beauticians.id')->where('salon_beautician.mid', '=', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);

		$data = $this->_getData($request, $builder, function(&$v, $k){},['beauticians.*','salon_beautician.mid','salon_beautician.bid']);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$beautician = new Beautician;
		$builder = $beautician->newQuery()->join('salon_beautician', 'salon_beautician.bid', '=', 'beauticians.id')->where('mid', '=', $this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $beautician->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.beautician.export');
		}

		$data = $this->_getExport($request, $builder, null, ['beauticians.*', 'COUNT(salon_beautician.mid) as salons-count']);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'id,name,address,phone,uv_rate';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('beautician.store', $keys);
		return $this->view('salon-backend.beautician.create');
	}

	public function store(Request $request)
	{
		$keys = 'id,name,address,phone,uv_rate';
		$data = $this->autoValidate($request, 'beautician.store', $keys);
		
		$beautician = Beautician::create($data);
		$beautician->salons()->sync((array)$this->salon->getKey());

		return $this->success('', url('salon/beautician'));
	}

	public function edit($id)
	{
		$beautician = Beautician::find($id);
		if (empty($beautician))
			return $this->failure_noexists();

		$keys = 'name,address,phone,uv_rate';
		$this->_validates = $this->getScriptValidate('beautician.store', $keys);
		$this->_data = $beautician;
		return $this->view('salon-backend.beautician.edit');
	}

	public function update(Request $request, $id)
	{
		$beautician = Beautician::find($id);
		if (empty($beautician))
			return $this->failure_noexists();

		$keys = 'name,address,phone,uv_rate';
		$data = $this->autoValidate($request, 'beautician.store', $keys, $beautician);

		$beautician->update($data);
		
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$beautician = Beautician::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
