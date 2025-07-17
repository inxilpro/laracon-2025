<?php

namespace App\Database;

use App\Database\Types\HasNearTypes;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class HasCommaList extends SimplifiedManyRelation
{
	public function __construct(
		Model $parent,
		Model $related,
		protected string $parent_column,
		protected string $related_column,
	) {
		parent::__construct($parent, $related);
	}
	
	public function addEagerConstraints(array $models): void
	{
		$values = collect($models)
			->flatMap($this->getListFromParent(...))
			->unique();
		
		$this->query->whereIn($this->related_column, $values);
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		$dictionary = [];
		foreach ($models as $parent) {
			foreach ($this->getListFromParent($parent) as $value) {
				$dictionary[$value] ??= [];
				$dictionary[$value][] = $parent;
			}
		}
		
		foreach ($results as $related) {
			foreach ($dictionary[$related->getAttribute($this->related_column)] ?? [] as $parent) {
				$parent->getRelation($relation)->push($related);
			}
		}
		
		return $models;
	}
	
	protected function getListFromParent(Model $model): array
	{
		return explode(',', $model->getAttribute($this->parent_column));
	}
}
