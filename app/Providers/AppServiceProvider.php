<?php

namespace App\Providers;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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
		
		Prism::fake(array_map(
			fn($data) => TextResponseFake::make()->withText(json_encode($data, JSON_PRETTY_PRINT)),
			json_decode(file_get_contents(resource_path('data/alzara.json')), associative: true, flags: JSON_THROW_ON_ERROR)
		));
	}
}
