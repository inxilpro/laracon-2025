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
		protected string $foreign_key,
		protected string $local_key,
	) {
		parent::__construct($parent, $related);
	}
	
	public function addEagerConstraints(array $models): void
	{
		$values = collect($models)
			->flatMap($this->getKeysFromParent(...))
			->unique();
		
		$this->query->whereIn($this->local_key, $values);
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		$dictionary = [];
		foreach ($models as $parent) {
			foreach ($this->getKeysFromParent($parent) as $value) {
				$dictionary[$value] ??= [];
				$dictionary[$value][] = $parent;
			}
		}
		
		foreach ($results as $related) {
			foreach ($dictionary[$related->getAttribute($this->local_key)] ?? [] as $parent) {
				$parent->getRelation($relation)->push($related);
			}
		}
		
		return $models;
	}
	
	protected function getKeysFromParent(Model $model): array
	{
		return explode(',', $model->getAttribute($this->foreign_key));
	}
}
