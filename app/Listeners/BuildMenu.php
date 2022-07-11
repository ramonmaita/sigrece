<?php

namespace App\Listeners;

use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class BuildMenu
{


	protected $sigreceMenu = [
        [
            'text' => 'search',
            'search' => false,
            'topnav' => true,
        ],
        [
            'text' => 'blog',
            'url'  => 'admin/blog',
            'can'  => 'manage-blog',
        ],
        [
            'text'        => 'Inicio',
            'route'         => 'panel.index',
            'icon'        => 'fas fa-fw fa-home',
        ],

        ['header' => 'OPCIONES DE ADMINISTRADOR','role' => 'Alumno'],
        [
			'key' => 'periodos',
            'text' => 'Periodos',
            'route'  => 'panel.periodos.index',
            'icon' => 'fas fa-fw fa-calendar-alt',
            'can'  => 'periodos.index',
        ],
        [
            'text' => 'Trayectos',
            'route'  => 'panel.trayectos.index',
            'icon' => 'fas fa-fw fa-align-justify',
            'can'  => 'trayectos.index',
        ],
        [
            'text' => 'PNFs',
            'route'  => 'panel.pnfs.index',
            'icon' => 'fas fa-fw fa-book-reader',
            'can'  => 'pnfs.index',
        ],
        [
            'text' => 'Nucleos',
            'route'  => 'panel.nucleos.index',
            'icon' => 'fas fa-fw fa-map-marker-alt',
            'can'  => 'nucleos.index',
        ],
        [
            'text' => 'Docentes',
            'route'  => 'panel.docentes.index',
            'icon' => 'fas fa-fw fa-chalkboard-teacher',
            'can'  => 'docentes.index',
        ],
        [
            'text' => 'Secciones',
            'route'  => 'panel.secciones.index',
            'icon' => 'fas fa-fw fa-chalkboard-teacher',
            'can'  => 'secciones.index',
        ],
		// [
        //     'text'    => 'Secciones',
        //     'icon'    => 'fas fa-fw fa-chalkboard-teacher',
		// 	'can' => 'secciones.index',
        //     'submenu' => [
        //         [
        //             'text' => '2021',
        //             'route'  => 'panel.secciones.index',
		// 			'can' => 'secciones.index',
        //         ],
        //         [
        //             'text' => '2020',
		// 			'route'  => 'panel.secciones.lista',
        //             'can' => 'secciones.lista',
        //         ],
		// 		// [
		// 		// 	'text' => 'Cerrar Carga',
		// 		// 	'route' => 'panel.secciones.cerrar_carga',
		// 		// 	'can' => 'secciones.cerrar_carga'
		// 		// ]
        //     ],
        // ],
        [
            'text' => 'Estudiantes',
            'route'  => 'panel.estudiantes.index',
            'icon' => 'fas fa-fw fa-user-friends',
            'can'  => 'estudiantes.index',
        ],
		[
            'text'    => 'Inscripciones',
            'icon' => 'fas fa-fw fa-chalkboard',
			'can' => 'inscripciones.index',
            'submenu' => [
                [
					'text' => 'Regulares',
					'route'  => 'panel.inscripciones.regulares.index',
					'can'  => 'inscripciones.regulares.index',
				],
                [
					'text' => 'CIU-PERN',
					'route'  => 'panel.inscripciones.ciu.index',
					'can'  => 'inscripciones.ciu.index',
				],
				[
					'text' => 'Retiro de UC',
					'route'  => 'panel.retiros.index',
					'can'  => 'retiros.index',
				],
            ],
        ],
		[
            'text' => 'Graduación',
            'route'  => 'panel.graduacion.index',
            'icon' => 'fas fa-fw fa-graduation-cap',
            'can'  => 'graduacion.index',
        ],
		[
            'text'    => 'Documentos',
            'icon' => 'fas fa-fw fa-file',
			'can' => 'documentos.index',
            'submenu' => [
                [
					'text' => 'Simples',
					'route'  => 'panel.documentos.simples.index',
					'can'  => 'documentos.simples.index',
				],
                [
					'text' => 'Certificados',
					'route'  => 'panel.documentos.certificados.index',
					'can'  => 'documentos.certificados.index',
				],
            ],
        ],
		[
            'text' => 'Cambios',
            'route'  => 'panel.cambios.index',
            'icon' => 'fas fa-fw fa-exchange-alt',
            'can'  => 'cambios.index',
        ],
		[
            'text' => 'Solicitudes',
            'route'  => 'panel.solicitudes.index',
            'icon' => 'fas fa-fw fa-question-circle',
            'can'  => 'solicitudes.index',
        ],
		[
            'text'    => 'Correcciones',
            'icon' => 'fas fa-fw fa-undo',
			'can'  => 'correcciones.index',
            'submenu' => [
                [
					'text' => 'PER',
					'route'  => 'panel.per.index',
					'can'  => 'correcciones.index',
				],
				[
					'text' => 'Calificaciones',
					'route'  => 'panel.correcciones.index',
					'can'  => 'correcciones.index',
				],
            ],
        ],
        [
            'text' => 'Usuarios',
            'route'  => 'panel.usuarios.index',
            'icon' => 'fas fa-fw fa-users',
            'can'  => 'usuarios.index',
        ],
        [
            'text' => 'Gestionar Roles y Permisos',
            'route'  => 'panel.roles.index',
            'icon' => 'fas fa-fw fa-users-cog',
            'can' => 'roles-permisos.index',
        ],
        [
            'text' => 'Eventos',
            'route'  => 'panel.eventos.index',
            'icon' => 'fas fa-fw fa-calendar',
            'can' => 'eventos.index',
        ],
		[
            'text' => 'Asignados',
            'route'  => 'panel.asignados.index',
            'icon' => 'fas fa-fw fa-calendar',
            'can' => 'asignados.index',
        ],
		[
            'text'    => 'Estadisticas',
            'icon'    => 'fas fa-chart-bar fa-fw',
			'can' => 'estadisticas.index',
            'submenu' => [
                [
                    'text' => 'Control de Carga',
                    'route'  => 'panel.estadisticas.carga-de-notas.index',
					'can' => 'estadisticas.carga-de-nota.index',
                ],
                [
                    'text' => 'Actualiación e Inscripción',
					'route'  => 'panel.estadisticas.actualizacion-de-datos.index',
                    'can' => 'estadisticas.actualizacion-de-datos.index',
                ],
                [
                    'text' => 'Aprobados y Reprobados',
					'route'  => 'panel.estadisticas.aprobados-reprobados.index',
                    'can' => 'estadisticas.aprobados-reprobados.index',
                ],
            ],
        ],
        [
            'text' => 'Lista de Comandos',
            'route'  => 'panel.comandos.index',
            'icon' => 'fas fa-tools fa-fw',
            'can' => 'comandos.index',
        ],
        [
            'text' => 'Respaldo de BD',
            'route'  => 'panel.respaldos.index',
            'icon' => 'fas fa-database fa-fw',
            'can' => 'respaldos.index',
        ],

        // ['header' => 'account_settings'],
        // [
        //     'text' => 'profile',
        //     'route'  => 'panel.perfil',
        //     'icon' => 'fas fa-fw fa-user',
        // ],
        // [
        //     'text' => 'change_password',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-lock',
        // ],
        // [
        //     'text'    => 'multilevel',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //         [
        //             'text'    => 'level_one',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text'    => 'level_two',
        //                     'url'     => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //     ],
        // ],

	];

	protected $PNFAMenu = [
		[
			'key' => 'periodos',
			'text' => 'Periodos PNFA',
			'route' => 'panel.index',
			'icon' => 'fas fa-fw fa-calendar-alt',
			'can'  => 'periodos.index',
		],
		[
			'text' => 'Trayectos PNFA',
			'route'  => 'panel.index',
			'icon' => 'fas fa-fw fa-align-justify',
			'can'  => 'trayectos.index',
		],
		[
			'text' => 'PNFA',
			'route'  => 'panel.index',
			'icon' => 'fas fa-fw fa-book-reader',
			'can'  => 'pnfs.index',
		],
		[
			'header' => 'ETC'
		]
	];
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BuildingMenu  $event
     * @return void
     */
    public function handle(BuildingMenu $event)
    {
		$sistema = session('sistema');
		if($sistema == 'pnfa'){
			$event->menu->add(
				...$this->PNFAMenu
			);
		}else{
			$event->menu->add(
				...$this->sigreceMenu
			);
		}
    }
}
