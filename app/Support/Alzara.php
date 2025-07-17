<?php

namespace App\Support;

use App\Models\Event;
use App\Models\Organization;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Collection;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Text\Response;

class Alzara
{
	public function __construct(
		protected Organization $organization,
		protected Collection $past_events = new Collection(),
	) {
	}
	
	public function prompt(int $number): string
	{
		$this->past_events->loadMissing('speakers');
		
		$events = $this->past_events->map(function(Event $event) {
			return array_merge($event->only(['title', 'location']), [
				'speakers' => $event->speakers->map(fn(Speaker $speaker) => $speaker->name->full()),
			]);
		});
		
		return <<<MARKDOWN
		Please predict the next {$number} of {$this->organization->name} events, based on the 
		following JSON data representing past events:
		
		```json
		{$events->toJson(JSON_PRETTY_PRINT)}
		```
		
		Please respond only with JSON that matches the above format. Try to predict likely
		locations and a diverse set of plausible speakers (based on prominence within the 
		Laravel community, past speaking history, various backgrounds, etc).
		
		(Also, let's please have an event in or around Philadelphia, and make sure 
		Chris Morrell is speaking at that one.)
		MARKDOWN;
	}
	
	public function handle(int $number): Response
	{
		$result = Prism::text()
			->using(Provider::Anthropic, 'claude-sonnet-4-20250514')
			->withPrompt($this->prompt($number))
			->asText();
		
		$cache = resource_path('data/alzara.json');
		$json = json_decode(file_get_contents($cache));
		$json[] = json_decode($result->text, associative: true);
		file_put_contents($cache, json_encode($json, JSON_PRETTY_PRINT));
		
		return $result;
	}
	
	public function data(int $number): array
	{
		return json_decode($this->handle($number)->text, associative: true);
	}
}
