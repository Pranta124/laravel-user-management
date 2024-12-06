<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = ['user-create', 'user-update', 'user-list', 'user-view', 'user-delete'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission, // permission name
                'guard_name' => 'api', // set guard_name to 'api'
            ]);
        }

        // Create roles
        $superAdmin = Role::create(['name' => 'superadmin','guard_name' => 'api']);
        $admin = Role::create(['name' => 'admin','guard_name' => 'api']);
        $user = Role::create(['name' => 'user','guard_name' => 'api']);

        // Assign permissions to superadmin and admin roles
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(Permission::all());

        // Normal user role will not get all permissions by default
        $user->givePermissionTo('user-create', 'user-update', 'user-list', 'user-view', 'user-delete');


    }
}
