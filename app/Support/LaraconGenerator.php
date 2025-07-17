<?php

namespace App\Support;

use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

class LaraconGenerator
{
	public function generate()
	{
		$response = Prism::text()
			->using(Provider::Anthropic, 'claude-3-5-sonnet-20241022')
			->withPrompt('Tell me a short story about a brave knight.')
			->asText();
	}
}
