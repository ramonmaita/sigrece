<?php

use App\Http\Controllers\Coordinador\SeccionesController;
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
	});

	// Route::prefix('inscripciones')->name('inscripciones.')->group(function () {
	// 	// Route::view('/', 'panel.docentes.secciones.index')->name('index');
	// 	Route::prefix('regulares')->name('regulares.')->group(function () {
	// 		Route::get('/', [InscripcionesController::class,'uc_incribir_regulares'])->name('index')->middleware(['role:Estudiante']);
	// 		Route::post('/guardar', [InscripcionesController::class,'store'])->name('store')->middleware(['role:Estudiante']);
	// 	});

	// 	Route::prefix('nuevo-ingreso')->name('nuevo-ingreso.')->group(function () {
	// 		// Route::get('/', [InscripcionesController::class,'uc_inscribir_nuevos'])->name('index')->middleware(['role:Estudiante']);
	// 		Route::get('/secciones', [InscripcionesController::class,'secciones_nuevos'])->name('index')->middleware(['role:Estudiante']);
	// 		Route::post('/guardar', [InscripcionesController::class,'guardar'])->name('guardar')->middleware(['role:Estudiante']);
	// 		Route::post('/seleccionar-seccion', [InscripcionesController::class,'seleccionar_seccion'])->name('seleccionar-seccion')->middleware(['role:Estudiante']);

	// 	});
	// });

	// Route::prefix('documentos')->name('documentos.')->group(function () {
	// 	Route::view('/', 'panel.estudiantes.documentos.index')->name('index');
	// 	Route::get('comprobante/', [ComprobanteController::class,'pdf'])->name('comprobante.pdf')->middleware(['role:Estudiante']);
	// 	Route::get('constancia/', [ConstanciaController::class,'pdf'])->name('constancia.pdf')->middleware(['role:Estudiante']);
	// 	Route::get('notas/', [NotasController::class,'pdf'])->name('notas.pdf')->middleware(['role:Estudiante']);
	// });



});
