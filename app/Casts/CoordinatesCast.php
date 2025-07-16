<?php

namespace App\Casts;

use App\Data\Coordinates;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class CoordinatesCast implements CastsAttributes
{
	public function get(Model $model, string $key, mixed $value, array $attributes): ?Coordinates
	{
		if ($value === null) {
			return null;
		}
		
		$x = substr($value, 9, 8);  // SRID (4) + byte order (1) + type (4) = 9
		$y = substr($value, 17, 8); // SRID (4) + byte order (1) + type (4) + X (8) = 17
		
		// Reverse bytes for big-endian if needed
		if (ord($value[4]) !== 1) {
			$x = strrev($x);
			$y = strrev($y);
		}
		
		// Unpack doubles (in MySQL, longitude is X and latitude is Y)
		return new Coordinates(
			latitude: unpack('d', $y)[1],
			longitude: unpack('d', $x)[1]
		);
	}
	
	public function set(Model $model, string $key, mixed $value, array $attributes): mixed
	{
		if ($value === null) {
			return null;
		}
		
		if (! $value instanceof Coordinates) {
			throw new InvalidArgumentException($model::class."::{$key} must be a Coordinate object.");
		}
		
		$srid = pack('V', 0);
		$byte_order = pack('C', 1);
		$geometry = pack('V', 1);
		$x = pack('d', $value->longitude);
		$y = pack('d', $value->latitude);
		
		return $srid.$byte_order.$geometry.$x.$y;
	}
}
