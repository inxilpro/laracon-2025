<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Throwable;

class HasSpeakersController extends Controller
{
	public function __invoke()
	{
		try {
			
			$orgs = Organization::query()
				->with('events')
				->get();
			
			$orgs->loadMissing('events.speakers');
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.1', [
			'orgs' => $orgs ?? [],
		]);
	}
}
