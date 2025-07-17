<?php

namespace App\Database;

use App\Database\Types\HasSpeakersTypes;
use App\Models\Laracon;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class HasSpeakers extends SimplifiedManyRelation implements HasSpeakersTypes
{
	public function __construct(Laracon $laracon)
	{
		parent::__construct($laracon, new Speaker());
	}
	
	public function addEagerConstraints(array $models): void
	{
		$ids = collect($models)
			->flatMap(fn(Laracon $laracon) => $laracon->speaker_ids)
			->unique();
		
		$this->query->whereIn('id', $ids);
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		$dictionary = [];
		foreach ($models as $laracon) {
			foreach ($laracon->speaker_ids as $index => $id) {
				$dictionary[$id] ??= [];
				$dictionary[$id][] = $laracon;
			}
		}
		
		foreach ($results as $speaker) {
			foreach ($dictionary[$speaker->id] ?? [] as $laracon) {
				$laracon->getRelation($relation)->push($speaker);
			}
		}
		
		return $models;
	}
}
