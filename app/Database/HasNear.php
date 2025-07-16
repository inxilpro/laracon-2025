<?php

namespace App\Database;

use App\Locatable;
use App\Support\Distance;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HasNear extends SimplifiedManyRelation
{
	public function __construct(
		Model&Locatable $parent,
		Model&Locatable $related,
		protected Distance|Expression $distance = new Distance(25_000),
		protected string $coordinates_column = 'coordinates',
	) {
		parent::__construct($parent, $related);
	}
	
	public function addEagerConstraints(array $models)
	{
		foreach ($models as $parent) {
			$this->query->orWhereRaw(sprintf('%s < %s',
				DB::sphericalDistance($this->coordinates_column, $parent->coordinates()),
				$this->distance,
			));
		}
	}
	
	public function match(array $models, EloquentCollection $results, $relation)
	{
		foreach ($models as $parent) {
			$collection = $parent->getRelation($relation);
			
			foreach ($results as $related) {
				if ($related->miles($parent) <= $this->distance) {
					$collection->push($related);
				}
			}
		}
		
		return $models;
	}
}
