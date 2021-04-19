<?php

namespace App\Http\Livewire\Permissoes;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissoesComponent extends Component
{
    public $permissaoTitle = 'Criar', $roleTitle='Criar', $userSelected;
    public $tab = 'roles', $roleSelected;

    public function render()
    {
        $roles = Role::select('*', DB::RAW("0 as checked"))->get();
        $permissoes = Permission::select('*', DB::RAW("0 as checked"))->get();
dd($roles);
        if($this->userSelected != '' && $this->userSelected != 'Selecione')
        {
            foreach ($roles as $r) {

                $user = User::find($this->userSelected);

                $temRole = $user->hasRole($r->name);
                if($temRole) {
                    $r->checked = 1;
                }
            }
        }

        if($this->roleSelected != '' && $this->roleSelected != 'Selecione')
        {
            foreach ($permissoes as $p) {
                $role = Role::find($this->roleSelected);
                $temPermissao = $role->hasPermissionTo($p->name);
                if($temPermissao) {
                    $p->checked = 1;
                }
            }
        }
        return view('livewire.permissoes.permissoes-component', [
            'roles' => $roles,
            'permissoes' => $permissoes,
            'usuarios' => User::select('id', 'name')->get()
        ]);
    }

    //Seção de roles
    public function resetInput() {
        $this->roleTitle = 'Criar';
        $this->permissaoTitle = 'Criar';
        $this->userSelected = 'Selecione';
        $this->roleSelected = 'Selecione';
    }

    public function CriarRole($roleName, $roleId)
    {
        if($roleId)
            $this->UpdateRole($roleName, $roleId);
        else    
            $this->SaveRole($roleName);
    }

    public function SaveRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if($role) {
            $this->emit('msg-error', 'A Role que quer registrar já existe no Sistema.');
            return;
        }

        Role::create([
            'name' => $roleName
        ]);

        $this->emit('msg-ok', 'Role registrado corretamente.');
        $this->resetInput();
    }

    public function UpdateRole($roleName, $roleId)
    {
        $role = Role::where('name', $roleName)->where('id', '<>', $roleId)->first();

        if($role) {
            $this->emit('msg-error', 'A Role que quer registrar já existe no Sistema.');
            return;
        }
        $role = Role::find($roleId);
        $role->name = $roleName;
        $role->save();

        $this->emit('msg-ok', 'Role atualizado corretamente.');
        $this->resetInput();
    }

    public function destroyRole($roleId)
    {
        Role::find($roleId)->delete();
        $this->emit('msg-ok', 'Role eliminado com sucesso.');
    }

    public function AtribuirRoles($rolesList)
    {
        if($this->userSelected) {
            $user = User::find($this->userSelected);

            if($user) {
                $user->syncRoles($rolesList);
                $this->emit('msg-ok', 'Roles atribuídos corretamente');
                $this->resetInput();
            }
        }
    }

    protected $listeners = [
        'destroyRole' => 'destroyRole',
        'destroyPermissao' => 'destroyPermissao',
        'CriarPermissao' => 'CriarPermissao',
        'CriarRole' => 'CriarRole',
        'AtribuirRoles' => 'AtribuirRoles',
        'AtribuirPermissoes' => 'AtribuirPermissoes',
    ];

    public function CriarPermissao($permissaoName, $permissaoId)
    {
        if($permissaoId)
            $this->UpdatePermissao($permissaoName, $permissaoId);
        else
            $this->SavePermissao($permissaoName);
    }

    public function SavePermissao($permissaoName)
    {
        $permissao = Permission::where('name', $permissaoName)->first();
        if($permissao){
            $this->emit('msg-error', 'A permissão que deseja registrar já existe no sistema');
            return;
        }

        Permission::create([
            'name' => $permissaoName
        ]);
        $this->emit('msg-ok', 'Permissão registrada com sucesso.');
        $this->resetInput();
    }

    public function UpdatePermissao($permissaoName, $permissaoId)
    {
        $permissao = Permission::where('name', $permissaoName)->where('id', '<>', $permissaoId)->first();

        if($permissao) {
            $this->emit('msg-error', 'A Permissão que quer registrar já existe no Sistema.');
            return;
        }

        $permissao = Permission::find($permissaoId);
        $permissao->name = $permissaoName;
        $permissao->save();

        $this->emit('msg-ok', 'Permissão atualizada corretamente.');
        $this->resetInput();
    }

    public function destroyPermissao($permissaoId)
    {
        Permission::find($permissaoId)->delete();
        $this->emit('msg-ok', 'Permissão eliminada corretamente.');
    }

    public function AtribuirPermissoes($permissoesList, $roleId)
    {
        if($roleId > 0){
            $role = Role::find($roleId);
            if($role){
                $role->syncPermissions($permissoesList);
                $this->emit('msg-ok', 'Permissões atribuídas corretamente.');
                $this->resetInput();
            }
        }
    }
}
