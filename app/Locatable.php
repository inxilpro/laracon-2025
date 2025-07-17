<?php

namespace App;

use App\Data\Coordinates;
use App\Support\Distance;

interface Locatable
{
	public function coordinates(): Coordinates;
	
	public function distance(Locatable|Coordinates $other): Distance;
}
