<?php

namespace App\Models;

use App\Locatable;
use Illuminate\Database\Eloquent\Model;

class CellTower extends Model implements Locatable
{
	use HasCoordinates;
}
