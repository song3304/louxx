<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Addons\Core\Controllers\ApiTrait;
use DB;

class CompanyController extends Controller
{
	use ApiTrait;
	//public $permissions = ['company'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$company = new Company;
		$size = $request->input('size') ?: config('size.models.'.$company->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.company.list');
	}

	public function data(Request $request)
	{
		$company = new Company;
		$builder = $company->newQuery()->with(['building','floors','tags']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     $value['people_scale'] = $value->people_scale();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$company = new Company;
		$builder = $company->newQuery()->with(['building','floors','tags']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     
		    }
		}, ['companys.*']);
		return $this->export($data);
	}

	public function show(Request $request,$id)
	{
		$company = Company::with(['building','floors','tags'])->find($id);
		if (empty($company))
			return $this->failure_noexists();

		$this->_data = $company;
		return !$request->offsetExists('of') ? $this->view('admin.company.show') : $this->api($company->toArray());
	}

	public function create()
	{
		$keys = 'oid,name,description,logo_id,people_cnt,tag_ids,fids';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('company.store', $keys);
		return $this->view('admin.company.create');
	}

	public function store(Request $request)
	{
		$keys = 'oid,name,description,logo_id,people_cnt,tag_ids,fids';
		$data = $this->autoValidate($request, 'company.store', $keys);

		$fids = array_pull($data, 'fids');
		$tag_ids = array_pull($data, 'tag_ids');
		
		DB::transaction(function() use ($data,$fids,$tag_ids){
		    $company = Company::create($data);
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $company->tags()->attach($attach_data);
		    
		    $company->floors()->attach($fids);
		});
		
		return $this->success('', url('admin/company'));
	}

	public function edit($id)
	{
		$company = Company::with(['building','floors','tags'])->find($id);
		if (empty($company))
			return $this->failure_noexists();

		$keys = 'oid,name,description,logo_id,people_cnt,tag_ids,fids';
		$this->_validates = $this->getScriptValidate('company.store', $keys);
		$this->_data = $company;
		//dd($company);
		return $this->view('admin.company.edit');
	}

	public function update(Request $request, $id)
	{
		$company = Company::find($id);
		if (empty($company))
			return $this->failure_noexists();

		$keys = 'oid,name,description,logo_id,people_cnt,tag_ids,fids';
		$data = $this->autoValidate($request, 'company.store', $keys, $company);
		
		$fids = array_pull($data, 'fids');
		$tag_ids = array_pull($data, 'tag_ids');
		
		DB::transaction(function() use ($company,$data,$fids,$tag_ids){
		    $company->update($data);
		    $attach_data = [];
		    array_walk($tag_ids, function($value,$key) use(&$attach_data,$data){
		        $attach_data[$value]=['created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s"),'porder'=>$key];
		    });
		    $company->tags()->sync($attach_data);
		
		    $company->floors()->sync($fids);
		});

		return $this->success('', url('admin/company/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$company = Company::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
