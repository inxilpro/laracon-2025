<?php

namespace App\Models;

use App\Models\Types\TeamTypes;
use Illuminate\Database\Eloquent\Model;

class Team extends Model implements TeamTypes
{
	public function users()
	{
		return $this->hasMany(User::class);
	}
}
