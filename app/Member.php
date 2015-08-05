<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	//表名
    protected $table = 'member';
    //主键名称
    protected $primaryKey = 'uid';
    //不能批量赋值
    protected $guarded = ['uid', 'password'];
}
