<?php

namespace App\Models;

use App\Database\HasLetters;
use App\Models\Types\SpeakerTypes;
use HosmelQ\NameOfPerson\PersonName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Uri;

class Speaker extends Model implements SpeakerTypes
{
	public function letters()
	{
		return new HasLetters($this, 'name');
	}
	
	public function name(): Attribute
	{
		return Attribute::make(
			get: fn($value) => PersonName::fromFull($value),
		);
	}
	
	public function avatar(): string
	{
		if ($this->twitter) {
			return 'https://unavatar.io/x/'.$this->twitter;
		}
		
		return Uri::of(url('/avatar'))
			->withQuery(['initials' => $this->name->initials()])
			->value();
	}
}
