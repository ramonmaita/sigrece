<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Livewire\WithPagination; //paginacion

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesComponet extends Component
{
    use WithPagination; //paginacion

    protected $paginationTheme = 'bootstrap';
    public $search;
    public $modo = 'crear';
    public $vista, $titulo;
    protected $queryString = [
        'search' => ['except' => ''],
        'vista'
    ];

    protected $rules = [
        'nombre' => 'required|string|min:4|max:100',
    ];

    public $nombre,$rol_id,$permiso_id;
    public $permisos_id = [];
    // public $permissions;
    // public function mount($titulo = 'Crear Nuevo')
    // {
    //     $this->titulo = $titulo.$this->vista;
    // }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function render()
    {
        if($this->search != '' && $this->vista == 'roles'){
            $roles = Role::where('name','like', "%$this->search%")->paginate(15);
            $permisos = Permission::paginate(15);
        }elseif($this->search != '' && $this->vista == 'permisos'){
            $roles = Role::paginate(15);
            $permisos = Permission::where('name','like', "%$this->search%")->paginate(15);
        }else{
            $roles = Role::paginate(15);
            $permisos = Permission::paginate(15);
        }
        if(empty($this->vista)){
            if (Auth::user()->can('roles.index')) {
                $this->vista = 'roles';
            }else if(Auth::user()->can('permisos.index')){
                $this->vista = 'permisos';
            }
        }
        return view('livewire.admin.roles-componet', ['roles' => $roles,'permisos' => $permisos,'permissions' =>Permission::all()]);
    }

    public function setVista($vista)
    {
        $this->vista = $vista;
        $this->page = 1;
        $this->search = '';
    }

    public function setTitulo($titulo,$modo)
    {
        $this->titulo = $titulo;
        $this->modo = $modo;
        if($modo == 'crear'){
            $this->reset(['permisos_id','nombre','rol_id']);
        }
    }

    public function store()
    {
         try {
            DB::beginTransaction();
            if($this->vista == 'roles'){
                $this->validate();
                $rol = Role::create(['name' => $this->nombre]);
                if (!empty($this->permisos_id)) {
                    $rol->syncPermissions($this->permisos_id);
                }
                $this->reset(['permisos_id','nombre']);
                $this->emit('cerrar_modal'); // Close model to using to jquery
                DB::commit();
                session()->flash('mensaje', 'Rol creado correctamente.');
            }else{
                $this->validate();
                $permiso = Permission::create(['name' => $this->nombre]);
                $this->reset(['nombre']);
                $this->emit('cerrar_modal'); // Close model to using to jquery
                DB::commit();
                session()->flash('mensaje', 'Permiso creado correctamente.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error',$e->getMessage());
        }
    }

    public function show($id)
    {
        $this->modo = 'ver';
        if($this->vista == 'roles'){
            $rol = Role::find($id);
            $pwe_id = DB::table('role_has_permissions')->where('role_id',$rol->id)->pluck('permission_id')->toArray();
            $this->rol_id = $id;
            $this->nombre = $rol->name;
            $this->permisos_id = Permission::whereIn('id',$pwe_id)->get();
        }
    }

    public function edit($id)
    {
        $this->modo = 'editar';
        if($this->vista == 'roles'){
            $this->titulo = 'Editar Rol';
            $this->reset(['permisos_id','nombre']);
            $rol = Role::find($id);
            $pwe_id = DB::table('role_has_permissions')->where('role_id',$rol->id)->pluck('permission_id')->toArray();
            // $pwe_id = $rol->permissions()->get();
            // $permisos_id = Permission::find($permisos_id)->pluck('id');
            $this->rol_id = $id;
            $this->nombre = $rol->name;
            // $this->permisos_id = $pwe_id;
            foreach ($pwe_id as $permiso_id) {
                $this->permisos_id[$permiso_id] = $permiso_id;
            }
        }else{
            $this->titulo = 'Editar Permiso';
            $this->permiso_id = $id;
            $permiso = Permission::find($id);
            $this->nombre = $permiso->name;
        }
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            if ($this->vista == 'roles') {
                $rol = Role::find($this->rol_id)->update([
                    'name' => $this->nombre
                ]);
                $rol = Role::find($this->rol_id);
                if (!empty($this->permisos_id)) {
                    $rol->syncPermissions($this->permisos_id);
                }
                $this->emit('cerrar_modal'); // Close model to using to jquery
                DB::commit();
                session()->flash('mensaje', 'Rol actualizado correctamente.');
            }else{
                $permiso = Permission::find($this->permiso_id)->update([
                    'name' => $this->nombre
                ]);
                $this->emit('cerrar_modal'); // Close model to using to jquery
                DB::commit();
                session()->flash('mensaje', 'Permiso actualizado correctamente.');
            }
         } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error',$e->getMessage());
        }
    }

    public function resetSearch()
    {
        $this->search = '';
    }
}
