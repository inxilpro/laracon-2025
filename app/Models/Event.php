<?php

namespace App\Models;

use App\Locatable;
use App\Models\Types\EventTypes;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable, EventTypes
{
	use HasLocation;
	
	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
}
