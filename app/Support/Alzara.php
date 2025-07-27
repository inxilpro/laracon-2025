<?php

namespace App\Support;

use App\Models\Event;
use App\Models\Organization;
use App\Models\Speaker;
use Illuminate\Database\Eloquent\Collection;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Text\Response;
use Throwable;

class Alzara
{
	public const bool LIVE = false;
	
	public function __construct(
		protected Organization $organization,
		protected ?Collection $past_events = null,
	) {
		$this->past_events ??= $this->organization->events;
	}
	
	public function prompt(int $number): string
	{
		return <<<MARKDOWN
		Please predict the next {$number} of {$this->organization->name} events, based on the 
		following JSON data representing past events:
		
		```json
		{$this->pastEventJson()}
		```
		
		Please respond only with JSON that matches the above format. Try to predict a
		diverse set of likely locations, and avoid predicting the same locations again.
		MARKDOWN;
	}
	
	public function handle(int $number): Response
	{
		return Prism::text()
			->using(Provider::Anthropic, 'claude-sonnet-4-20250514')
			->withPrompt(static::LIVE ? $this->seedPrompt($number) : $this->prompt($number))
			->asText();
	}
	
	public function data(int $number): array
	{
		try {
			$result = $this->handle($number);
			
			$json = preg_replace('(^```json|```$)', '', $result->text);
			$data = json_decode($json, associative: true, flags: JSON_THROW_ON_ERROR);
			
			if (static::LIVE) {
				$filename = resource_path('data/alzara.json');
				$cache = json_decode(file_get_contents($filename));
				$cache[] = $data;
				file_put_contents($filename, json_encode($cache, JSON_PRETTY_PRINT));
			}
		} catch (Throwable $exception) {
			if (static::LIVE) {
				dump($result ?? null, $exception);
			}
			throw $exception;
		}
		
		return $data;
	}
	
	protected function pastEventJson(): string
	{
		$this->past_events->loadMissing('speakers');
		
		$events = $this->past_events->map(function(Event $event) {
			return array_merge($event->only(['title', 'location']), [
				'speakers' => $event->speakers->map(fn(Speaker $speaker) => $speaker->name->full()),
			]);
		});
		
		return $events->toJson(JSON_PRETTY_PRINT);
	}
	
	protected function seedPrompt(int $number)
	{
		$past_predictions = file_get_contents(resource_path('data/alzara.json'));
		
		return <<<MARKDOWN
		Please predict the next {$number} of {$this->organization->name} events, based on the 
		following JSON data representing past events:
		
		```json
		{$this->pastEventJson()}
		```
		
		Here are past predictions:
		
		```
		{$past_predictions}
		```
		
		Please respond only with JSON that matches the above format. Try to predict a
		diverse set of likely locations, and avoid predicting the same locations again.
		MARKDOWN;
	}
}
