<?php

namespace App\Database;

use App\Models\Letter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

class HasLetters extends SimplifiedManyRelation
{
	public function __construct(
		Model $parent,
		protected string $attribute,
	) {
		parent::__construct($parent, new Letter());
	}
	
	public function addEagerConstraints(array $models): void
	{
		//
	}
	
	public function getEager()
	{
		return Collection::range('A', 'Z');
	}
	
	public function match(array $models, EloquentCollection $results, $relation): array
	{
		foreach ($models as $parent) {
			$collection = $parent->getRelation($relation);
			
			foreach ($results as $letter) {
				if (false !== stripos($parent->getAttribute($this->attribute), $letter)) {
					$collection->push($letter);
				}
			}
		}
		
		return $models;
	}
}
