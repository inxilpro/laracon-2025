<?php

namespace App\Models;

use App\Models\Types\SpeakerTypes;
use HosmelQ\NameOfPerson\PersonName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;

class Speaker extends Model implements SpeakerTypes
{
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
		
		return Uri::of('https://avatar.vercel.sh')
			->withPath(Str::of($this->name->full())->slug()->finish('.svg'))
			->withQuery(['text' => $this->name->initials()])
			->value();
	}
}
