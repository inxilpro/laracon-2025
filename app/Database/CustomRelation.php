<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\Relation;

class CustomRelation extends Relation
{
	public function __construct(
		protected CustomRelationBuilder $builder
	) {
		parent::__construct($this->builder->related->newQuery(), $this->builder->parent);
	}
	
	public function addConstraints()
	{
		if (static::$constraints) {
			$this->builder->addConstraints(
				$this->parent->newCollection([$this->parent])
			);
		}
	}
	
	public function addEagerConstraints(array $models)
	{
		$this->builder->addConstraints(
			$this->parent->newCollection($models)
		);
	}
	
	public function initRelation(array $models, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation($relation, $this->related->newCollection());
		}
		
		return $models;
	}
	
	public function match(array $models, EloquentCollection $results, $relation)
	{
		$this->builder->match(
			models: $this->parent->newCollection($models),
			results: $results,
			relation: $relation
		);
	}
	
	public function getResults()
	{
		return $this->query->get();
	}
}
