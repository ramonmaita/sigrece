<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permisos = Permission::all();
        return view('panel.admin.roles.index', ['roles' => $roles,'permisos' => $permisos]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.admin.roles.create',['permisos' => Permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
                Role::create(['name' => $request->nombre]);
            DB::commit();
            return redirect()->route('panel.roles.index')->with('mensaje','Rol creado exitosamene');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // return dd($role->permissions());
        // foreach ($role->permissions() as $permiso) {
        //     echo $permiso;
        // }

        $permisos_id = DB::table('role_has_permissions')->where('role_id',$role->id)->pluck('permission_id');
        $permisos = Permission::find($permisos_id);
        // return dd($permisos);
        // return Permission::where('')
        return view('panel.admin.roles.show',['rol' => $role, 'permisos' =>$permisos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('panel.admin.roles.edit',['rol' => $role,'permisos' => Permission::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try {
            DB::beginTransaction();
                $role->update(['name' => $request->nombre]);

                if (!empty($request->permisos)) {
                    $role->syncPermissions($request->permisos);
                }
            DB::commit();
            return redirect()->route('panel.roles.index')->with('mensaje','Rol actualizado exitosamene');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
