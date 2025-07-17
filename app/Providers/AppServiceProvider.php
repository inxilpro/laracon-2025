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
		
		// Prism::fake(array_map(fn($text) => TextResponseFake::make()->withText($text), $this->cachedResponses()));
	}
}
