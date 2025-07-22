<?php

namespace App\Database;

use App\Database\Types\HasNearTypes;
use App\Locatable;
use App\Support\Distance;
use Closure;
use Faker\Factory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

class HasFaker extends SimplifiedManyRelation
{
	public function __construct(
		Model $parent,
		Model $related,
		protected int $min,
		protected int $max,
		protected Closure $factory,
	) {
		parent::__construct($parent, $related);
	}
	
	public function addConstraints()
	{
		//
	}
	
	public function addEagerConstraints(array $models)
	{
		//
	}
	
	public function getResults()
	{
		return $this->generate();
	}
	
	public function getEager()
	{
		// We'll just call generate in match() in this context
		return new Collection();
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		foreach ($models as $parent) {
			$collection = $this->generate();
			$parent->setRelation($relation, $collection);
		}
		
		return $models;
	}
	
	protected function generate()
	{
		$faker = Factory::create();
		$collection = $this->related->newCollection();
		$count = random_int($this->min, $this->max);
		
		for ($i = 0; $i < $count; $i++) {
			$attributes = call_user_func($this->factory, $faker, $i);
			$collection->push($this->related->newInstance($attributes));
		}
		
		return $collection;
	}
}
