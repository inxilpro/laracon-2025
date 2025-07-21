<?php

namespace App\Models;

use App\Database\HasNear;
use App\Locatable;
use App\Models\Types\EventTypes;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable, EventTypes
{
	use HasLocation;
	
	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
	
	public function cell_towers()
	{
		return new HasNear($this, new CellTower(), new Distance(500));
	}
}
