<x-step :step="1">
	
	<div class="space-y-4">
		@foreach($orgs as $org)
			
			<h1 class="font-semibold text-gray-500">
				{{ $org->name }}
			</h1>
			
			<div class="overflow-x-auto shadow ring-1 ring-black/5 sm:rounded-lg">
				<table class="min-w-full divide-y divide-gray-300">
					<thead class="bg-gray-50">
						<tr>
							<th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Event</th>
							<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Speakers</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">
						@foreach($org->events as $event)
							<tr>
								<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
									{{ $event->title }}
								</td>
								<td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
									@if($event->speakers?->count())
										<div class="flex -space-x-1 overflow-hidden">
											@foreach($event->speakers as $speaker)
												<img
													src="{{ $speaker->avatar() }}"
													title="{{ $speaker->name }}"
													alt="{{ $speaker->name }}"
													class="inline-block size-8 rounded-full ring-2 ring-white"
												/>
											@endforeach
										</div>
									@else
										<code>
											{{ $event->speaker_ids }}
										</code>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@endforeach
	</div>

</x-step>
