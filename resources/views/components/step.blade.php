@props(['step' => 1])
<x-layout>
	<x-nav :step="$step" />
	@isset($exception)
		{{ $exception }}
	@endisset
	<main class="p-8">
		{{ $slot }}
	</main>
</x-layout>
