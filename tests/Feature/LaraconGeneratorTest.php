<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Support\Alzara;
use Tests\TestCase;

class LaraconGeneratorTest extends TestCase
{
	public function test_it_generates_a_useful_prompt(): void
	{
		$organization = Organization::firstWhere('name', 'Laracon US');
		$generator = new Alzara($organization);
		
		$result = $generator->data(5);
		
		dump($result);
	}
	
	public function test_(): void
	{
		$organization = Organization::firstWhere('name', 'Laracon US');
		
		dump($organization->more_events->toArray());
	}
}
