<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        //Permissoes
	Permission::create(['name' => 'users_index']);
	Permission::create(['name' => 'users_create']);
	Permission::create(['name' => 'users_edit']);
	Permission::create(['name' => 'users_destroy']);
        Permission::create(['name' => 'users_tipo']);

        Permission::create(['name' => 'ufirs_index']);
        Permission::create(['name' => 'ufirs_create']);

        Permission::create(['name' => 'clientes_index']);
        Permission::create(['name' => 'clientes_create']);
        Permission::create(['name' => 'clientes_edit']);
        Permission::create(['name' => 'clientes_destroy']);

        Permission::create(['name' => 'causas_index']);
        Permission::create(['name' => 'causas_create']);
        Permission::create(['name' => 'causas_edit']);
        Permission::create(['name' => 'causas_destroy']);

        Permission::create(['name' => 'cemiterio_index']);
        Permission::create(['name' => 'cemiterio_create']);
        Permission::create(['name' => 'cemiterio_edit']);
        Permission::create(['name' => 'cemiterio_destroy']);

        Permission::create(['name' => 'funerarias_index']);
        Permission::create(['name' => 'funerarias_create']);
        Permission::create(['name' => 'funerarias_edit']);
        Permission::create(['name' => 'funerarias_destroy']);

        Permission::create(['name' => 'pessoas_pdf']);
        Permission::create(['name' => 'pessoas_index']);
        Permission::create(['name' => 'pessoas_create']);
        Permission::create(['name' => 'pessoas_edit']);
        Permission::create(['name' => 'pessoas_destroy']);

        Permission::create(['name' => 'requerimento_index']);
        Permission::create(['name' => 'requerimento_create']);
        Permission::create(['name' => 'requerimento_edit']);
        Permission::create(['name' => 'requerimento_destroy']);
	Permission::create(['name' => 'requerimento_pdf']);

        Permission::create(['name' => 'reservas_index']);
        Permission::create(['name' => 'reservas_create']);
        Permission::create(['name' => 'reservas_edit']);
        Permission::create(['name' => 'reservas_destroy']);

        Permission::create(['name' => 'taxas_index']);
        Permission::create(['name' => 'taxas_create']);
        Permission::create(['name' => 'taxas_edit']);
        Permission::create(['name' => 'taxas_destroy']);
        Permission::create(['name' => 'permissoes']);

        //Roles
        $admin = Role::create(['name' => 'Admin']);
        $gerente = Role::create(['name' => 'Gerente']);
        $usuario = Role::create(['name' => 'Usu??rio']);

	$admin->givePermissionTo(Permission::all());

/*        $admin->givePermissionTo([
            'ufirs_index',
            'ufirs_create',
            'clientes_create',
            'clientes_index',
            'clientes_edit',
            'clientes_destroy',
            'causas_index', 
            'causas_create', 
            'causas_edit', 
            'causas_destroy', 
            'cemiterio_create', 
            'cemiterio_index', 
            'cemiterio_edit', 
            'cemiterio_destroy', 
            'funerarias_index', 
            'funerarias_create', 
            'funerarias_edit', 
            'funerarias_destroy', 
            'pessoas_pdf', 
            'pessoas_index', 
            'pessoas_create', 
            'pessoas_edit', 
            'pessoas_destroy', 
            'requerimento_index', 
            'requerimento_create', 
            'requerimento_edit', 
            'requerimento_destroy', 
	    'requerimento_pdf',
            'taxas_index', 
            'taxas_create', 
            'taxas_edit', 
            'taxas_destroy', 
            'permissoes', 

        ]);
*/  
      $gerente->givePermissionTo([
            'ufirs_index',
            'ufirs_create',
	    'users_index',
	    'users_create',
            'clientes_create',
            'clientes_index',  
            'clientes_edit',
            'clientes_destroy', 
            'causas_index', 
            'causas_create', 
            'causas_edit', 
            'causas_destroy', 
            'cemiterio_create', 
            'cemiterio_index', 
            'cemiterio_edit', 
            'cemiterio_destroy', 
            'funerarias_index', 
            'funerarias_create', 
            'funerarias_edit', 
            'funerarias_destroy', 
            'pessoas_pdf', 
            'pessoas_index', 
            'pessoas_create', 
            'pessoas_edit', 
            'pessoas_destroy', 
            'requerimento_index', 
            'requerimento_create', 
            'requerimento_edit', 
            'requerimento_destroy', 
	    'requerimento_pdf',
	    'reservas_index',
	    'reservas_create',
	    'reservas_edit',
            'reservas_destroy',
            'taxas_index', 
            'taxas_create', 
            'taxas_edit', 
            'taxas_destroy', 
            
        ]);

	$usuario->givePermissionTo([
            'ufirs_index',
            'clientes_index',   
            'causas_index', 
            'cemiterio_index',  
            'funerarias_index', 
            'pessoas_pdf', 
            'pessoas_index',  
            'requerimento_index',  
            'requerimento_pdf', 
            'taxas_index',  
            
        ]);

  /*      $user = User::find(1);
        $user->assignRole('Admin');*/
    }
}
