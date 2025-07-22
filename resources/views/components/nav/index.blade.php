@props(['step' => 1])
<header class="bg-gray-50 p-4 border-b border-gray-200 z-50">
	<ul class="flex items-center justify-center gap-4">
		<x-nav.step step="1" :active-step="$step" label="Speakers" />
		<x-nav.step step="2" :active-step="$step" label="Near" />
		<x-nav.step step="3" :active-step="$step" label="Letters" />
		<x-nav.step step="4" :active-step="$step" label="Faker" />
		<x-nav.step step="5" :active-step="$step" label="PredictedEvents" />
	</ul>
</header>
