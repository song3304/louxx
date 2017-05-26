<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Addons\Core\Controllers\ApiTrait;
use App\Article;

class ArticleController extends Controller
{
	use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
   public function index(Request $request)
    {
        $article = new Article();
        $pagesize = $request->input('pagesize') ?: config('size.models.'.$article->getTable(),config('size.common'));
    
        //view's variant
        $this->_pagesize = $pagesize;
        $this->_filters = $this->_getFilters($request);
        $this->_queries = $this->_getQueries($request);
        return $this->view('admin.article.list');
    }
    
    public function data(Request $request)
    {
        $article = new Article();
        $builder = $article->newQuery();
    
        $total = $this->_getCount($request, $builder, FALSE);
        $data = $this->_getData($request, $builder, function(&$datalist){
		    foreach ($datalist as &$value){
		         $value['content'] = mb_substr(strip_tags($value->contents),0,40);
		    }
		});
        $data['recordsTotal'] = $total; //不带 f q 条件的总数
        $data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
        return $this->api($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keys = 'title,pic_id,contents';
		$this->_data = ['type'=>0];
        $this->_validates = $this->getScriptValidate('article.store', $keys);
        return $this->view('admin.article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $keys = 'title,pic_id,contents';
        $data = $this->autoValidate($request, 'article.store', $keys);
        Article::create($data);
        return $this->success('', url('admin/article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if (empty($article))
            return $this->failure_noexists();

        $keys = 'title,pic_id,contents';
        $this->_validates = $this->getScriptValidate('article.store', $keys);
        $this->_data = $article;
        return $this->view('admin.article.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        if (empty($article))
            return $this->failure_noexists();

        $keys = 'title,pic_id,contents';
        $data = $this->autoValidate($request, 'article.store', $keys, $article);
        $article->update($data);
        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        empty($id) && !empty($request->input('id')) && $id = $request->input('id');
        $id = (array) $id;

        foreach ($id as $v)
            $article = Article::destroy($v);
        return $this->success('');
    }
}
