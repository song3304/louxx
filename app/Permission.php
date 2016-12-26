<?php
namespace App;

use Addons\Entrust\Permission as BasePermission;
use App\Logable;
use Addons\Elasticsearch\Scout\Searchable;

class Permission extends BasePermission
{
	use Searchable, Logable;

}