@props(['step' => 1])
<x-layout>
	<x-nav :step="$step" />
	<main class="p-8">
		@isset($exception)
			<iframe
				class="w-full border-2 border-red-500 rounded-xl shadow-xl h-[70vh]"
				srcdoc="{{ $exception }}"
			></iframe>
		@endisset
		{{ $slot }}
	</main>
</x-layout>
