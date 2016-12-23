<?php
namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

use Addons\Core\Models\CacheTrait;
use Addons\Core\Models\CallTrait;
use Addons\Core\Models\PolyfillTrait;
use App\CatalogCastTrait;
use Addons\Elasticsearch\Scout\Searchable;
use App\Logable;

class Model extends BaseModel {
	use CacheTrait, CallTrait, PolyfillTrait;
	use CatalogCastTrait;
	use Searchable, Logable;
}
