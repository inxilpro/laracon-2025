<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Support\Coordinates;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoordinateCastTest extends TestCase
{
	use RefreshDatabase;
	
	public function test_coordinates_can_be_cast(): void
	{
		$nyc = Event::create([
			'organization' => 'Laracon US',
			'title' => 'NYC',
			'location' => new Coordinates(40.7128, -74.0060),
			'speaker_ids' => '',
		]);
		
		$queried = Event::find($nyc->getKey());
		
		$this->assertEquals(40.7128, $queried->location->latitude);
		$this->assertEquals(-74.0060, $queried->location->longitude);
	}
}
