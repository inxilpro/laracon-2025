<?php

namespace App\Models;

use App\Data\Coordinates;
use App\Locatable;
use App\Support\Distance;
use App\Support\Haversine;

/**
 * @property Coordinates $coordinates
 */
trait HasCoordinates
{
	public function coordinates(): Coordinates
	{
		return $this->coordinates;
	}
	
	public function distance(Locatable|Coordinates $other): Distance
	{
		return $this->haversine($other)->distance();
	}
	
	protected function haversine(Locatable|Coordinates $other): Haversine
	{
		if ($other instanceof Locatable) {
			$other = $other->coordinates();
		}
		
		return new Haversine($this->coordinates(), $other);
	}
	
	protected function initializeHasAttributes(): void
	{
		$this->casts = array_merge(['coordinates' => Coordinates::class], $this->casts);
	}
}
