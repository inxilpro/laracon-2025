<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class HasPredictedEventsController extends Controller
{
	public function __invoke()
	{
		try {
			
			$events = Organization::firstWhere('name', 'Laracon US')->events;
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.has-predicted-events', [
			'events' => $events ?? new Collection(),
		]);
	}
}
