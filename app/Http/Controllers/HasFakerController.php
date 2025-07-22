<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Throwable;

class HasFakerController extends Controller
{
	public function __invoke()
	{
		try {
			
			$orgs = Organization::all();
			$orgs->loadMissing('teams');
			$orgs->each(fn(Organization $org) => $org->teams?->loadMissing('users'));
			
		} catch (Throwable) {
		}
		
		return view('demos.has-faker', [
			'orgs' => $orgs ?? [],
		]);
	}
}
