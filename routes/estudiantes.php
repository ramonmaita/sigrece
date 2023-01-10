<?php

use App\Http\Controllers\Alumno\ComprobanteController;
use App\Http\Controllers\Alumno\InscripcionesController;
use App\Http\Controllers\Alumno\NotasController;
use App\Http\Controllers\Alumno\ConstanciaController;
use App\Http\Controllers\Alumno\RetirosController;
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

		Route::prefix('nuevo-ingreso')->name('nuevo-ingreso.')->group(function () {
			// Route::get('/', [InscripcionesController::class,'uc_inscribir_nuevos'])->name('index')->middleware(['role:Estudiante']);
			Route::get('/secciones', [InscripcionesController::class,'secciones_nuevos'])->name('index')->middleware(['role:Estudiante']);
			Route::post('/guardar', [InscripcionesController::class,'guardar'])->name('guardar')->middleware(['role:Estudiante']);
			Route::post('/seleccionar-seccion', [InscripcionesController::class,'seleccionar_seccion'])->name('seleccionar-seccion')->middleware(['role:Estudiante']);

		});
	});

	Route::prefix('documentos')->name('documentos.')->group(function () {
		Route::view('/', 'panel.estudiantes.documentos.index')->name('index');
		Route::get('comprobante/', [ComprobanteController::class,'pdf'])->name('comprobante.pdf')->middleware(['role:Estudiante']);
		Route::get('constancia/', [ConstanciaController::class,'pdf'])->name('constancia.pdf')->middleware(['role:Estudiante']);
		Route::get('notas/', [NotasController::class,'pdf'])->name('notas.pdf')->middleware(['role:Estudiante']);
	});

	Route::prefix('retiro-de-uc-inscritas')->name('retiros.')->group(function () {
		Route::get('/',[RetirosController::class, 'index'])->middleware(['role_or_permission:Estudiante'])->name('index');
		Route::get('/nueva-solicitud',[RetirosController::class, 'create'])->middleware(['role_or_permission:Estudiante'])->name('create');
		Route::get('/{solicitud}',[RetirosController::class, 'show'])->middleware(['role_or_permission:Estudiante'])->name('show');
		Route::get('pdf/{alumno}',[RetirosController::class, 'pdf'])->middleware(['role_or_permission:Estudiante'])->name('pdf');
		Route::get('show-pdf',[RetirosController::class, 'show_pdf'])->middleware(['role_or_permission:Estudiante'])->name('show-pdf');
		// Route::get('/', [SolicitudesController::class, 'index'])->middleware(['role_or_permission:Estudiante'])->name('index');
	});



});
