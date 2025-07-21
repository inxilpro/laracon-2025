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
		$dictionary = [];
		foreach ($models as $event) {
			foreach (explode(',', $event->speaker_ids) as $id) {
				$dictionary[$id] ??= [];
				$dictionary[$id][] = $event;
			}
		}
		
		foreach ($results as $speaker) {
			foreach ($dictionary[$speaker->id] ?? [] as $event) {
				$event->getRelation($relation)->push($speaker);
			}
		}
		
		return $models;
	}
}
