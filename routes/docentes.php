<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Docente\SeccionesController;
use App\Http\Controllers\Docente\SolicitudesController;

Route::prefix('panel/docente')->name('panel.docente.')->group(function () {

	Route::view('/', 'panel.docentes.index')->name('index');

	Route::prefix('secciones-asignadas')->name('secciones.')->group(function () {
    	// Route::view('/', 'panel.docentes.secciones.index')->name('index');
    	Route::get('/', [SeccionesController::class,'index'])->name('index')->middleware(['role:Docente']);
    	Route::get('cargar-nota/{seccion}/{cod_desasignatura}', [SeccionesController::class,'cargar_notas'])->name('cargar-nota')->middleware(['role:Docente']);
		Route::post('guardar-nota/{seccion}', [SeccionesController::class,'guardar_nota'])->name('guardar-nota')->middleware(['role:Docente']);;
    	Route::get('acta-de-califiaciones/{seccion}', [SeccionesController::class,'acta'])->name('acta')->middleware(['role:Docente']);
	});

	Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
    	// Route::view('/', 'panel.docentes.secciones.index')->name('index');

    	Route::get('/', [SolicitudesController::class,'index'])->name('index')->middleware(['role:Docente']);
    	Route::get('/nueva-solicitud', [SolicitudesController::class,'create'])->name('create')->middleware(['role:Docente']);
    	Route::get('/pdf/{solicitud}', [SolicitudesController::class,'pdf'])->name('pdf')->middleware(['role:Docente']);

	});


});
