<?php

use App\Models\Organization;
use Illuminate\Foundation\Exceptions\Renderer\Renderer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

Route::redirect('/', '/demo/1');

Route::get('/demo/1', function() {
	// try {
	// 	$orgs = Organization::query()
	// 		->with('events.speakers')
	// 		->get();
	//	
	// 	// throw new RuntimeException('Boo!');
	// } catch (Throwable $e) {
	// 	View::share(
	// 		'exception',
	// 		new HtmlString(app(Renderer::class)->render(request(), $e))
	// 	);
	// }
	
	return view('demos.1', [
		'orgs' => demo(fn() => Organization::query()
			->with('events.speakers')
			->get()),
	]);
});

/**
 * @template TResult
 * @param \Closure(): TResult $cb
 * @return TResult 
 */
function demo(Closure $cb)
{
	try {
		return $cb();
	} catch (Throwable $e) {
		View::share(
			'exception',
			new HtmlString(app(Renderer::class)->render(request(), $e))
		);
	}
	
	return null;
}
