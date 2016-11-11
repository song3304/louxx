<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Addons\Core\Models\CacheTrait;
use Addons\Core\Models\CallTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Addons\Entrust\Traits\UserTrait;

use App\Role;

class User extends Authenticatable
{
	use HasApiTokens, SoftDeletes, Notifiable, UserTrait;
	use CacheTrait, CallTrait;

	protected $dates = ['lastlogin_at'];

	//不能批量赋值
	protected $guarded = ['id'];
	protected $hidden = ['password', 'remember_token', 'deleted_at'];

	public static function add($data, $role_name = NULL)
	{
		$data['password'] = empty($data['password']) ? '' : bcrypt($data['password']);
		$user = static::create($data);
		//加入view组
		!empty($role_name) && $user->attachRole($role_name instanceof Role ? $role_name : Role::findByName($role_name));
		return $user;
	}
	
	public function _gender()
	{
		return $this->hasOne('App\\Catalog', 'id', 'gender');
	}

	public function creator()
	{
		return $this->hasOne('App\\User', 'id', 'creator_uid');
	}

	public function finance()
	{
		return $this->hasOne('App\\UserFinance', 'id', 'id');
	}
}

//自动创建extra等数据
User::created(function($user){
	$user->finance()->create([]);
});
	