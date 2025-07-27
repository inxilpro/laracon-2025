<?php

namespace App\Models;

use App\Locatable;
use Illuminate\Database\Eloquent\Model;

class IceCreamShop extends Model implements Locatable
{
	use HasLocation;
}
