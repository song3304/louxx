<?php
namespace App;

use App\Catalog;
trait CatalogCastTrait {
	public function asCatalog($value) {
		$data = Catalog::getCatalogsById($value);
		return new Catalog($data);
	}
	public function asCatalogName($value) {
		$data = Catalog::getCatalogsByName($value);
		return new Catalog($data);
	}
}