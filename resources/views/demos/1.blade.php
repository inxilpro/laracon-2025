<x-step :step="1">
	@isset($orgs)
		<pre>{{ $orgs->toJson(JSON_PRETTY_PRINT) }}</pre>
	@endisset
</x-step>
