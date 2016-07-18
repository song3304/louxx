<?php

namespace App;

use Addons\Core\Models\User as BaseUser;

class User extends BaseUser 
{

	public function editor()
	{
		return $this->hasOne('App\\User', 'id', 'editor_uid');
	}
}
