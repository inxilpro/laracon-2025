<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class CustomRelationBuilder
{
	public static function relation(Model $parent, Model $related): SimplifiedManyRelation
	{
		return new SimplifiedManyRelation(new static($parent, $related));
	}
	
	/**
	 * @param TParent $parent
	 * @param TRelated $related
	 */
	public function __construct(
		public Model $parent,
		public Model $related,
	) {
	}
	
	/** @param Collection<int,TParent> $models */
	abstract public function addConstraints(Builder $query, Collection $models);
	
	/**
	 * @param Collection<int,TParent> $models
	 * @param Collection<int,TRelated> $results
	 */
	abstract public function match(Collection $models, Collection $results, string $relation);
}
