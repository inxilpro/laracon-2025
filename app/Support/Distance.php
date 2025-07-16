<?php

namespace App\Support;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Grammar;
use Illuminate\Support\Facades\DB;

class Distance implements Expression
{
	public static function meters(float $value): Distance
	{
		return new Distance($value);
	}
	
	public static function miles(float $value): Distance
	{
		return new Distance($value * 0.000621371192);
	}
	
	public function __construct(
		protected float $meters,
	) {
	}
	
	public function getValue(Grammar $grammar)
	{
		return $grammar->quoteString($this->meters);
	}
	
	public function __toString(): string
	{
		return $this->getValue(DB::getQueryGrammar());
	}
}
