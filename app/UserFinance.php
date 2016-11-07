<?php
namespace App;

use Addons\Core\Models\Model;

class UserFinance extends Model 
{
	public function user()
	{
		return $this->hasOne('App\\User', 'id', 'id');
	}
}
