<?php

namespace App\Models;

use App\Database\HasCommaList;
use App\Database\HasNear;
use App\Database\HasSpeakers;
use App\Locatable;
use App\Support\Distance;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Event extends Model implements Locatable
{
	use HasLocation;
	
	public function cell_towers()
	{
		return new HasNear($this, new CellTower(), new Distance(meters: 500));
	}
	
	public function speakers()
	{
		return new HasSpeakers($this);
		// return new HasCommaList($this, new Speaker(), 'speaker_ids', 'id');
	}
	
	public function speakerIds(): Attribute
	{
		return Attribute::make(
			get: fn($value) => explode(',', $value),
			set: fn($value) => is_array($value) ? implode(',', $value) : $value,
		);
	}
}
