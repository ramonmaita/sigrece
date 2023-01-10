<?php

use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\VerificarDocumentosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('generar-usuarios', [UsuariosController::class,'generar_usuarios'])->name('generar');
Route::get('/preguntas-frecuentes', [PreguntasController::class, 'index'])->name('preguntas-frecuentes');

Route::middleware(['role_or_permission:faqs.create'])->group(function () {
	Route::resource('faqs', PreguntasController::class)->except([
		'index', 'show'
	]);
});


Route::get('register', function () {
	return redirect('/');
});
Route::get('/offline', function () {
	return view('vendor/laravelpwa/offline');
});

Route::get('/dashboard', function () {
	// return view('vendor/laravelpwa/offline');
})->name('dashboard');

Route::get('/cambiar-rol/{rol}', [WebController::class, 'cambiar_rol'])->name('cambiar-rol');

Route::get('/', function () {
	return view('auth.login');
})->name('raiz');

Route::prefix('actualizar-datos')->name('actualizar-datos.')->group(function () {
	Route::get('/', [WebController::class, 'index_estudiante_actualizar'])->name('index');
	Route::post('/buscar', [WebController::class, 'search_estudiante_actualizar'])->name('buscar');
	Route::get('/{id_encriptado}', [WebController::class, 'show_form_actualizar_estudiante'])->name('show-form');

});

Route::prefix('verificar-documentos')->name('verificar-documentos.')->group(function () {
	Route::get('/comprobante/{periodo}/{estudiante}/{tipo}/{rand}', [VerificarDocumentosController::class, 'show_comprobante'])->name('show_comprobante');
	Route::get('/constancia/{alumno}/{dia}/{tipo}/{rand}', [VerificarDocumentosController::class, 'show_constancia'])->name('show_constancia');
	Route::post('/buscar', [WebController::class, 'search_estudiante_actualizar'])->name('buscar');
	Route::get('/{id_encriptado}', [WebController::class, 'show_form_actualizar_estudiante'])->name('show-form');

});

Route::get('/{nacionalidad}/{cedula}/verificar',[WebController::class, 'verifcar_graduando'])->name('verificar_graduando');


Route::prefix('nuevo-ingreso')->name('nuevo-ingreso.')->group(function () {
	Route::get('/', function () {
		return view('web.nuevo_ingreso.index');
	})->name('index');
	Route::prefix('asignados')->name('asignados.')->group(function () {
		Route::get('/', [WebController::class, 'index_nuevo_ingreso'])->name('index');
		Route::post('/buscar', [WebController::class, 'search_asignado'])->name('buscar');
		Route::get('/{id_encriptado}', [WebController::class, 'show_form_asignado'])->name('show-form');
	});
	Route::prefix('otras-oportunidades-de-estudios')->name('flotante.')->group(function () {
		// Route::get('/', function () {
		// 	return view('web.nuevo_ingreso.flotante.index');
		// })->name('index');
		Route::get('/', [WebController::class, 'show_form_flotante'])->name('index');
	});
	// Route::get('/', [WebController::class, 'index_estudiante_actualizar'])->name('index');
	Route::post('/buscar', [WebController::class, 'search_estudiante_actualizar'])->name('buscar');
	Route::get('/{id_encriptado}', [WebController::class, 'show_form_actualizar_estudiante'])->name('show-form');

});


Route::get('/actualizar-datos1', function () {
	return view('web.estudiantes.index');
})->name('buscar_estudiante');


Route::get('/panel', function () {
	return view('panel.docentes.index');
});


Route::get('/limpiar-cache', function () {

	Artisan::call('optimize');
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('config:cache');
	Artisan::call('view:clear');

	return "Cleared!";
	return '<h1>Clear Config cleared</h1>';
});

Route::get('/storage-link', function () {

	Artisan::call('storage:link');
	return back();
	return "Cleared!";
	return '<h1>Clear Config cleared</h1>';
});

Route::get('/jobs', function () {

	Artisan::call('queue:work');
	return back();
	return "Cleared!";
	return '<h1>Clear Config cleared</h1>';
});
