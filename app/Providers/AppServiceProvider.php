<?php

namespace App\Providers;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
	}
	
	public function boot(): void
	{
		Model::unguard();
		
		DB::macro('sphericalDistance', function(Expression|string $from, Expression|string $to) {
			$grammar = $this->getQueryGrammar();
			
			$from = $from instanceof Expression ? $from->getValue($grammar) : $grammar->wrapTable($from);
			$to = $to instanceof Expression ? $to->getValue($grammar) : $grammar->wrapTable($to);
			
			return "st_distance_sphere({$from},{$to})";
		});
	}
}
