<?php

namespace App\Models;

use App\Database\HasFaker;
use App\Database\HasPredictedEvents;
use App\Models\Types\OrganizationTypes;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model implements OrganizationTypes
{
	public function events()
	{
		return new HasPredictedEvents($this);
	}
	
	public function teams()
	{
		return new HasFaker($this, new Team(), 5, 10, fn(Generator $faker) => [
			'name' => $faker->colorName(),
		]);
	}
}
