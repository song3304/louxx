<?php
namespace App;

use App\Catalog;
trait CatalogCastTrait {
	public function asCatalog($value) {
		$data = Catalog::getCatalogsById($value);
		unset($data['children']);
		return (new Catalog())->setRawAttributes($data);
	}

	public function fromCatalog($value) {
		return $value->toArray();
	}

	public function asCatalogName($value) {
		$data = Catalog::getCatalogsByName($value);
		unset($data['children']);
		return (new Catalog())->setRawAttributes($data);
	}

	public function fromCatalogName($value) {
		return $value->toArray();
	}

	public function asStatus($value) {
		return $this->asCatalog($value);
	}

	public function fromStatus($value) {
		return $value->toArray();
	}
}