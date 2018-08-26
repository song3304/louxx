<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\User;
use Addons\Core\Controllers\AdminTrait;

class MemberController extends BaseController
{
	use AdminTrait;
	private $_bids = [];
	public function __construct()
	{
	    parent::__construct();
	    $this->_bids = $this->salon->beautician_ids();
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
	    $user = new User;
	    $builder = $user->newQuery()->with(['_gender', 'roles'])->join('role_user', 'role_user.user_id', '=', 'users.id', 'LEFT')->groupBy('users.id');
	    if(empty($request->input('filters')))
		    $builder = $builder->whereIn('users.pid',$this->_bids);
		
	    $pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$user->getTable(), $this->site['pagesize']['common']);
	    $base = boolval($request->input('base')) ?: false;
	    
	    //view's variant
	    $this->_base = $base;
	    $this->_pagesize = $pagesize;
	    $this->_filters = $this->_getFilters($request, $builder);
	    $this->_table_data = $base ? $this->_getPaginate($request, $builder, ['users.*','role_user.role_id'], ['base' => $base]) : [];
	    return $this->view('salon-backend.member.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$user = new User;
		$builder = $user->newQuery()->with(['_gender'])->join('role_user', 'role_user.user_id', '=', 'users.id')->groupBy('users.id');
		if(empty($request->input('filters')))
		    $builder = $builder->whereIn('users.pid',$this->_bids);
		else{
            $sql = [];
    		if(!empty($this->_bids)){
        		foreach($this->_bids as $bid)
        		   $sql[] = " users.path like '%/".$bid."/%' ";
    		}
    		$sql[] = " users.path like '%/".$this->salon->id."/%' ";
    		$builder = $builder->WhereRaw('('.implode('or',$sql).')');
		}
		$_builder = clone $builder;$total = $_builder->get()->count();unset($_builder);
		$data = $this->_getData($request, $builder, function(&$v, $k){},['users.*','role_user.role_id']);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}
	
	public function export(Request $request)
	{
	    $user = new User;
	    $builder = $user->newQuery()->with(['_gender', 'roles', 'finance'])->join('role_user', 'role_user.user_id', '=', 'users.id', 'LEFT')->whereIn('users.pid',$this->_bids)->groupBy('users.id');
	    $page = $request->input('page') ?: 0;
	    $pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
	    $total = $this->_getCount($request, $builder);
	
	    if (empty($page)){
	        $this->_of = $request->input('of');
	        $this->_table = $user->getTable();
	        $this->_total = $total;
	        $this->_pagesize = $pagesize > $total ? $total : $pagesize;
	        return $this->view('salon-backend.member.export');
	    }
	
	    $data = $this->_getExport($request, $builder, function(&$v){
	      	$v['gender'] = !empty($v['_gender']) ? $v['_gender']['title'] : NULL;unset($v['_gender']);
			$v['role_name'] = !empty($v['roles'])&&($v['roles']->count()>0)?implode(' ',$v['roles']->pluck('display_name')->toArray()):'';unset($v['roles']);
			$v['finance_money'] = !empty($v['finance']) ? $v['finance']['money'] : NULL;unset($v['finance']);
			unset($v['avatar_aid']);unset($v['pid']);unset($v['order']);unset($v['level']);unset($v['path']);unset($v['skin']);
			unset($v['status']);unset($v['birthday']);
		}, ['users.*']);
	    return $this->success('', FALSE, $data);
	}
	
	public function show($id)
	{
	    return '';
	}
	
// 	public function create()
// 	{
// 	    $keys = 'username,password,nickname,realname,gender,email,phone,idcard,avatar_aid,role_ids';
// 	    $this->_data = [];
// 	    $this->_validates = $this->getScriptValidate('member.store', $keys);
// 	    return $this->view('admin.member.create');
// 	}
	
	public function store(Request $request)
	{
	    $keys = 'username,password,nickname,realname,gender,email,phone,idcard,avatar_aid';
	    $data = $this->autoValidate($request, 'member.store', $keys);
	
	    $user = (new User)->add($data);
	    return $this->success('', url('salon/member'));
	}
	
	public function edit($id)
	{
	    $user = User::find($id);
	    if (empty($user))
	        return $this->failure_noexists();
	
	    $keys = 'username,nickname,realname,gender,email,phone,idcard,avatar_aid';
	    $this->_validates = $this->getScriptValidate('member.store', $keys);
	    $this->_data = $user;
	    return $this->view('salon-backend.member.edit');
	}
	
	public function update(Request $request, $id)
	{
	    $user = User::find($id);
	    if (empty($user))
	        return $this->failure_noexists();
	
	    //modify the password
	    if (!empty($request->input('password')))
	    {
	        $data = $this->autoValidate($request, 'member.store', 'password');
	        $data['password'] = bcrypt($data['password']);
	        $user->update($data);
	    }
	    $keys = 'nickname,realname,gender,email,phone,idcard,avatar_aid';
	    $data = $this->autoValidate($request, 'member.store', $keys, $user);
	    $user->update($data);
	    return $this->success();
	}
	
	public function destroy(Request $request, $id)
	{
	    empty($id) && !empty($request->input('id')) && $id = $request->input('id');
	    $id = (array) $id;
	
	    foreach ($id as $v)
	        $user = User::destroy($v);
	    return $this->success('', count($id) > 5, compact('id'));
	}
}
