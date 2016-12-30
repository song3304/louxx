<?php
namespace App;

use Plugins\Catalog\App\Catalog as BaseCatalog;
use App\Logable;
use Addons\Elasticsearch\Scout\Searchable;

class Catalog extends BaseCatalog {
	use Logable, Searchable;
}
