<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin']);
        $usuario = Role::create(['name' => 'Usuario']);
        $docente = Role::create(['name' => 'Docente']);
        $estudiante = Role::create(['name' => 'Estudiante']);
        $superAdmin = Role::create(['name' => 'SAdmin']);


        Permission::create(['name' => 'panel'])->syncRoles([$admin,$usuario,$docente,$estudiante]);
		// TODO: PERMISOS PARA PERIODOS
        Permission::create(['name' => 'periodos.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'periodos.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'periodos.edit'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA TRAYECTOS
        Permission::create(['name' => 'trayectos.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'trayectos.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'trayectos.edit'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA PNF
        Permission::create(['name' => 'pnfs.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'pnfs.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'pnfs.edit'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA NUCLEOS
        Permission::create(['name' => 'nucleos.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'nucleos.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'nucleos.edit'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA DOCENTES
        Permission::create(['name' => 'docentes.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'docentes.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'docentes.edit'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA SECCIONES
        Permission::create(['name' => 'secciones.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'secciones.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'secciones.edit'])->syncRoles([$admin,$superAdmin]);
        Permission::create(['name' => 'secciones.configurar'])->syncRoles([$admin,$usuario,$superAdmin]);

        Permission::create(['name' => 'secciones.lista'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'secciones.ver-uc'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'secciones.asignar-docente'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'secciones.listado-estudiante'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA ESTUDIANTES
        Permission::create(['name' => 'estudiantes.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'estudiantes.create'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'estudiantes.edit'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'estudiantes.show'])->syncRoles([$admin,$usuario,$superAdmin]);

		// TODO: PERMISOS PARA USUARIOS
        Permission::create(['name' => 'usuarios.index'])->syncRoles([$admin,$superAdmin]);
        Permission::create(['name' => 'usuarios.create'])->syncRoles([$admin,$superAdmin]);
        Permission::create(['name' => 'usuarios.edit'])->syncRoles([$admin,$superAdmin]);
        Permission::create(['name' => 'usuarios.show'])->syncRoles([$admin,$superAdmin]);

		// TODO: PERMISOS PARA ROLES Y PERMISOS
		Permission::create(['name' => 'roles-permisos.index'])->syncRoles([$admin,$usuario,$superAdmin]);

		Permission::create(['name' => 'roles.index'])->syncRoles([$admin,$usuario,$superAdmin]);
		Permission::create(['name' => 'roles.create'])->syncRoles([$admin,$superAdmin]);
		Permission::create(['name' => 'roles.edit'])->syncRoles([$admin,$superAdmin]);
		Permission::create(['name' => 'roles.show'])->syncRoles([$admin,$usuario,$superAdmin]);
		Permission::create(['name' => 'permisos.index'])->syncRoles([$admin,$usuario,$superAdmin]);
		Permission::create(['name' => 'permisos.create'])->syncRoles([$admin,$superAdmin]);
		Permission::create(['name' => 'permisos.edit'])->syncRoles([$admin,$superAdmin]);

		// TODO: PERMISOS EN EL PANEL DE DOCENTES

		// TODO: PERMISOS PARA ESTUDIANTES
        Permission::create(['name' => 'docente.secciones.index'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'docente.secciones.cargar'])->syncRoles([$admin,$usuario,$superAdmin]);
        Permission::create(['name' => 'docente.secciones.acta'])->syncRoles([$admin,$usuario,$superAdmin]);
        // Permission::create(['name' => 'usuarios.show'])->syncRoles([$admin,$usuario,$superAdmin]);
    }
}
