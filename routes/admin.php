<?php

use App\Http\Controllers\Admin\AlumnosController;
use App\Http\Controllers\Admin\CambiosController;
use App\Http\Controllers\Admin\CertificacionesController;
use App\Http\Controllers\Admin\CorreccionesController as AdminCorreccionesController;
use App\Http\Controllers\Admin\DocentesController;
use App\Http\Controllers\Admin\EventosController;
use App\Http\Controllers\Admin\ExpedienteController;
use App\Http\Controllers\Admin\GraduacionesController;
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
use App\Http\Controllers\Admin\RetirosController;
use App\Http\Controllers\AsignadosController;
use App\Http\Controllers\ComprobanteController;
use App\Http\Controllers\ConstanciaController;
use App\Models\Asignatura;
use App\Models\DesAsignaturaDocenteSeccion;
use App\Models\Docente;
use App\Models\Seccion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            }elseif(Auth::user()->hasRole('Coordinador')){
				session(['rol' => 'Coordinador']);
				return redirect()->route('panel.coordinador.index');
            }
        }
    })->name('index');
    // Route::view('/', 'dashboard')->name('index');
    // Route::view('/perfil', 'panel.perfil.index')->name('perfil');

	Route::get('agregar-estudiantes', [UsuariosController::class,'agregar'])->name('agergar-estudiantes')->middleware(['role_or_permission:SuperAdmin']);

    Route::prefix('usuarios')->name('usuarios.')->group(function () {
		Route::get('generar', [UsuariosController::class,'generar_usuarios'])->name('generar')->middleware(['role_or_permission:SuperAdmin']);
		Route::get('/data-docentes', [UsuariosController::class, 'dataDocente'])->middleware(['role_or_permission:SuperAdmin'])->name('dataDocente');
		Route::put('asignar-permisos/{usuario}',[UsuariosController::class,'permisos'])->middleware(['role_or_permission:SuperAdmin'])->name('asignar_permisos');
    });

    Route::resource('usuarios', UsuariosController::class)->middleware(['role_or_permission:SuperAdmin|usuarios.index']);
    Route::resource('roles', RolesController::class)->middleware(['role_or_permission:SuperAdmin|roles-permisos.index']);
    Route::resource('permisos', PermisosController::class)->middleware(['role_or_permission:SuperAdmin|roles-permisos.index']);

    Route::view('/periodos','panel.admin.periodos.index')->name('periodos.index')->middleware(['role_or_permission:periodos.index']);
    Route::view('/trayectos','panel.admin.trayectos.index')->name('trayectos.index')->middleware(['role_or_permission:trayectos.index']);
    Route::view('/pnfs','panel.admin.pnfs.index')->name('pnfs.index')->middleware(['role_or_permission:pnfs.index']);
    Route::view('/nucleos','panel.admin.nucleos.index')->name('nucleos.index')->middleware(['role_or_permission:nucleos.index']);
    Route::view('/docentes','panel.admin.docentes.index')->name('docentes.index')->middleware(['role_or_permission:docentes.index']);
	Route::get('/docentes/ver/{docente}', [DocentesController::class,'show'])->name('docentes.show');
	Route::get('/docentes/ver-uc/{docente}/{seccion}/{asignatura}', [DocentesController::class,'show_uc'])->name('docentes.show_uc');
    // Route::view('/docentes/ver/{docente}','panel.admin.docentes.show')->name('docentes.show')->middleware(['role_or_permission:docentes.index']);

    // Route::view('/secciones/configurar/{}','panel.admin.secciones.index')->name('secciones.config')->middleware(['role:Admin']);
    Route::view('/estudiantes','panel.admin.estudiantes.index')->name('estudiantes.index')->middleware(['role_or_permission:estudiantes.index']);
	Route::prefix('estudiantes')->name('estudiantes.')->group(function () {
		Route::get('ver/{alumno}',[AlumnosController::class,'show'])->name('show')->middleware(['role_or_permission:estudiantes.show']);
		Route::get('/periodos/corregir/{alumno}',[AlumnosController::class,'periodos'])->name('periodo.corregir')->middleware(['role_or_permission:periodo.corregir']);
	});

	Route::prefix('documentos')->name('documentos.')->group(function () {
		Route::prefix('notas')->name('notas.')->group(function () {
			Route::get('pdf/{alumno}',[NotasController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
		Route::prefix('comprobante')->name('comprobante.')->group(function () {
			Route::get('pdf/{alumno}',[ComprobanteController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
		Route::prefix('constancia')->name('constancia.')->group(function () {
			Route::get('pdf/{alumno}',[ConstanciaController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
		Route::prefix('expediente')->name('expediente.')->group(function () {
			Route::get('pdf/{alumno}',[ExpedienteController::class,'pdf'])->name('pdf')->middleware(['role_or_permission:estudiantes.show']);
		});
	});

	Route::prefix('graduacion')->name('graduacion.')->group(function () {
		Route::get('/',[GraduacionesController::class,'index'])->name('index')->middleware(['role_or_permission:graduacion.index']);
		Route::get('graduando/{graduando}',[GraduacionesController::class,'show'])->name('show')->middleware(['role_or_permission:graduacion.index']);
		Route::post('buscar', [GraduacionesController::class,'buscar'])->name('buscar')->middleware(['role_or_permission:graduacion.index']);

		Route::prefix('documentos')->name('documentos.')->group(function () {
			Route::get('/titulo/{graduando}',[GraduacionesController::class,'titulo'])->name('titulo')->middleware(['role_or_permission:graduacion.index']);
			Route::get('/acta/{graduando}',[GraduacionesController::class,'acta'])->name('acta')->middleware(['role_or_permission:graduacion.index']);
			Route::get('/notas/{graduando}',[GraduacionesController::class,'notas'])->name('notas')->middleware(['role_or_permission:graduacion.index']);


			Route::get('/titulos/{pnf}/{titulo}/{periodo}',[GraduacionesController::class,'titulos'])->name('titulos')->middleware(['role_or_permission:graduacion.index']);
			Route::get('/actas/{pnf}/{titulo}/{periodo}',[GraduacionesController::class,'actas'])->name('actas')->middleware(['role_or_permission:graduacion.index']);
		});

	});

	Route::prefix('eventos')->name('eventos.')->group(function () {
		Route::get('/',[EventosController::class,'index'])->name('index')->middleware(['role_or_permission:eventos.index']);
		Route::get('/data',[EventosController::class,'data'])->name('data');
	});

	Route::resource('eventos', EventosController::class);

	Route::prefix('asignados')->name('asignados.')->group(function () {
		Route::get('/',[AsignadosController::class,'index'])->name('index')->middleware(['role_or_permission:asignados.index']);
	});

	Route::resource('asignados', AsignadosController::class);

	Route::prefix('programa-especial-de-recuperacion')->name('per.')->group(function () {
		Route::get('/',[PerController::class,'index'])->name('index')->middleware(['role_or_permission:correcciones.index']);
	});

	Route::prefix('secciones')->name('secciones.')->group(function () {
		Route::get('planificacion/{id}',[SeccionesController::class,'planificacion'])->name('planificacion')->middleware(['role_or_permission:secciones.index']);
		Route::get('cerrar-cargar/{id}',[SeccionesController::class, 'cerrar_carga'])->name('cerrar_carga')->middleware(['role_or_permission:secciones.cerrar_carga|Admin']);
		Route::view('/','panel.admin.secciones.index')->name('index')->middleware(['role_or_permission:secciones.index']);
		Route::get('{seccion}/ver',[SeccionesController::class,'ver_seccion'])->name('show')->middleware(['role_or_permission:secciones.index']);
		Route::get('listado_de_estudiantes/{seccion}/{desasignatura}',[SeccionesController::class,'lista_esudiantes'])->name('lista_estudiantes')->middleware(['role_or_permission:secciones.index']);


		Route::get('configurar/{id}', [SeccionesController::class,'configurar'])->name('config')->middleware(['role_or_permission:secciones.configurar']);
		Route::get('lista', [SeccionesController::class,'secciones_activas'])->name('lista')->middleware(['role_or_permission:secciones.lista']);
		// Route::get('ver/{periodo}/{seccion}/{pnf}', [SeccionesController::class,'show'])->name('ver-uc')->middleware(['role_or_permission:secciones.ver-uc']);
		Route::get('asignar-docente/{periodo}/{seccion}/{pnf}/{desasignatura}', [SeccionesController::class,'asignar_docente'])->name('asignar-docente')->middleware(['role_or_permission:secciones.asignar-docente']);
		Route::get('listado-de-estudiantes/{seccion}', [SeccionesController::class,'listado_estudiantes'])->name('listado-estudiantes')->middleware(['role_or_permission:secciones.listado-estudiante']);

		Route::post('asignar-docente/{seccion}', [SeccionesController::class,'asignar'])->name('asignar_docente')->middleware(['role_or_permission:secciones.asignar-docente']);
		Route::post('configurar', [SeccionesController::class,'guardar_config'])->name('guardar_config')->middleware(['role_or_permission:secciones.configurar']);
		Route::post('actualizar-configuracion', [SeccionesController::class,'actualizar_config'])->name('actualizar_config')->middleware(['role_or_permission:secciones.configurar']);

		Route::get('editar-configuracion/{id}', [SeccionesController::class,'editar_config'])->name('editar_config')->middleware(['role_or_permission:secciones.configurar']);

        Route::get('acta-de-califiaciones/{seccion}', [SeccionesController::class,'acta'])->name('acta');

        Route::get('abrir/{relacion}', [SeccionesController::class,'abrir'])->name('abrir');
        Route::get('cerrar/{relacion}', [SeccionesController::class,'cerrar'])->name('cerrar');
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
		Route::prefix('aprobados-y-reprobados')->name('aprobados-reprobados.')->group(function () {
			Route::get('/', [EstadisticasController::class, 'index_aprobados_reprobados'])->middleware(['role_or_permission:estadisticas.index'])->name('index');
			// Route::get('ver-seccion/{seccion}/{periodo}', [EstadisticasController::class, 'show_secciones'])->name('show')->middleware(['role_or_permission:estadisticas.index']);
		});
    });

	Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
		Route::get('/', [SolicitudesController::class, 'index'])->middleware(['role_or_permission:Admin|solicitudes.index'])->name('index');
		Route::get('{solicitud}/ver', [SolicitudesController::class, 'show'])->middleware(['role_or_permission:Admin|solicitudes.index'])->name('show');
    });

	Route::prefix('retiro-de-uc-inscritas')->name('retiros.')->group(function () {
		Route::get('/',[RetirosController::class, 'index'])->middleware(['role_or_permission:Admin'])->name('index');
		Route::get('/nueva-solicitud',[RetirosController::class, 'create'])->middleware(['role_or_permission:Admin'])->name('create');
		Route::get('/{solicitud}',[RetirosController::class, 'show'])->middleware(['role_or_permission:Admin'])->name('show');
		// Route::get('/', [SolicitudesController::class, 'index'])->middleware(['role_or_permission:Admin'])->name('index');

    });

	Route::prefix('inscripciones')->name('inscripciones.')->group(function () {
		Route::get('/', [InscripcionesController::class, 'index'])->middleware(['role_or_permission:Admin'])->name('index');
		Route::prefix('nuevo-ingreso')->name('nuevos.')->group(function () {

		});

		Route::prefix('ciu')->name('ciu.')->group(function () {
			Route::get('/', [InscripcionesController::class, 'index_ciu'])->middleware(['role_or_permission:inscripciones.ciu.index'])->name('index');
			Route::post('/uc', [InscripcionesController::class, 'uc_incribir'])->middleware(['role_or_permission:inscripciones.ciu.index'])->name('uc');
		});

		Route::prefix('regulares')->name('regulares.')->group(function () {
			Route::get('/', [InscripcionesController::class, 'index_regulares'])->middleware(['role_or_permission:Admin'])->name('index');
			Route::post('/uc', [InscripcionesController::class, 'uc_incribir_regulares'])->middleware(['role_or_permission:Admin'])->name('uc');
			Route::post('/guardar', [InscripcionesController::class, 'store'])->middleware(['role_or_permission:Admin'])->name('store');

			Route::get('/data', [InscripcionesController::class, 'data'])->middleware(['role_or_permission:Admin'])->name('data');
		});
    });


	Route::prefix('cambios')->name('cambios.')->group(function () {
		Route::get('/', function () {
			return redirect()->route('panel.cambios.create');
		})->name('index');
		// Route::get('/', [CambiosController::class, 'index'])->middleware(['role_or_permission:cambios.index'])->name('index');
		Route::get('/nueva-solicitud', [CambiosController::class, 'create'])->middleware(['role_or_permission:cambios.create'])->name('create');
    });

	Route::prefix('correcciones-de-calificaciones')->name('correcciones.')->group(function () {
		Route::get('/', function () {
			return redirect()->route('panel.correcciones.create');
		})->name('index');
		// Route::get('/', [AdminCorreccionesController::class, 'index'])->middleware(['role_or_permission:correcciones.index'])->name('index');
		Route::get('/nueva-solicitud', [AdminCorreccionesController::class, 'create'])->middleware(['role_or_permission:correcciones.create'])->name('create');
    });

	Route::prefix('carnet')->name('carnet.')->group(function(){
        Route::view('/','panel.admin.carnets.index')->name('index')->middleware(['role_or_permission:SuperAdmin|carnets.index']);
	});

	Route::prefix('documentos')->name('documentos.')->group(function(){
        // Route::view('/','panel.admin.documentos.index')->name('index')->middleware(['role_or_permission:SuperAdmin|documentos.index']);

		Route::prefix('simples')->name('simples.')->group(function(){
			Route::view('/','panel.admin.documentos.simples.index')->name('index')->middleware(['role_or_permission:SuperAdmin|documentos.simples.index']);
		});

		Route::prefix('certificados')->name('certificados.')->group(function(){
			Route::view('/','panel.admin.documentos.certificados.index')->name('index')->middleware(['role_or_permission:SuperAdmin|documentos.certificados.index']);
			Route::post('buscar',[CertificacionesController::class,'buscar'])->name('buscar');
			Route::get('graduando/{graduando}',[CertificacionesController::class,'show'])->name('show')->middleware(['role_or_permission:graduacion.index']);

			Route::get('autenticacion/{graduando}',[CertificacionesController::class,'autenticacion'])->name('autenticacion')->middleware(['role_or_permission:graduacion.index']);
			Route::get('emision/{graduando}',[CertificacionesController::class,'emision'])->name('emision')->middleware(['role_or_permission:graduacion.index']);
			Route::get('certificacion/{especialidad}',[CertificacionesController::class,'certificacion'])->name('certificacion')->middleware(['role_or_permission:graduacion.index']);
		});
	});

    Route::prefix('comandos')->name('comandos.')->group(function () {
        Route::view('/','panel.admin.comandos.index')->name('index')->middleware(['role_or_permission:SuperAdmin|comandos.index']);
        Route::get('/limpiar-cache', function () {

            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:cache');
            Artisan::call('config:clear');
            Artisan::call('optimize');

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

        Route::get('/jobs-retry', function () {

            Artisan::call('queue:retry all');
            return redirect()->route('panel.comandos.index')->with('mensaje','Cola procesada con exito.');
        })->name('jobs-retry')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

		Route::get('/respaldar-db', function () {

            Artisan::call('db:dump');
			\Log::info('SE EJECUTO EL COMANDO DE RESPALDO');
            return redirect()->back()->with('mensaje','Respaldo de base de datos realizado con exito.');
        })->name('respaldar-db')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

		Route::get('/modo-mantenimiento-activo', function () {

            Artisan::call('down --secret="sigrece-147"');
            return redirect('/sigrece-147')->with('jet_mensaje','Modo manteniento activo');
        })->name('modo-mantenimiento-activo')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);

		Route::get('/modo-mantenimiento-inactivo', function () {

            Artisan::call('up');
            return redirect()->back()->with('mensaje','Modo manteniento Desactivado');
        })->name('modo-mantenimiento-inactivo')->middleware(['role_or_permission:SuperAdmin|comandos.ejecutar']);
    });

	Route::prefix('respaldos')->name('respaldos.')->group(function () {

		Route::get('/', function () {
			$files = Storage::disk('database')->allFiles();
			return view('panel.admin.respaldos_bd.index',['files' => $files]);
		})->name('index');

		Route::get('descargar/{archivo}', function ($archivo) {
			$archivo = ($archivo == 'schema.sql') ? 'schemas/schema.sql' : $archivo;
			return Storage::disk('database')->download($archivo);
		})->name('descargar');
		Route::get('borrar/{archivo}', function ($archivo) {
			Storage::disk('database')->delete($archivo);
			return back()->with('mensaje','Archivo eliminado exitosamente.');
		})->name('borrar');

	});
});
