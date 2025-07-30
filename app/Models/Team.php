<?php

namespace App\Models;

use App\Database\HasFaker;
use App\Models\Types\TeamTypes;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;

class Team extends Model implements TeamTypes
{
	public function users()
	{
		return new HasFaker($this, new User(), 10, 20, fn(Generator $faker) => [
			'name' => $faker->name(),
			'location' => $faker->streetAddress(),
		]);
	}
}
