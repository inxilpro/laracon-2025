<?php

namespace App\Support;

use App\Data\Coordinate;

class Haversine
{
	protected const int RADIUS_IN_MILES = 3959;
	protected const int RADIUS_IN_KM = 6371;
	
	public function __construct(
		protected Coordinate $from,
		protected Coordinate $to,
	) {
	}
	
	public function miles(): float|int
	{
		return $this->angularDistance() * static::RADIUS_IN_MILES;
	}
	
	public function km(): float|int
	{
		return $this->angularDistance() * static::RADIUS_IN_KM;
	}
	
	protected function angularDistance(): float
	{
		$angle = $this->angle();
		
		return 2 * atan2(sqrt($angle), sqrt(1 - $angle));
	}
	
	protected function angle(): float
	{
		$latitude_delta = $this->to->latitudeInRadians() - $this->from->latitudeInRadians();
		$longitude_delta = $this->to->longitudeInRadians() - $this->from->longitudeInRadians();
		
		return sin($latitude_delta / 2) ** 2 + $this->from->latitudeCosine() * $this->to->latitudeCosine() * sin($longitude_delta / 2) ** 2;
	}
}
