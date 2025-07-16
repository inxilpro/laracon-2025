<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @template TParent of Model
 * @template TRelated of Model
 */
abstract class SimplifiedManyRelation extends Relation
{
	/**
	 * @param TParent $parent
	 * @param TRelated $related
	 */
	public function __construct(Model $parent, Model $related)
	{
		parent::__construct($related->newQuery(), $parent);
	}
	
	public function addConstraints()
	{
		if (static::$constraints) {
			$this->addEagerConstraints([$this->parent]);
		}
	}
	
	/** @param TParent[] $models */
	public function addEagerConstraints(array $models)
	{
		parent::addEagerConstraints($models);
	}
	
	/**
	 * @param TParent[] $models
	 * @param \Illuminate\Database\Eloquent\Collection<int,TRelated> $results
	 * @param string $relation
	 * @return TParent[]
	 */
	public function match(array $models, EloquentCollection $results, $relation)
	{
		return parent::match($models, $results, $relation);
	}
	
	public function initRelation(array $models, $relation)
	{
		foreach ($models as $model) {
			$model->setRelation($relation, $this->related->newCollection());
		}
		
		return $models;
	}
	
	public function getResults()
	{
		return $this->query->get();
	}
}
