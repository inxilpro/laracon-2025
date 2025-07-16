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
				
				// Skip SRID (first 4 bytes)
				$value = substr($value, 4);
				
				// Read byte order (1 byte)
				$byte_order = (int) unpack('C', $value[0])[1];
				$is_little_endian = 1 === $byte_order;
				
				// Extract coordinate data (skip byte order + geometry type = 5 bytes)
				$data = substr($value, 5, 16);
				
				// PHP's unpack doesn't support endianness in format string
				// We need to manually handle byte order
				if ($is_little_endian) {
					$coords = unpack('d2', $data);
				} else {
					// For big endian, we need to reverse the bytes for each double
					$x_bytes = strrev(substr($data, 0, 8));
					$y_bytes = strrev(substr($data, 8, 8));
					$coords = unpack('d', $x_bytes) + unpack('d', $y_bytes);
					$coords[2] = $coords[1];
					$coords[1] = array_values(unpack('d', $x_bytes))[0];
					$coords[2] = array_values(unpack('d', $y_bytes))[0];
				}
				
				return new Coordinate($coords[2], $coords[1]);
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
