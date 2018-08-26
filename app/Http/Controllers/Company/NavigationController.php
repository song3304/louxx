<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\Navigation;
use Addons\Core\Controllers\AdminTrait;

class NavigationController extends BaseController
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$navigation = new Navigation;
		$builder = $navigation->newQuery()->with(['salons'])->where('mid', $this->salon->getKey());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.salon.'.$navigation->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('salon-backend.navigation.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$navigation = new Navigation;
		$builder = $navigation->newQuery()->with(['salons'])->where('mid', $this->salon->getKey());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder, function(&$v, $k){
			$v['products-count'] = $v->salon_products->count();
		});
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$navigation = new Navigation;
		$builder = $navigation->newQuery()->with('salons')->where('mid', $this->salon->getKey());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $navigation->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('salon-backend.navigation.export');
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
		$keys = 'name,porder';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('navigation.store', $keys);
		return $this->view('salon-backend.navigation.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,porder';
		$data = $this->autoValidate($request, 'navigation.store', $keys);
		if(Navigation::where('mid',$this->salon->getKey())->count()>config('site.navigation_max_cnt')){
		    return $this->failure('navigation.max_navigation_cnt',url('salon/banner'));
		}else{
		   $data += ['mid' => $this->salon->getKey()];
		   Navigation::create($data);
	   	   return $this->success('', url('salon/navigation'));
		}
	}

	public function edit($id)
	{
		$navigation = Navigation::find($id);
		if (empty($navigation))
			return $this->failure_noexists();

		$keys = 'name,porder';
		$this->_validates = $this->getScriptValidate('navigation.store', $keys);
		$this->_data = $navigation;
		return $this->view('salon-backend.navigation.edit');
	}

	public function update(Request $request, $id)
	{
		$navigation = Navigation::find($id);
		if (empty($navigation))
			return $this->failure_noexists();

		$keys = 'name,porder';
		$data = $this->autoValidate($request, 'navigation.store', $keys, $navigation);
		$navigation->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$navigation = Navigation::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
