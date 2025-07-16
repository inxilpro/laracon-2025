<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @template TParent of Model
 * @template TRelated of Model
 */
abstract class CustomRelationBuilder
{
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
	abstract public function addConstraints(Collection $models);
	
	/**
	 * @param Collection<int,TParent> $models
	 * @param Collection<int,TRelated> $results
	 */
	abstract public function match(Collection $models, Collection $results, string $relation);
}
