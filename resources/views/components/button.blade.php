@props(['color','intensidad'])

<button {{ $attributes->merge([ 'class' => "text-center items-center px-4 py-2 bg-$color-$intensidad border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-$color-".($intensidad-100)." active:bg-$color-".($intensidad+100)." focus:outline-none focus:border-$color-".($intensidad+100)." focus:shadow-outline-$color disabled:opacity-25 transition ease-in-out duration-150"]) }}>
    {{ $slot }}
</button>
