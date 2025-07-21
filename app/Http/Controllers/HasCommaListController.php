<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Throwable;

class HasCommaListController extends Controller
{
	public function __invoke()
	{
		try {
			
			$orgs = Organization::query()
				->with('events.speakers')
				->get();
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.2', [
			'orgs' => $orgs ?? [],
		]);
	}
}
