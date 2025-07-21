<?php

namespace App\Models;

use App\Database\HasFaker;
use App\Database\HasNear;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Support\Distance;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable
{
	use HasLocation;
	
	public function speakers()
	{
		return new HasFaker($this, new Speaker(), random_int(5, 15), function(Generator $faker) {
			return [
				'name' => $faker->name(),
			];
		});
	}
	
	public function cell_towers()
	{
		return new HasNear($this, new CellTower(), new Distance(1000));
	}
}
