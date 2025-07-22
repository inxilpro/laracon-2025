<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Speaker;
use Throwable;

class HasLettersController extends Controller
{
	public function __invoke()
	{
		try {
			
			$speakers = Speaker::all();
			$speakers->loadMissing('letters');
			
		} catch (Throwable $exception) {
			$this->shareExceptionForDemo($exception);
		}
		
		return view('demos.4', [
			'speakers' => $speakers ?? [],
		]);
	}
}
