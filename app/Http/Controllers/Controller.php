<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Exceptions\Renderer\Renderer;
use Illuminate\Support\Facades\View;
use Throwable;

abstract class Controller
{
	protected function shareExceptionForDemo(Throwable $e)
	{
		View::share(
			'exception',
			app(Renderer::class)->render(request(), $e)
		);
	}
}
