<?php

namespace App\Models;

use App\Database\HasNear;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	public function events()
	{
		return $this->hasMany(Event::class);
	}
}
