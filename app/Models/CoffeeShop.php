<?php

namespace App\Models;

use App\Locatable;
use Illuminate\Database\Eloquent\Model;

class CoffeeShop extends Model implements Locatable
{
	use HasLocation;
}
