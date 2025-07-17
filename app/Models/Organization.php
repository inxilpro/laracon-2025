<?php

namespace App\Models;

use App\Database\HasNear;
use App\Database\HasPredictedEvents;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/** @property-read \Illuminate\Database\Eloquent\Collection<int,\App\Models\Event> $more_events */
class Organization extends Model
{
	public function events()
	{
		return $this->hasMany(Event::class);
	}
	
	public function more_events()
	{
		return new HasPredictedEvents($this);
	}
}
