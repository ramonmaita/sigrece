@if (session('mensaje'))
    <div class="callout callout-success">
        <h5>
            {{ session('mensaje') }}
        </h5>
    </div>
@endif
@if (session('error'))
    <div class="callout callout-danger">
        <h5>
            {{ session('error') }}
        </h5>
    </div>
@endif


{{-- alertas jeetstream --}}

<div class="mb-3 -m-2 text-center ">
@if (session('jet_mensaje'))
    <div class="p-2">
        <div class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-green-600 bg-white rounded-full shadow text-teal">
            <span class="inline-flex items-center justify-center h-6 px-3 text-white bg-green-600 rounded-full">Exito</span>
            <span class="inline-flex px-2"> {{ session('jet_mensaje') }}</span>
        </div>
    </div>
@endif

@if (session('jet_error'))
    <div class="p-2">
        <div class="inline-flex items-center w-1/2 p-2 text-sm leading-none text-red-600 bg-white rounded-full shadow text-teal">
            <span class="inline-flex items-center justify-center h-6 px-3 text-white bg-red-600 rounded-full">Error</span>
            <span class="inline-flex px-2">{!! session('jet_error') !!} </span>
        </div>
    </div>
@endif
</div>
