<x-guest-layout>
    {{-- <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot> --}}
    {{-- <x-jet-validation-errors class="mb-4" /> --}}
    @php
        $actual = \Carbon\Carbon::now();
        $inicio_a = \Carbon\Carbon::create(2021, 9, 27, 10, 00, 00);
        $fin_a = \Carbon\Carbon::create(2021, 10, 15, 23, 59, 00);
        // $fin = \Carbon\Carbon::create(2021, 4, 25, 23, 59, 00);
        $inicio_f = \Carbon\Carbon::create(2021, 9, 29, 23, 59, 00);
        $fin_f = \Carbon\Carbon::create(2021, 10, 15, 23, 59, 00);
    @endphp
    <div class="flex flex-col items-center min-h-full pt-6 bg-gray-100 sm:justify-center sm:pt-0">
        <div class="w-11/12 pt-8">
            @include('alertas')
        </div>

        <div class="py-3">
            {{-- <h3 class="text-2xl tracking-widest text-center ">FEATURES</h3> --}}
            <h1 class="mt-1 text-5xl font-bold text-center ">Atención Estudiante.</h1>
            <h6 class="mt-2 text-lg tracking-widest text-center ">Selecciona una de las siguentes opciones para contituar
                con el proceso correspondiente.</h6>

            <!-- Box -->
            <div class="md:flex md:justify-center md:space-x-6 md:px-14">
                <!-- box-1 -->
                <div
                    class="px-4 py-4 mx-auto mt-16 transition duration-500 transform bg-white shadow-lg bg-whit w-72 rounded-xl hover:shadow-xl hover:scale-110 md:mx-0">
                    <div class="w-sm">
                        <img class="w-64 h-64" src="{{ asset('img/web/estudiante_asignado.png') }}" alt="" />
                        <div class="mt-4 text-center ">
                            <h1 class="text-xl font-bold">Asignado OPSU</h1>
                            <p class="mt-4 mb-2 text-justify text-gray-600">Si fuiste asignado por el Sistema Nacional
                                de
                                Ingreso de la Oficina de Planificación del Sector Universitario <b>OPSU</b> para cursar
                                estudios en la Universidad Politécnica Territorial del Estado Bolívar haz click en el
                                siguiente boton.</p>
                            @if ($actual->greaterThanOrEqualTo($inicio_a) == true && $actual->lessThanOrEqualTo($fin_a) == true || Auth::user()->hasRole('Admin'))
                                <a href="{{ route('nuevo-ingreso.asignados.index') }}" role="button" type="button"
                                    class="py-2 mt-10 mb-4 tracking-widest text-white transition duration-200 bg-gray-900 rounded-full px-14 hover:bg-gray-800">Ir</a>
							@else
									<button role="button" type="button" disabled
										class="py-2 mt-10 mb-4 tracking-widest text-white transition duration-200 bg-gray-600 rounded-full px-14 hover:bg-gray-800">Ir</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- box-2 -->
                <div
                    class="px-4 py-4 mx-auto mt-16 transition duration-500 transform bg-white shadow-lg bg-whit w-72 rounded-xl hover:shadow-xl hover:scale-110 md:mx-0">
                    <div class="w-sm">
                        <img class="w-64 h-64" src="{{ asset('img/web/estudiante_flotante.png') }}" alt="" />
                        <div class="mt-4 text-center ">
                            <h1 class="text-xl font-bold capitalize">Otras oportunidades de estudio</h1>
                            <p class="mt-4 mb-2 text-justify text-gray-600">Si eres egresado en años anteriores o en el
                                actual y quieres cursar estudios en la Universidad Politécnica Territorial del Estado
                                Bolívar haz click en el siguiente boton.</p>
                            @if ($actual->greaterThanOrEqualTo($inicio_f) == true && $actual->lessThanOrEqualTo($fin_f) == true || Auth::user()->hasRole('Admin'))
                                <a href="{{ route('nuevo-ingreso.flotante.index') }}" role="button" type="button"
                                    class="py-2 mt-10 mb-4 tracking-widest text-white transition duration-200 bg-gray-900 rounded-full px-14 hover:bg-gray-800">Ir</a>
                            @else
                                <button role="button" type="button" disabled
                                    class="py-2 mt-10 mb-4 tracking-widest text-white transition duration-200 bg-gray-600 rounded-full px-14 hover:bg-gray-800">Ir</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- box-3 -->
                <div
                    class="px-4 py-4 mx-auto mt-16 transition duration-500 transform bg-white shadow-lg bg-whit w-72 rounded-xl hover:shadow-xl hover:scale-110 md:mx-0">
                    <div class="w-sm">
                        <img class="w-64 h-64" src="{{ asset('img/web/estudiante_registrado.png') }}" alt="" />
                        <div class="mt-4 text-center ">
                            <h1 class="text-xl font-bold">Estudiante Registrado</h1>
                            <p class="mt-4 text-justify text-gray-600 mb-7">Si eres estudiante de la Universidad
                                Politécnica Territorial del Estado Bolívar y no aprobaste el
                                trayecto inicial debes actualizar tu información y acceder al panel para realizar tu
                                inscripción.</p>
                            @if ($actual->greaterThanOrEqualTo($inicio_f) == true && $actual->lessThanOrEqualTo($fin_f) == true || Auth::user()->hasRole('Admin'))
                                <a href="{{ route('login') }}" role="button" type="button"
                                    class="py-2 mt-12 mb-4 tracking-widest text-white transition duration-200 bg-gray-900 rounded-full px-14 hover:bg-gray-800">Ir</a>
                            @else
                                <button role="button" type="button" disabled
                                    class="py-2 mt-12 mb-4 tracking-widest text-white transition duration-200 bg-gray-600 rounded-full px-14 hover:bg-gray-800">Ir</button>

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-guest-layout>
