<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'create student']);
        Permission::create(['name' => 'edit student']);
        Permission::create(['name' => 'delete student']);
        Permission::create(['name' => 'view student']);
        Permission::create(['name' => 'view all students']);

        // Create roles
        $supervisor = Role::create(['name' => 'supervisor ']);
        $admin = Role::create(['name' => 'admin']);

        // Assign permissions to roles
        $supervisor->givePermissionTo(['create student', 'edit student','view student','view all students']);
        $admin->givePermissionTo(['create student', 'edit student', 'delete student','view student','view all students']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Delete all roles and permissions
        Role::where('name', 'supervisor')->delete();
        Role::where('name', 'admin')->delete();
        Permission::where('name', 'create student')->delete();
        Permission::where('name', 'edit student')->delete();
        Permission::where('name', 'delete student')->delete();
        Permission::where('name', 'view student')->delete();
        Permission::where('name', 'view all students')->delete();
    }
}
