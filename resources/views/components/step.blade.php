@props(['step' => 1, 'head' => null])
<x-layout :head="$head">
	<x-nav :step="$step" />
	
	@isset($exception)
		<div class="p-4 relative" x-data="{ 
			collapsed: 'true' === localStorage.getItem('exception_collapsed'),
			toggle() {
				this.collapsed = ! this.collapsed;
				this.$dispatch('invalidatemapsize');
				localStorage.setItem('exception_collapsed', JSON.stringify(this.collapsed));
			}
		}">
			<button
				class="absolute bg-red-500 text-white px-4 py-2 rounded rounded-tl-xl z-50 cursor-pointer"
				@click="toggle"
			>
				<svg 
					class="size-6 fill-white" 
					:class="{ hidden: collapsed }"
					xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
				>
					<path d="M502.6 54.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L336 130.7 336 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 128c0 17.7 14.3 32 32 32l128 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-50.7 0L502.6 54.6zM80 272c-17.7 0-32 14.3-32 32s14.3 32 32 32l50.7 0L9.4 457.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L176 381.3l0 50.7c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128c0-17.7-14.3-32-32-32L80 272z" />
				</svg>
				<svg 
					class="size-6 fill-white hidden"
					:class="{ hidden: ! collapsed }"
					xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
				>
					<path d="M352 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l50.7 0L297.4 169.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3l0 50.7c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128c0-17.7-14.3-32-32-32L352 0zM214.6 297.4c-12.5-12.5-32.8-12.5-45.3 0L64 402.7 64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32L0 480c0 17.7 14.3 32 32 32l128 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-50.7 0L214.6 342.6c12.5-12.5 12.5-32.8 0-45.3z" />
				</svg>
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
