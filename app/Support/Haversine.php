<?php

namespace App\Support;

class Haversine
{
	protected const int RADIUS_IN_METERS = 6_371_009;
	
	public static function random(Coordinates $from, $min = 200, $max = 1000): Coordinates
	{
		$bearing = deg2rad(rand(0, 360));
		$angular_distance = rand($min, $max) / static::RADIUS_IN_METERS;
		
		$from_lat = $from->latitudeInRadians();
		$from_lng = $from->longitudeInRadians();
		
		$to_lat = rad2deg(asin(
			sin($from_lat) * cos($angular_distance) +
			cos($from_lat) * sin($angular_distance) * cos($bearing)
		));
		
		$to_lng = rad2deg($from_lng + atan2(
				sin($bearing) * sin($angular_distance) * cos($from_lat),
				cos($angular_distance) - sin($from_lat) * sin($to_lat)
			));
		
		return new Coordinates($to_lat, $to_lng);
	}
	
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
