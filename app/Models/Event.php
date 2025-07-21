<?php

namespace App\Models;

use App\Database\HasSpeakers;
use App\Locatable;
use App\Models\Types\EventTypes;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable, EventTypes
{
	use HasLocation;
	
	public function speakers()
	{
		return new HasSpeakers($this);
	}
}
