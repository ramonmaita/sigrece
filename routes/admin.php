<?php

use App\Http\Controllers\Admin\AlumnosController;
use App\Http\Controllers\Admin\InscripcionesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermisosController;
use App\Http\Controllers\Admin\SeccionesController;
use App\Http\Controllers\Admin\SolicitudesController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\Admin\PerController;
use App\Http\Controllers\ComprobanteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
// use App\Http\Livewire\Admin\PeriodosComponet;

// Route::prefix('panel')->name('panel.')->middleware(['auth:sanctum', 'verified'])->group(function () {SupervisorNotas
Route::prefix('panel')->name('panel.')->group(function () {

    Route::get('/', function() {
        if (Auth::user()->hasRole('SuperAdmin') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Usuario') || Auth::user()->hasRole('SupervisorNotas')) {
            return view('dashboard');
        }else{
            if (Auth::user()->hasRole('Docente')) {
				session(['rol' => 'Docente']);
                return redirect()->route('panel.docente.index');
                // return view('panel.docentes.index');
            }elseif(Auth::user()->hasRole('Estudiante')){
				session(['rol' => 'Estudiante']);
				return redirect()->route('panel.estudiante.index');
            }
        }
    })->name('index');
    // Route::view('/', 'dashboard')->name('index');
    // Route::view('/perfil', 'panel.perfil.index')->name('perfil');

	Route::get('agregar-estudiantes', [UsuariosController::class,'agregar'])->name('agergar-estudiantes')->middleware(['role_or_permission:SuperAdmin']);

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
		Route::get('generar', [UsuariosController::class,'generar_usuarios'])->name('generar')->middleware(['role_or_permission:SuperAdmin']);
    });

    Route::resource('usuarios', UsuariosController::class)->middleware(['role_or_permission:SuperAdmin|usuarios.index']);
    Route::resource('roles', RolesController::class)->middleware(['role_or_permission:SuperAdmin|roles-permisos.index']);
    Route::resource('permisos', PermisosController::class)->middleware(['role_or_permission:SuperAdmin|roles-permisos.index']);

    Route::view('/periodos','panel.admin.periodos.index')->name('periodos.index')->middleware(['role_or_permission:periodos.index']);
    Route::view('/trayectos','panel.admin.trayectos.index')->name('trayectos.index')->middleware(['role_or_permission:trayectos.index']);
    Route::view('/pnfs','panel.admin.pnfs.index')->name('pnfs.index')->middleware(['role_or_permission:pnfs.index']);
    Route::view('/nucleos','panel.admin.nucleos.index')->name('nucleos.index')->middleware(['role_or_permission:nucleos.index']);
    Route::view('/docentes','panel.admin.docentes.index')->name('docentes.index')->middleware(['role_or_permission:docentes.index']);

    // Route::view('/secciones/configurar/{}','panel.admin.secciones.index')->name('secciones.config')->middleware(['role:Admin']);
    Route::view('/estudiantes','panel.admin.estudiantes.index')->name('estudiantes.index')->middleware(['role_or_permission:estudiantes.index']);
    // Route::view('/estudiantes/ver/{alumno}','panel.admin.estudiantes.show')->name('estudiantes.show')->middleware(['role_or_permission:estudiantes.show']);
	Route::prefix('estudiantes')->name('estudiantes.')->group(function () {
		Route::get('ver/{alumno}',[AlumnosController::class,'show'])->name('show')->middleware(['role_or_permission:estudiantes.show']);
	});

	Route::prefix('documentos')->name('documentos.')->group(function () {
		Route::prefix('notas')->name('notas.')->group(function () {
			Route::get('pdf/{alumno}',[NotasController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
		Route::prefix('comprobante')->name('comprobante.')->group(function () {
			Route::get('pdf/{alumno}',[ComprobanteController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
	});

	Route::prefix('programa-especial-de-recuperacion')->name('per.')->group(function () {
		Route::get('/',[PerController::class,'index'])->name('index')->middleware(['role_or_permission:correcciones.index']);
	});

	Route::prefix('secciones')->name('secciones.')->group(function () {
		Route::view('/','panel.admin.secciones.index')->name('index')->middleware(['role_or_permission:secciones.index']);
		Route::get('{seccion}/ver',[SeccionesController::class,'ver_seccion'])->name('show')->middleware(['role_or_permission:secciones.index']);
		Route::get('listado_de_estudiantes/{seccion}/{desasignatura}',[SeccionesController::class,'lista_esudiantes'])->name('lista_estudiantes')->middleware(['role_or_permission:secciones.index']);


		Route::get('configurar/{id}', [SeccionesController::class,'configurar'])->name('config')->middleware(['role_or_permission:secciones.configurar']);
		Route::get('lista', [SeccionesController::class,'secciones_activas'])->name('lista')->middleware(['role_or_permission:secciones.lista']);
		Route::get('ver/{periodo}/{seccion}/{pnf}', [SeccionesController::class,'show'])->name('ver-uc')->middleware(['role_or_permission:secciones.ver-uc']);
		Route::get('asignar-docente/{periodo}/{seccion}/{pnf}/{desasignatura}', [SeccionesController::class,'asignar_docente'])->name('asignar-docente')->middleware(['role_or_permission:secciones.asignar-docente']);
		Route::get('listado-de-estudiantes/{seccion}', [SeccionesController::class,'listado_estudiantes'])->name('listado-estudiantes')->middleware(['role_or_permission:secciones.listado-estudiante']);

		Route::post('asignar-docente/{seccion}', [SeccionesController::class,'asignar'])->name('asignar_docente')->middleware(['role_or_permission:secciones.asignar-docente']);
		Route::post('configurar', [SeccionesController::class,'guardar_config'])->name('guardar_config')->middleware(['role_or_permission:secciones.configurar']);
		Route::post('actualizar-configuracion', [SeccionesController::class,'actualizar_config'])->name('actualizar_config')->middleware(['role_or_permission:secciones.configurar']);

		Route::get('editar-configuracion/{id}', [SeccionesController::class,'editar_config'])->name('editar_config')->middleware(['role_or_permission:secciones.configurar']);

        Route::get('acta-de-califiaciones/{seccion}', [SeccionesController::class,'acta'])->name('acta');
    });

	Route::prefix('estadisticas')->name('estadisticas.')->group(function () {
		Route::prefix('carga-de-notas')->name('carga-de-notas.')->group(function () {
			Route::get('/', [EstadisticasController::class, 'index_carga_notas'])->middleware(['role_or_permission:estadisticas.index'])->name('index');
			Route::get('ver-seccion/{seccion}/{periodo}', [EstadisticasController::class, 'show_secciones'])->name('show')->middleware(['role_or_permission:estadisticas.index']);
		});
		Route::prefix('actualizacion-e-inscripcion')->name('actualizacion-de-datos.')->group(function () {
			Route::get('/', [EstadisticasController::class, 'index_actualizacion_datos'])->middleware(['role_or_permission:estadisticas.index'])->name('index');
			Route::get('ver-seccion/{seccion}/{periodo}', [EstadisticasController::class, 'show_secciones'])->name('show')->middleware(['role_or_permission:estadisticas.index']);
			Route::get('/data', [EstadisticasController::class, 'data'])->middleware(['role_or_permission:estadisticas.index'])->name('data');
		});
    });

	Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
		Route::get('/', [SolicitudesController::class, 'index'])->middleware(['role_or_permission:Admin'])->name('index');

    });

	Route::prefix('inscripciones')->name('inscripciones.')->group(function () {
		Route::get('/', [InscripcionesController::class, 'index'])->middleware(['role_or_permission:Admin'])->name('index');
		Route::prefix('nuevo-ingreso')->name('nuevos.')->group(function () {

		});

		Route::prefix('regulares')->name('regulares.')->group(function () {
			Route::get('/', [InscripcionesController::class, 'index_regulares'])->middleware(['role_or_permission:Admin'])->name('index');
			Route::post('/uc', [InscripcionesController::class, 'uc_incribir_regulares'])->middleware(['role_or_permission:Admin'])->name('uc');
			Route::post('/guardar', [InscripcionesController::class, 'store'])->middleware(['role_or_permission:Admin'])->name('store');

			Route::get('/data', [InscripcionesController::class, 'data'])->middleware(['role_or_permission:Admin'])->name('data');
		});
    });


    Route::prefix('comandos')->name('comandos.')->group(function () {
        Route::view('/','panel.admin.comandos.index')->name('index')->middleware(['role_or_permission:SuperAdmin|comandos.index']);
        Route::get('/limpiar-cache', function () {

            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:cache');
            Artisan::call('config:clear');
            Artisan::call('optimize:clear');

            return redirect()->route('panel.comandos.index')->with('mensaje','Cache borrada con exito.');
        })->name('limpiar-cache')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

        Route::get('/storage-link', function () {

            Artisan::call('storage:link');

            return redirect()->route('panel.comandos.index')->with('mensaje','Enlace simbolico creado con exito.');

        })->name('storage-link')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

        Route::get('/livewire-discover', function () {

            Artisan::call('livewire:discover');

            return redirect()->route('panel.comandos.index')->with('mensaje','Livewire discover ejecuado con exito.');

        })->name('livewire-discover')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

        Route::get('/jobs', function () {

            Artisan::call('queue:work');
            return redirect()->route('panel.comandos.index')->with('mensaje','Cola procesada con exito.');
        })->name('jobs')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

		Route::get('/respaldar-db', function () {

            Artisan::call('db:dump');
            return redirect()->route('panel.comandos.index')->with('mensaje','Respaldo de base de datos realizado con exito.');
        })->name('respaldar-db')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);
    });

// });
});
