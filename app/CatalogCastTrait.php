<?php
namespace App;

use App\Catalog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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

	public function scopeOfCatalog(Builder $builder, $idOrModel, $field_name)
	{
		$id = $idOrModel;
		if ($idOrModel instanceof Model)
			$id = $idOrModel->getKey();
		elseif (!is_numeric($idOrModel) && strpos($idOrModel, '.') !== false) {
			$catalog = $this->asCatalogName($idOrModel);
			!empty($catalog->getKey()) && $id = $catalog->getKey();
		}

		$builder->where($field_name, $id);
	}
}