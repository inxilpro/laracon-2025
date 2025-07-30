<?php

namespace App\Models;

use App\Database\HasNear;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Models\Types\EventTypes;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable, EventTypes
{
	use HasLocation;
	
	public function ice_cream_shops()
	{
		return new HasNear($this, new IceCreamShop(), new Distance(500));
	}
	
	public function speakers()
	{
		return new HasSpeakers($this);
	}
	
	public function organization()
	{
		return $this->belongsTo(Organization::class);
	}
	
	public function toArray()
	{
		return parent::toArray() + ['exists' => $this->exists];
	}
}
