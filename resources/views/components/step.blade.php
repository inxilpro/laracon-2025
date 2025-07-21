@props(['step' => 1, 'head' => null])
<x-layout :head="$head">
	<x-nav :step="$step" />
	
	@isset($exception)
		<div class="p-4">
			<iframe
				class="w-full border-2 border-red-500 rounded-xl shadow-xl h-[70vh]"
				srcdoc="{{ $exception }}"
			></iframe>
		</div>
	@endisset
	
	{{ $slot }}
</x-layout>
