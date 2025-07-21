<?php

namespace App\Database;

use App\Database\Types\HasSpeakersTypes;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class HasSpeakers extends SimplifiedManyRelation implements HasSpeakersTypes
{
	public function __construct(Event $event)
	{
		parent::__construct($event, new Speaker());
	}
	
	public function addEagerConstraints(array $models): void
	{
		
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		return $models;
	}
}
