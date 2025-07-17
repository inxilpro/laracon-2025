<?php

namespace App\Data;

use App\Casts\CoordinatesCast;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Grammar;

class Coordinates implements Castable, Arrayable, Expression
{
	public static function castUsing(array $arguments)
	{
		return CoordinatesCast::class;
	}
	
	public function __construct(
		public float $latitude,
		public float $longitude,
	) {
	}
	
	public function latitudeCosine(): float
	{
		return cos($this->latitudeInRadians());
	}
	
	public function latitudeInRadians(): float
	{
		return deg2rad($this->latitude);
	}
	
	public function longitudeInRadians(): float
	{
		return deg2rad($this->longitude);
	}
	
	public function toArray(): array
	{
		return [
			'latitude' => $this->latitude,
			'longitude' => $this->longitude,
		];
	}
	
	public function getValue(Grammar $grammar): string
	{
		return 'ST_GeomFromText('.$grammar->quoteString("point({$this->longitude} {$this->latitude})").')';
	}
}
