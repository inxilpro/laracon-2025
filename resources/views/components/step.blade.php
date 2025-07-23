@props(['step' => 1, 'head' => null])
<x-layout :head="$head">
	<x-nav :step="$step" />
	
	@isset($exception)
		<div class="absolute right-2 top-2" style="z-index: 999" x-data="{ 
			collapsed: 'true' === localStorage.getItem('exception_collapsed'),
			toggle() {
				this.collapsed = ! this.collapsed;
				this.$dispatch('invalidatemapsize');
				localStorage.setItem('exception_collapsed', JSON.stringify(this.collapsed));
			}
		}">
			<button
				class="absolute top-0 right-0 bg-red-500/20 text-white px-2 py-1 rounded z-50 cursor-pointer"
				:class="{ 'rounded-tr-xl bg-red-500': ! collapsed, 'bg-red-500/20' : collapsed }"
				@click="toggle"
			>
				<svg
					class="size-6 fill-white"
					:class="{ hidden: ! collapsed }"
					xmlns="http://www.w3.org/2000/svg" 
					viewBox="0 0 640 640"
				>
					<path d="M272 112C272 85.5 293.5 64 320 64C346.5 64 368 85.5 368 112C368 138.5 346.5 160 320 160C293.5 160 272 138.5 272 112zM224 256C224 238.3 238.3 224 256 224L320 224C337.7 224 352 238.3 352 256L352 512L384 512C401.7 512 416 526.3 416 544C416 561.7 401.7 576 384 576L256 576C238.3 576 224 561.7 224 544C224 526.3 238.3 512 256 512L288 512L288 288L256 288C238.3 288 224 273.7 224 256z" />
				</svg>
				<svg 
					class="size-6 fill-white hidden"
					:class="{ hidden: collapsed }"
					xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
				>
					<path d="M352 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l50.7 0L297.4 169.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3l0 50.7c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128c0-17.7-14.3-32-32-32L352 0zM214.6 297.4c-12.5-12.5-32.8-12.5-45.3 0L64 402.7 64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32L0 480c0 17.7 14.3 32 32 32l128 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-50.7 0L214.6 342.6c12.5-12.5 12.5-32.8 0-45.3z" />
				</svg>
			</button>
			<iframe
				class="border-2 z-40 border-red-500 rounded-xl shadow-xl transform transition-all opacity-0"
				:class="{ 'h-[90vh] w-[90vw] opacity-100': ! collapsed }"
				srcdoc="{{ $exception }}"
			></iframe>
		</div>
	@endisset
	
	{{ $slot }}
</x-layout>
