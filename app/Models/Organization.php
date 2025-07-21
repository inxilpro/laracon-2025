<?php

namespace App\Models;

use App\Database\HasNear;
use App\Database\HasPredictedEvents;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Models\Types\OrganizationTypes;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model implements OrganizationTypes
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
