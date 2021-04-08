<div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">

    @isset ($logo)
	    <div>
	        {{ $logo }}
	    </div>
    @endisset()

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-sm sm:max-w-7xl sm:rounded-lg hover:shadow-lg">
        {{ $slot }}
    </div>
</div>
