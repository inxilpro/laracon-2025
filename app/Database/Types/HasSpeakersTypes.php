<?php

namespace App\Database\Types;

use App\Locatable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

interface HasSpeakersTypes
{
	/** @param \App\Models\Laracon[] $models */
	public function addEagerConstraints(array $models): void;
	
	/**
	 * @param \App\Models\Laracon[] $models
	 * @param \Illuminate\Database\Eloquent\Collection<int,\App\Models\Speaker> $results
	 * @param string $relation
	 * @return \App\Models\Laracon[]
	 */
	public function match(array $models, EloquentCollection $results, $relation): array;
}
