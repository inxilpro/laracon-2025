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
			
			$events->loadMissing('ice_cream_shops');
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.has-near', [
			'events' => $events,
		]);
	}
}
