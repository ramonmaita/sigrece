<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'title' => 'UPTEB - SIGRECE',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'logo' => '<b>UPT</b>Bolivar',
    'logo_img' => 'img/LOGO_UPTBOLIVAR.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'UPTBolivar',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-lightblue',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => 'bg-lightblue',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-lightblue navbar-dark',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/7.-Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/6.-Basic-Configuration
    |
    */

    'use_route_url' => true,
    'dashboard_url' => 'raiz',
    // 'dashboard_url' => 'panel.index',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'menu' => [
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
            'text' => 'Becados',
            'route'  => 'panel.estudiantes.becas.index',
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

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/jquery.dataTables.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/dataTables.bootstrap4.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/dataTables.responsive.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/responsive.bootstrap4.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/dataTables.buttons.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/buttons.bootstrap4.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/jszip.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/pdfmake.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/vfs_fonts.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/buttons.html5.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/buttons.print.min.js',
				],
				[
					'type' => 'js',
					'asset' => true,
					'location' => 'js/datatables/buttons.colVis.min.js',
				],
				[
				    'type' => 'css',
				    'asset' => true,
				    'location' => 'css/datatables/dataTables.bootstrap4.min.css',
				],
				[
				    'type' => 'css',
				    'asset' => true,
				    'location' => 'css/datatables/responsive.bootstrap4.min.css',
				],
				[
				    'type' => 'css',
				    'asset' => true,
				    'location' => 'css/datatables/buttons.bootstrap4.min.css',
				],
				// [
				// 	'type' => 'js',
				// 	'asset' => true,
				// 	'location' => 'js/jquery.dataTables.min.js',
				// ],
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'js/dataTables.bootstrap4.min.js',
                // ],
                // [
                //     'type' => 'css',
                //     'asset' => true,
                //     'location' => 'css/dataTables.bootstrap4.min.css',
                // ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/Chart.bundle.min.js',
                ],
            ],
        ],
		'AdminLTE' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/adminlte.min.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'js/sweetalert2@8.js',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/9.-Other-Configuration
    */

    'livewire' => true,
];
