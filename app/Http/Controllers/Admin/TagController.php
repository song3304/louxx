<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tag;
use Addons\Core\Controllers\ApiTrait;
use DB;

class TagController extends Controller
{
	use ApiTrait;
	//public $permissions = ['tag'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$tag = new Tag;
		$size = $request->input('size') ?: config('size.models.'.$tag->getTable(), config('size.common'));
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('admin.tag.list');
	}

	public function data(Request $request)
	{
		$tag = new Tag;
		$builder = $tag->newQuery()->with(['buildings','companies']);

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['type_name'] = $value->type_name();
    		     $value['building_cnt'] = $value->buildings->count();
    		     $value['company_cnt'] = $value->companies->count();
		    }
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$tag = new Tag;
		$builder = $tag->newQuery()->with(['buildings','companies']);
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder,function(&$datalist){
		    foreach ($datalist as &$value){
    		     
		    }
		}, ['*']);
		return $this->_export($data);
	}

	public function show(Request $request,$id)
	{
		$tag = Tag::with(['buildings','companies'])->find($id);
		if (empty($tag))
			return $this->failure_noexists();

		$this->_data = $tag;
		return !$request->offsetExists('of') ? $this->view('admin.tag.show') : $this->api($office_tag->toArray());
	}

	public function create()
	{
		$keys = 'type,tag_name';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('tag.store', $keys);
		return $this->view('admin.tag.create');
	}

	public function store(Request $request)
	{
		$keys = 'type,tag_name';
		$data = $this->autoValidate($request, 'tag.store', $keys);

		$tag = Tag::create($data);
		return $this->success('', url('admin/tag'));
	}

	public function edit($id)
	{
		$tag = Tag::find($id);
		if (empty($tag))
			return $this->failure_noexists();

		$keys = 'type,tag_name';
		$this->_validates = $this->getScriptValidate('tag.store', $keys);
		$this->_data = $tag;
		return $this->view('admin.tag.edit');
	}

	public function update(Request $request, $id)
	{
		$tag = Tag::find($id);
		if (empty($tag))
			return $this->failure_noexists();

		$keys = 'type,tag_name';
		$data = $this->autoValidate($request, 'tag.store', $keys, $tag);
		$tag->update($data);

		return $this->success('', url('admin/tag/'.$id.'/edit'));
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$tag = Tag::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
