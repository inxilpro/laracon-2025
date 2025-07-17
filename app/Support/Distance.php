<?php

namespace App\Support;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Grammar;
use Illuminate\Support\Facades\DB;

class Distance implements Expression
{
	public function __construct(
		protected float $meters,
	) {
	}
	
	public function miles(): float
	{
		return $this->meters * 0.00062137119;
	}
	
	public function gte(Distance $distance): bool
	{
		return $this->meters >= $distance->meters;
	}
	
	public function lte(Distance $distance): bool
	{
		return $this->meters <= $distance->meters;
	}
	
	public function eq(Distance $distance): bool
	{
		return $this->meters === $distance->meters;
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
