<?php

namespace App\Models;

use App\Models\Types\OrganizationTypes;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model implements OrganizationTypes
{
	public function events()
	{
		return $this->hasMany(Event::class);
	}
	
	public function teams()
	{
		return $this->hasMany(Team::class);
	}
}
