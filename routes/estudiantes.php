<?php

use App\Http\Controllers\Alumno\ComprobanteController;
use App\Http\Controllers\Alumno\InscripcionesController;
use App\Http\Controllers\Alumno\NotasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Docente\SeccionesController;
use App\Http\Controllers\Docente\SolicitudesController;

Route::prefix('panel/estudiante')->name('panel.estudiante.')->group(function () {

	Route::view('/', 'panel.estudiantes.index')->name('index');

	Route::prefix('inscripciones')->name('inscripciones.')->group(function () {
		// Route::view('/', 'panel.docentes.secciones.index')->name('index');
		Route::prefix('regulares')->name('regulares.')->group(function () {
			Route::get('/', [InscripcionesController::class,'uc_incribir_regulares'])->name('index')->middleware(['role:Estudiante']);
			Route::post('/guardar', [InscripcionesController::class,'store'])->name('store')->middleware(['role:Estudiante']);
		});
	});

	Route::prefix('documentos')->name('documentos.')->group(function () {
		Route::view('/', 'panel.estudiantes.documentos.index')->name('index');
		Route::get('comprobante/', [ComprobanteController::class,'pdf'])->name('comprobante.pdf')->middleware(['role:Estudiante']);
		Route::get('notas/', [NotasController::class,'pdf'])->name('notas.pdf')->middleware(['role:Estudiante']);
	});



});
