<?php

namespace App;

use App\Support\Coordinates;
use App\Support\Distance;

interface Locatable
{
	public function coordinates(): Coordinates;
	
	public function distance(Locatable|Coordinates $other): Distance;
}
