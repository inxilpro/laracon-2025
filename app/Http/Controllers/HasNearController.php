<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Throwable;

class HasNearController extends Controller
{
	public function __invoke()
	{
		try {
			
			$events = Organization::firstWhere('name', 'Laracon US')
				->events()
				->get();
			
			$events->loadMissing('coffee_shops');
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.3', [
			'events' => $events,
		]);
	}
}
