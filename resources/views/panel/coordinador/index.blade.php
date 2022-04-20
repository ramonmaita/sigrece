<x-app-layout>
    <x-slot name="header">
    	<div class="grid grid-cols-2 md:grid-cols-2">

	        <h2 class="text-xl font-semibold leading-tight text-gray-800">
	            {{ __('Inicio') }}
	        </h2>

	        <x-breadcrumb>

			    <li>
			      <a href="#" class="text-gray-500" aria-current="page">Inicio</a>
			    </li>
	        </x-breadcrumb>

    	</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-1">
				    {{-- <div class="p-6">
				       <table id="example" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
							<thead>
								<tr>
									<th data-priority="1">Sección</th>
									<th data-priority="2">Unidad Curricular</th>
									<th data-priority="3">Trimeste|Semestre|Año</th>
									<th data-priority="4">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Tiger Nixon</td>
									<td>System Architect</td>
									<td>Edinburgh</td>
									<td>61</td>

								</tr>

								<tr>
									<td>Donna Snider</td>
									<td>Customer Support</td>
									<td>New York</td>
									<td>27</td>

								</tr>
							</tbody>

						</table>
				    </div> --}}

					<div class="p-10">
						<h4 class="text-lg font-semibold leading-tight">
							Bienvenido(a) {{ Auth::user()->nombre }} {{ Auth::user()->apellido }} Jefe(a) Del PNF en  {{ Auth::user()->Coordinador->Pnf->nombre }}
						</h4>
					</div>
				</div>
            </div>
        </div>
    </div>
</x-app-layout>
