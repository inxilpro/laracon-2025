<?php

namespace App\Support;

class Haversine
{
	protected const int RADIUS_IN_METERS = 6_371_009;
	
	public function __construct(
		protected Coordinates $from,
		protected Coordinates $to,
	) {
	}
	
	public function distance(): Distance
	{
		return new Distance($this->angularDistance() * static::RADIUS_IN_METERS);
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
