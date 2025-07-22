<x-step :step="3">
	<main class="p-8">
		<div class="overflow-x-auto shadow ring-1 ring-black/5 sm:rounded-lg">
			<table class="min-w-full divide-y divide-gray-300">
				<thead class="bg-gray-50">
					<tr>
						<th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Speaker</th>
						<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Letters</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 bg-white">
					@foreach($speakers as $speaker)
						<tr>
							<td class="whitespace-nowrap py-4 pl-4 pr-3 text-xl font-slant text-gray-900 sm:pl-6">
								{{ $speaker->name->full() }}
							</td>
							<td class="whitespace-nowrap px-3 py-4">
								@if($speaker->letters?->count())
									<div class="flex -space-x-1 overflow-hidden">
										@foreach($speaker->letters as $letter)
											<div class="inline-flex font-slant text-2xl items-center justify-center size-8 rounded-full bg-gray-100 text-gray-900/60 ring-2 ring-white">
												{{ $letter->value }}
											</div>
										@endforeach
									</div>
								@else
									<code>
										Call to undefined relationship [letters] on model [App\Models\Speaker].
									</code>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</main>
</x-step>
