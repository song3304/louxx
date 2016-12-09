<?php
namespace App;

use App\Catalog;
trait CatalogCastTrait {
	public function asCatalog($value) {
		$data = Catalog::getCatalogsById($value);
		unset($data['children']);
		return (new Catalog())->setRawAttributes($data);
	}

	public function catalogToArray($value) {
		return $value->toArray();
	}

	public function asCatalogName($value) {
		$data = Catalog::getCatalogsByName($value);
		unset($data['children']);
		return (new Catalog())->setRawAttributes($data);
	}

	public function catalogNameToArray($value) {
		return $value->toArray();
	}

	public function asStatus($value) {
		return $this->asCatalog($value);
	}

	public function statusToArray($value) {
		return $value->toArray();
	}
}