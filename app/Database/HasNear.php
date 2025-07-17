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
		protected Distance $distance,
		protected Expression|string $coordinates = 'coordinates',
	) {
		parent::__construct($parent, $related);
	}
	
	public function addEagerConstraints(array $models)
	{
		foreach ($models as $parent) {
			$st_distance_sphere = DB::sphericalDistance($this->coordinates, $parent->coordinates());
			$this->query->orWhereRaw("{$st_distance_sphere} < {$this->distance}");
		}
	}
	
	public function match(array $models, EloquentCollection $results, $relation)
	{
		foreach ($models as $parent) {
			$collection = $parent->getRelation($relation);
			
			foreach ($results as $related) {
				if ($this->isWithinDistance($parent, $related)) {
					$collection->push($related);
				}
			}
		}
		
		return $models;
	}
	
	protected function isWithinDistance(Model&Locatable $from, Model&Locatable $to): bool
	{
		$distance = $this->distance;
		
		if (is_string($distance)) {
			$distance = $to->getAttribute($distance);
		}
		
		return $from->miles($to) <= $distance;
	}
	
	protected function distanceExpression()
	{
		return is_string($this->distance) 
			? DB::getQueryGrammar()->wrapTable($this->distance)
			: $this->distance;
	}
}
