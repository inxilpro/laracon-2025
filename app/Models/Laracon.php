<?php

namespace App\Models;

use App\Database\HasCommaList;
use App\Database\HasNear;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Model;

class Laracon extends Model implements Locatable
{
	use HasLocation;
	
	public function cell_towers()
	{
		return new HasNear($this, new CellTower(), new Distance(meters: 500));
	}
	
	public function speakers()
	{
		return new HasCommaList($this, new Speaker(), 'speakers', 'name');
	}
}
