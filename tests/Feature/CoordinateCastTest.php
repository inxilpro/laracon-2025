<?php

namespace Tests\Feature;

use App\Data\Coordinates;
use App\Models\Laracon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoordinateCastTest extends TestCase
{
	use RefreshDatabase;
	
	public function test_coordinates_can_be_cast(): void
	{
		$nyc = Laracon::create([
			'organization' => 'Laracon US',
			'title' => 'NYC',
			'location' => new Coordinates(40.7128, -74.0060),
			'speaker_ids' => '',
		]);
		
		$queried = Laracon::find($nyc->getKey());
		
		$this->assertEquals(40.7128, $queried->location->latitude);
		$this->assertEquals(-74.0060, $queried->location->longitude);
	}
}
