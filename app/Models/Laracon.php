<?php

namespace App\Models;

use App\Database\HasNear;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Model;

class Laracon extends Model implements Locatable
{
	use HasCoordinates;
	
	public function cell_towers()
	{
		return new HasNear($this, new CellTower(), new Distance(meters: 500));
	}
}
