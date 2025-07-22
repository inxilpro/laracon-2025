<x-step :step="4">
	<main
		class="p-8 flex-1 flex flex-col"
		x-data="{
			history: ['/orgs'],
			history_index: 0,
			get view() {
				return this.history[this.history_index];
			},
			goto(key) {
				if (this.history_index !== this.history.length - 1) {
					this.history = this.history.slice(0, this.history_index);
				}
				this.history.push(key);
				this.history_index = this.history.length - 1;
			},
			back() {
				this.history_index = Math.max(0, this.history_index - 1);
			},
			forward() {
				this.history_index = Math.min(this.history.length - 1, this.history_index + 1);
			}
		}"
	>
		<div class="border-2 border-gray-300 shadow-md rounded-lg flex-1">
			<div class="flex gap-1 items-center border-b border-gray-200 py-2 px-4">
				<svg class="size-3 fill-red-500" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
					<circle cx="50" cy="50" r="50" />
				</svg>
				<svg class="size-3 fill-yellow-300" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
					<circle cx="50" cy="50" r="50" />
				</svg>
				<svg class="size-3 fill-green-500" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
					<circle cx="50" cy="50" r="50" />
				</svg>
				<span class="w-6"></span>
				<button
					class="px-2 py-1 rounded hover:bg-gray-100"
					@click="back()"
				>
					<svg class="size-4 fill-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
						<path d="M169.4 297.4C156.9 309.9 156.9 330.2 169.4 342.7L361.4 534.7C373.9 547.2 394.2 547.2 406.7 534.7C419.2 522.2 419.2 501.9 406.7 489.4L237.3 320L406.6 150.6C419.1 138.1 419.1 117.8 406.6 105.3C394.1 92.8 373.8 92.8 361.3 105.3L169.3 297.3z" />
					</svg>
				</button>
				<button
					class="px-2 py-1 rounded hover:bg-gray-100"
					@click="forward()"
				>
					<svg class="size-4 fill-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
						<path d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z" />
					</svg>
				</button>
				<span class="w-6"></span>
				<div
					class="border border-gray-300 text-gray-400 text-xs rounded p-1 flex-1"
					x-text="`https://my-cool-demo.test${ view }`"
				>
					https://my-cool-demo.test/
				</div>
				<button
					class="px-2 py-1 rounded hover:bg-gray-100"
					@click="goto('/orgs')"
				>
					<svg class="size-4 fill-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
						<path d="M341.8 72.6C329.5 61.2 310.5 61.2 298.3 72.6L74.3 280.6C64.7 289.6 61.5 303.5 66.3 315.7C71.1 327.9 82.8 336 96 336L112 336L112 512C112 547.3 140.7 576 176 576L464 576C499.3 576 528 547.3 528 512L528 336L544 336C557.2 336 569 327.9 573.8 315.7C578.6 303.5 575.4 289.5 565.8 280.6L341.8 72.6zM304 384L336 384C362.5 384 384 405.5 384 432L384 528L256 528L256 432C256 405.5 277.5 384 304 384z" />
					</svg>
				</button>
				<span class="w-6"></span>
			</div>
			
			<div class="p-4">
				
				{{-- Orgs index --}}
				<div x-show="'/orgs' === view">
					<div class="border-b border-gray-200 pb-2">
						<h3 class="text-base font-semibold text-gray-900">Organizations</h3>
					</div>
					
					<ul role="list" class="mt-3 grid grid-cols-2 gap-6 lg:grid-cols-4">
						@foreach($orgs as $org)
							<li class="col-span-1 flex rounded-md shadow-xs">
								<div class="flex w-16 shrink-0 items-center justify-center rounded-l-md bg-gray-600 text-sm font-medium text-white">
									{{ str($org->name)->afterLast(' ') }}
								</div>
								<div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
									<div class="flex-1 truncate px-4 py-2 text-sm">
										<a
											href="/orgs/{{ $org->getKey() }}"
											@click.prevent="goto('/orgs/{{ $org->getKey() }}')"
											class="font-medium text-gray-900 hover:text-gray-600"
										>
											{{ $org->name }}
										</a>
										<p class="text-gray-500">
											{{ $org->teams?->count() ?? 0 }} {{ Str::plural('team', $org->teams?->count() ?? 0) }}
										</p>
									</div>
									<div class="shrink-0 pr-2">
										<button
											type="button"
											@click="goto('/orgs/{{ $org->getKey() }}')"
											class="inline-flex cursor-pointer size-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden"
										>
											<svg class="size-4 fill-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
												<path d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z" />
											</svg>
										</button>
									</div>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
				
				{{-- Org show page --}}
				@foreach($orgs as $org)
					<div x-show="'/orgs/{{ $org->getKey() }}' === view">
						<div class="border-b border-gray-200 pb-2">
							<h3 class="text-base font-semibold text-gray-900 flex items-center justify-between">
								{{ $org->name }}
								<button
									class="rounded-sm bg-pink-600/50 px-2 py-1 text-xs font-semibold text-white shadow-xs hover:bg-pink-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
									@click="goto('/orgs')"
								>
									Back
								</button>
							</h3>
						</div>
						
						@if($org->teams?->count())
							<ul role="list" class="mt-3 grid grid-cols-2 gap-6 lg:grid-cols-4">
								@foreach($org->teams as $index => $team)
									<li class="col-span-1 flex rounded-md shadow-xs">
										<div class="flex w-16 shrink-0 items-center justify-center rounded-l-md bg-gray-600 text-sm font-medium text-white">
											{{ $index + 1 }}
										</div>
										<div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
											<div class="flex-1 truncate px-4 py-2 text-sm">
												<a
													href="/orgs/{{ $org->getKey() }}/teams/{{ $index + 1 }}"
													@click.prevent="goto('/orgs/{{ $org->getKey() }}/teams/{{ $index + 1 }}')"
													class="font-medium text-gray-900 hover:text-gray-600"
												>
													{{ $team->name }}
												</a>
												<p class="text-gray-500">
													{{ $team->users?->count() ?? 0 }} {{ Str::plural('users', $team->users?->count() ?? 0) }}
												</p>
											</div>
											<div class="shrink-0 pr-2">
												<button
													type="button"
													@click="goto('/orgs/{{ $org->getKey() }}/teams/{{ $index + 1 }}')"
													class="inline-flex cursor-pointer size-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden"
												>
													<svg class="size-4 fill-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
														<path d="M471.1 297.4C483.6 309.9 483.6 330.2 471.1 342.7L279.1 534.7C266.6 547.2 246.3 547.2 233.8 534.7C221.3 522.2 221.3 501.9 233.8 489.4L403.2 320L233.9 150.6C221.4 138.1 221.4 117.8 233.9 105.3C246.4 92.8 266.7 92.8 279.2 105.3L471.2 297.3z" />
													</svg>
												</button>
											</div>
										</div>
									</li>
								@endforeach
							</ul>
						@else
							<p class="italic mt-4">
								No teams found.
							</p>
						@endif
					</div>
					
					{{-- Team show pages --}}
					@foreach($org->teams ?? [] as $index => $team)
						<div x-show="'/orgs/{{ $org->getKey() }}/teams/{{ $index + 1 }}' === view">
							<div class="border-b border-gray-200 pb-2">
								<h3 class="text-base font-semibold text-gray-900 flex items-center justify-between">
									{{ $team->name }}
									<button
										class="rounded-sm bg-pink-600/50 px-2 py-1 text-xs font-semibold text-white shadow-xs hover:bg-pink-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
										@click="goto('/orgs/{{ $org->getKey() }}')"
									>
										Back
									</button>
								</h3>
							</div>
							
							@if($team->users?->count())
								<div class="overflow-x-auto shadow ring-1 ring-black/5 sm:rounded-lg">
									<table class="min-w-full divide-y divide-gray-300">
										<thead class="bg-gray-50">
											<tr>
												<th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
													User
												</th>
												<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
													Office
												</th>
											</tr>
										</thead>
										<tbody class="divide-y divide-gray-200 bg-white">
											@foreach($team->users as $user)
												<tr>
													<td class="whitespace-nowrap py-4 pl-4 pr-3 text-base text-gray-900 sm:pl-6">
														{{ $user->name }}
													</td>
													<td class="whitespace-nowrap px-3 py-4 text-gray-400">
														{{ $user->location }}
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							@else
								<p class="italic mt-4">
									No users found.
								</p>
							@endif
						</div>
					@endforeach
				
				@endforeach
			
			</div>
		</div>
	</main>
</x-step>
