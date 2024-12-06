<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ensure that roles and permissions are created first
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'api']);

        // If you already have permissions in the database, you can fetch them like this:
        $permissions = Permission::all();

        // Superadmin user
        $superAdminUser = User::firstOrCreate([
            'name' => 'Super Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
        ]);
        $superAdminUser->assignRole($superAdminRole); // Assign the superadmin role to the superadmin user
        $superAdminUser->givePermissionTo($permissions); // Assign all permissions to the superadmin user



        // Create users and assign roles and permissions
        // Admin user
        $adminUser = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole); // Assign the admin role to the admin user
        $adminUser->givePermissionTo($permissions); // Assign all permissions to the admin user

    }

}
