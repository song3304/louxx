<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

use Addons\Core\Models\CacheTrait;
use Addons\Core\Models\CallTrait;
use Addons\Core\Models\PolyfillTrait;

class Model extends BaseModel {
	use CacheTrait, CallTrait, PolyfillTrait;

}
