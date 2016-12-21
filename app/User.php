<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Addons\Core\Models\CacheTrait;
use Addons\Core\Models\CallTrait;
use Addons\Core\Models\PolyfillTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Addons\Entrust\Traits\UserTrait;

use App\Role;
use App\CatalogCastTrait;
use App\LogTrait;
use Laravel\Scout\Searchable;
class User extends Authenticatable
{
	use HasApiTokens, SoftDeletes, Notifiable, UserTrait;
	use CacheTrait, CallTrait, PolyfillTrait;
	use CatalogCastTrait;
	use Searchable;
	use LogTrait;
	protected $dates = ['lastlogin_at'];

	//不能批量赋值
	protected $guarded = ['id'];
	protected $hidden = ['password', 'remember_token', 'deleted_at'];
	protected $casts = [
		'gender' => 'catalog',
	];

	public static function add($data, $role_name = NULL)
	{
		$data['password'] = empty($data['password']) ? '' : bcrypt($data['password']);
		$user = static::create($data);
		//加入view组
		!empty($role_name) && $user->attachRole($role_name instanceof Role ? $role_name : Role::findByName($role_name));
		return $user;
	}

	public function creator()
	{
		return $this->hasOne('App\\User', 'id', 'creator_uid');
	}

	public function finance()
	{
		return $this->hasOne('App\\UserFinance', 'id', 'id');
	}

	public function scopeOfRole(Builder $builder, $roleIdOrName)
	{
		$role = Role::findByCache($roleIdOrName);
		empty($role) && $role = Role::findByName($roleIdOrName);

		$builder->join('role_user', 'role_user.user_id', '=', 'users.id', 'LEFT');

		$builder->whereIn('role_user.role_id', $role->getDescendant()->merge([$role])->pluck($role->getKeyName()));
	}

	public function scope_all(Builder $builder, $keywords)
	{
		if (empty($keywords)) return;
		$users = static::search(null)->where('username,nickname,realname,phone,email', $keywords)->take(2000)->get();
		return $builder->whereIn($this->getKeyName(), $users->pluck($this->getKeyName()));
	}
}

//自动创建extra等数据
User::created(function($user){
	$user->finance()->create([]);
});
	