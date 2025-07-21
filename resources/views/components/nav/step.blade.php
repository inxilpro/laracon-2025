@props(['step' => 1, 'activeStep' => null, 'label' => ''])
<li class="flex items-center gap-2">
	<a 
		href="/demo/{{ $step }}" 
		@class([
			'size-12 flex items-center justify-center rounded-full text-lg',
			'bg-gray-200' => (int) $activeStep !== (int) $step,
			'bg-gray-500 text-white' => (int) $activeStep === (int) $step,
		])
	>
		{{ $step }}
	</a>
	@if((int) $activeStep === (int) $step)
		<div class="text-sm font-mono leading-3.5">
			<div class="opacity-50 text-xs -mt-1">Has</div>
			<div>{{ $label }}</div>
		</div>
	@endif
</li>
