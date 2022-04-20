<div>
    <div class="mb-3 -m-2 text-center ">
		@if (session('success'))
			<div class="p-2">
				<div class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-green-600 bg-white rounded-full shadow text-teal">
					<span class="inline-flex items-center justify-center h-6 px-3 text-white bg-green-600 rounded-full">Exito</span>
					<span class="inline-flex px-2"> {{ session('success') }}</span>
				</div>
			</div>
		@endif

		@if (session('error'))
			<div class="p-2">
				<div class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-red-600 bg-white rounded-full shadow text-teal">
					<span class="inline-flex items-center justify-center h-6 px-3 text-white bg-red-600 rounded-full">Error</span>
					<span class="inline-flex px-2">{!! session('error') !!} </span>
				</div>
			</div>
		@endif
	</div>
</div>
