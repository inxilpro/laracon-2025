<?php

namespace Feature;

use App\Database\HasFaker;
use App\Models\Organization;
use App\Support\Alzara;
use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class HasFakerTest extends TestCase
{
	public function test_it_generates_fake_data(): void
	{
		$parent = new HasFakerTestParentModel();
		$children = $parent->children;
		
		$this->assertCount(5, $children);
		dump($children->toArray());
	}
}

class HasFakerTestParentModel extends Model
{
	public function children()
	{
		return new HasFaker(
			parent: $this,
			related: new HasFakerTestChildModel(),
			min: random_int(2, 8),
			factory: fn(Faker $faker, $index) => [
				'id' => $index,
				'name' => $faker->name(),
				'email' => $faker->unique()->email(),
			],
		);
	}
}

class HasFakerTestChildModel extends Model
{
	
}
