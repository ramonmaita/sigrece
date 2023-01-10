<?php

use App\Http\Controllers\Coordinador\SeccionesController;
use App\Http\Controllers\Coordinador\SolicitudesController;
use Illuminate\Support\Facades\Route;


Route::prefix('panel/jefe-de-pnf')->name('panel.coordinador.')->group(function () {

	Route::view('/', 'panel.coordinador.index')->name('index');

	Route::get('/planificacion',[SeccionesController::class,'planificacion'])->name('planificacion')->middleware(['role:Coordinador']);

	Route::prefix('secciones')->name('secciones.')->group(function () {
		Route::get('/', [SeccionesController::class,'index'])->name('index')->middleware(['role:Coordinador']);
		Route::get('/{seccion}/ver-seccion', [SeccionesController::class,'show'])->name('show')->middleware(['role:Coordinador']);

		Route::get('/{relacion}/ver-uc', [SeccionesController::class,'show_uc'])->name('show_uc')->middleware(['role:Coordinador']);
		Route::get('/{relacion}/avance-de-notas', [SeccionesController::class,'avance'])->name('avance')->middleware(['role:Coordinador']);
		Route::get('/{relacion}/acta', [SeccionesController::class,'acta'])->name('acta')->middleware(['role:Coordinador']);
		Route::get('/{seccion}/{desasignatura}/listado-estudiantes', [SeccionesController::class,'lista_esudiantes'])->name('lista_esudiantes')->middleware(['role:Coordinador']);

		Route::get('configurar/{id}', [SeccionesController::class,'configurar'])->name('configurar')->middleware(['role_or_permission:Coordinador']);
		Route::post('configurar', [SeccionesController::class,'guardar_config'])->name('guardar_config')->middleware(['role_or_permission:Coordinador']);
		Route::post('actualizar-configuracion', [SeccionesController::class,'actualizar_config'])->name('actualizar_config')->middleware(['role_or_permission:Coordinador']);
		Route::get('editar-configuracion/{id}', [SeccionesController::class,'editar_config'])->name('editar_config')->middleware(['role_or_permission:Coordinador']);


	});

	Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
		Route::get('/', [SolicitudesController::class,'index'])->name('index')->middleware(['role:Coordinador']);
		Route::get('{solicitud}/ver',[SolicitudesController::class,'show'])->name('show')->middleware(['role:Coordinador']);
		Route::post('update', [SolicitudesController::class,'update'])->name('update')->middleware(['role:Coordinador']);
	});



});
