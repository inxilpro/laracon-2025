<?php

namespace App\Data;

class Coordinate
{
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
}
