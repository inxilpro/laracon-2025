<?php

namespace App\Models;

use App\Database\HasFaker;
use App\Models\Types\OrganizationTypes;
use Faker\Generator;
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
