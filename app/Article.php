<?php
namespace App;

use App\Model;

class Article extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
}
