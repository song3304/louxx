<?php
namespace App;

use Addons\Entrust\Permission as BasePermission;
use OwenIt\Auditing\Auditable;
use Addons\Elasticsearch\Scout\Searchable;

class Permission extends BasePermission
{
	use Searchable, Auditable;

}