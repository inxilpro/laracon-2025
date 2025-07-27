<?php

namespace App\Providers;

use App\Support\Alzara;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Prism\Prism\Prism;
use Prism\Prism\Testing\TextResponseFake;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		Model::unguard();
		
		if (! Alzara::LIVE) {
			$fakes = array_map(
				fn($data) => TextResponseFake::make()->withText(json_encode($data, JSON_PRETTY_PRINT)),
				json_decode(file_get_contents(resource_path('data/alzara.json')), associative: true, flags: JSON_THROW_ON_ERROR)
			);
			
			shuffle($fakes);
			
			Prism::fake($fakes);
		}
	}
}
