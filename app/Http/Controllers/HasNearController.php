<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Throwable;

class HasNearController extends Controller
{
	public function __invoke()
	{
		try {
			
			$events = Event::query()
				->with(['organization', 'cell_towers'])
				->get();
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.3', [
			'events' => $events ?? [],
		]);
	}
}
