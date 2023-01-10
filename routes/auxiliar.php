<?php

use App\Http\Controllers\Auxiliar\NuevoIngresoController;
use Illuminate\Support\Facades\Route;

Route::prefix('panel/auxiliar')->name('panel.auxiliar.')->group(function () {
	Route::view('/', 'panel.auxiliar.index')->name('index');

	Route::prefix('inscripciones')->name('inscripciones.')->group(function () {

		Route::prefix('nuevo-ingreso')->name('nuevo-ingreso.')->group(function () {
			Route::get('/', [NuevoIngresoController::class,'index_search_alumno'])->name('index_alumno');
			Route::post('/buscar', [NuevoIngresoController::class, 'buscar_alumno'])->name('buscar_alumno');
			Route::get('uc-a-inscribir/{id_encriptado}', [NuevoIngresoController::class, 'uc_inscribir'])->name('uc_a_inscribir');
			Route::post('/inscribir', [NuevoIngresoController::class, 'store'])->name('store');

			Route::prefix('asignados')->name('asignados.')->group(function () {
				Route::get('/', [NuevoIngresoController::class,'index_asignado'])->name('index_asignado');
				Route::post('/buscar', [NuevoIngresoController::class, 'search_asignado'])->name('buscar');
				Route::get('/{id_encriptado}', [NuevoIngresoController::class, 'show_form_asignado'])->name('show-form');
			});
			Route::prefix('otras-oportunidades-de-estudio')->name('flotante.')->group(function () {
				Route::get('/', [NuevoIngresoController::class,'index_flotante'])->name('index_flotante');
			});
		});
	});
});
