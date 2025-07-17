<?php

namespace App\Database\Types;

use App\Locatable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

interface HasNearTypes
{
	/** @param Model&Locatable[] $models */
	public function addEagerConstraints(array $models): void;
	
	/**
	 * @param Model&Locatable[] $models
	 * @param \Illuminate\Database\Eloquent\Collection<int,Model&Locatable> $results
	 * @param string $relation
	 * @return Model&Locatable[]
	 */
	public function match(array $models, EloquentCollection $results, $relation): array;
}
