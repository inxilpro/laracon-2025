<?php

namespace App\Database;

use App\Database\Types\HasNearTypes;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

class HasNear extends SimplifiedManyRelation implements HasNearTypes
{
	public function __construct(
		Model&Locatable $parent,
		Model&Locatable $related,
		protected Distance $threshold,
	) {
		parent::__construct($parent, $related);
	}
	
	public function addEagerConstraints(array $models): void
	{
		$this->query->where(function(Builder $query) use ($models) {
			foreach ($models as $parent) {
				$distance_expr = <<<SQL
					ST_Distance_Sphere(  -- calculate the spherical distance
						`coordinates`,   -- from the table's coordinates column
						ST_GeomFromText( -- to a point() representing our lat/lng
							"point({$parent->coordinates()->longitude} {$parent->coordinates()->latitude})"
						)
					)
				SQL;
				$query->orWhereRaw("{$distance_expr} < {$this->threshold}");
			}
		});
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		foreach ($models as $parent) {
			$collection = $this->related->newCollection();
			
			foreach ($results as $related) {
				if ($parent->distance($related)->lte($this->threshold)) {
					$collection->push($related);
				}
			}
			
			$parent->setRelation($relation, $collection);
		}
		
		return $models;
	}
}
