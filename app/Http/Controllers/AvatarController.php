<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Throwable;

class AvatarController extends Controller
{
	protected const array GRADIENTS = [
		['#1CB5E0', '#000851'],
		['#FC466B', '#3F5EFB'],
		['#4b6cb7', '#182848'],
		['#9ebd13', '#008552'],
		['#d53369', '#daae51'],
		['#00d2ff', '#3a47d5'],
		['#fcff9e', '#c67700'],
	];
	
	public function __invoke(Request $request)
	{
		$initials = $request->input('initials', '');
		[$left, $right] = $this->gradient($initials);
		
		$svg = <<<SVG
		<svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
			<g>
				<defs>
					<linearGradient id="gradient" x1="0" y1="0" x2="1" y2="1">
						<stop offset="0%" stop-color="{$left}"></stop>
						<stop offset="100%" stop-color="{$right}"></stop>
					</linearGradient>
				</defs>
				<rect fill="url(#gradient)" x="0" y="0" width="120" height="120" rx="0" ry="0"></rect>
				<text x="50%" y="50%" alignment-baseline="central" dominant-baseline="central" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="54">
					{$initials}
				</text>
			</g>
		</svg>
		SVG;
		
		return response($svg)->header('content-type', 'image/svg+xml');
	}
	
	protected function gradient(string $initials): array
	{
		srand(crc32($initials)); // Always generate the same gradient for the same initials
		
		return self::GRADIENTS[rand(0, count(self::GRADIENTS) - 1)];
	}
}
