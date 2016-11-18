<?php
namespace App;

trait CatalogCastTrait {
	public function asCatalog($value) {
		return Catalog::getCatalogsById($value);
	}
	public function asCatalogName($value) {
		return Catalog::getCatalogsByName($value);
	}
}