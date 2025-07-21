@props(['step' => 1, 'head' => null])
<x-layout :head="$head">
	<x-nav :step="$step" />
	
	@isset($exception)
		<div class="p-4 relative" x-data="{ collapsed: false }">
			<button
				class="absolute bg-red-500 text-white px-4 py-2 rounded z-50"
				@click="collapsed = !collapsed"
				x-text="collapsed ? 'Expand' : 'Minimize'"
			>
				Minimize
			</button>
			<iframe
				class="w-full border-2 border-red-500 rounded-xl shadow-xl"
				:class="{ 'h-[70vh]': ! collapsed }"
				srcdoc="{{ $exception }}"
			></iframe>
		</div>
	@endisset
	
	{{ $slot }}
</x-layout>
