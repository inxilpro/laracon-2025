<?php

namespace App;

use App\Data\Coordinates;

interface Locatable
{
	public function coordinates(): Coordinates;
	
	public function miles(Locatable|Coordinates $other): float;
	
	public function km(Locatable|Coordinates $other): float;
}
