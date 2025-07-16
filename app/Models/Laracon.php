<?php

namespace App\Models;

use App\Data\Coordinate;
use Illuminate\Database\Eloquent\Model;

class Laracon extends Model
{
	protected function casts(): array
	{
		return [
			'coordinates' => Coordinate::class,
			'starts_at' => 'date',
			'ends_at' => 'date',
		];
	}
}
