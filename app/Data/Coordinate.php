<?php

namespace App\Data;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Coordinate implements Castable
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
	
	public static function castUsing(array $arguments)
	{
		return new class implements CastsAttributes {
			public function get(Model $model, string $key, mixed $value, array $attributes): ?Coordinate
			{
				if ($value === null) {
					return null;
				}
				
				// Parse WKB format: SRID (4) + byte order (1) + type (4) + X (8) + Y (8)
				$wkb = substr($value, 4); // Skip SRID
				$isLittleEndian = ord($wkb[0]) === 1;
				
				// Extract X and Y coordinates (skip byte order + geometry type = 5 bytes)
				$x = substr($wkb, 5, 8);
				$y = substr($wkb, 13, 8);
				
				// Reverse bytes for big-endian if needed
				if (!$isLittleEndian) {
					$x = strrev($x);
					$y = strrev($y);
				}
				
				// Unpack doubles and create coordinate (longitude = X, latitude = Y)
				$longitude = unpack('d', $x)[1];
				$latitude = unpack('d', $y)[1];
				
				return new Coordinate($latitude, $longitude);
			}
			
			public function set(Model $model, string $key, mixed $value, array $attributes): mixed
			{
				if ($value === null) {
					return null;
				}
				
				if (! $value instanceof Coordinate) {
					throw new InvalidArgumentException($model::class."::{$key} must be a Coordinate object.");
				}
				
				$srid = pack('V', 0);
				$byte_order = pack('C', 1);
				$geometry = pack('V', 1);
				$x = pack('d', $value->longitude);
				$y = pack('d', $value->latitude);
				
				return $srid.$byte_order.$geometry.$x.$y;
			}
		};
	}
}
