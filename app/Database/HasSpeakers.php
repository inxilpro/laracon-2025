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
		$ids = collect($models)
			->flatMap(fn(Event $event) => explode(',', $event->speaker_ids))
			->unique();
		
		$this->query->whereIn('id', $ids);
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		$results = $results->keyBy('id');
		
		foreach ($models as $event) {
			$speakers = $this->related->newCollection();
			
			foreach (explode(',', $event->speaker_ids) as $id) {
				if ($results->has($id)) {
					$speakers->push(clone $results->get($id));
				}
			}
			
			$event->setRelation($relation, $speakers);
		}
		
		return $models;
	}
}
