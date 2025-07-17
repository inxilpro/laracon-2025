<?php

namespace App\Database\Types;

use App\Locatable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

interface HasSpeakersTypes
{
	/** @param \App\Models\Event[] $models */
	public function addEagerConstraints(array $models): void;
	
	/**
	 * @param \App\Models\Event[] $models
	 * @param \Illuminate\Database\Eloquent\Collection<int,\App\Models\Speaker> $results
	 * @param string $relation
	 * @return \App\Models\Event[]
	 */
	public function match(array $models, EloquentCollection $results, $relation): array;
}
