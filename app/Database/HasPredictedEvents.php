<?php

namespace App\Database;

use App\Database\Types\HasSpeakersTypes;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Speaker;
use App\Support\Alzara;
use App\Support\Coordinates;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasPredictedEvents extends HasMany
{
	public function __construct(
		protected Organization $organization,
		protected int $count = 5,
	) {
		parent::__construct($organization->newQuery(), new Event(), 'organization_id', 'id');
	}
	
	public function getResults()
	{
		$results = parent::getResults();
		
		$predictions = (new Alzara($this->organization, $results))->data($this->count);
		
		foreach ($predictions as $prediction) {
			$event = new Event([
				'title' => $prediction['title'],
				'location' => new Coordinates($prediction['location']['latitude'], $prediction['location']['longitude']),
			]);
			
			$speakers = collect($prediction['speakers'])
				->map(fn($name) => new Speaker(['name' => $name]));
			
			$event->setRelation('speakers', $speakers);
			
			$results->push($event);
		}
		
		return $results;
	}
}
