<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser le cache des rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer des permissions
        Permission::create(['name' => 'edit, create products']);
        Permission::create(['name' => 'voir  fiche complete produit']);
        Permission::create(['name' => 'see category']);
        Permission::create(['name' => 'create and edit category']);

        
        Permission::create(['name' => 'see daily invoices']);
        Permission::create(['name' => 'create and edit invoices']);


        Permission::create(['name' => 'see invoices (all time)']);
        
        Permission::create(['name' => 'see orders']);
        Permission::create(['name' => 'traiter les commandes']);


        Permission::create(['name' => 'voir les cartes clients']);
        Permission::create(['name' => 'voir les finances']);



        Permission::create(['name' => 'create and edit users']);


        Permission::create(['name' => 'see and edit users']);
        //$this->authorize('edit articles'); dans le controlleur

        // Créer des rôles et assigner des permissions
        $role = Role::create(['name' => 'magasinier']);
        $role->givePermissionTo('edit, create products');
        $role->givePermissionTo('see category');
        $role->givePermissionTo('create and edit category');
 
        $role = Role::create(['name' => 'caissiere']);
        $role->givePermissionTo('see daily invoices');
        $role->givePermissionTo('create and edit invoices');
        $role->givePermissionTo('see orders');
        $role->givePermissionTo('voir les cartes clients');
        $role->givePermissionTo('see category');

        $role = Role::create(['name' => 'gestionnaireCommande']);
        $role->givePermissionTo('traiter les commandes');
        $role->givePermissionTo('see orders');

        $role = Role::create(['name' => 'auditeur']);
        $role->givePermissionTo('voir  fiche complete produit');
        $role->givePermissionTo('see daily invoices');
        
        $role = Role::create(['name' => 'financier']);
        $role->givePermissionTo('voir les cartes clients');
        $role->givePermissionTo('voir les finances');
        $role->givePermissionTo('see invoices (all time)');
        $role->givePermissionTo('see daily invoices');
        $role->givePermissionTo('see category');

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());
    }
}
