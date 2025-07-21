<x-step :step="3">
	<x-slot:head>
		@vite(['resources/js/map.js', 'node_modules/leaflet/dist/leaflet.css'])
	</x-slot:head>
	<div
		id="map"
		class="flex-1"
		data-map="{{ $events->toJson(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) }}"
	>
		Loading…
	</div>
</x-step>
