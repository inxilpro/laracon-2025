<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class CustomRelationBuilder
{
	public function __construct(
		public Model $parent,
		public Model $related,
	) {
	}
	
	/** @param Collection<int,\Illuminate\Database\Eloquent\Model> $models */
	abstract public function addConstraints(Collection $models);
	
	/**
	 * @param Collection<int,\Illuminate\Database\Eloquent\Model> $models
	 * @param Collection<int,\Illuminate\Database\Eloquent\Model> $results
	 */
	abstract public function match(Collection $models, Collection $results, string $relation);
}
