<?php

namespace App\Models;

use App\Locatable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable
{
	use HasLocation;
}
