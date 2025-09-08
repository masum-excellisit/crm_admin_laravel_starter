<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Dashboard
            'view-dashboard',

            // Admin Management
            'view-admins',
            'create-admins',
            'edit-admins',
            'delete-admins',

            // Customer Management
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',

            // Role Management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to ADMIN role
        $adminRole = Role::where('name', 'ADMIN')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }



        // Assign specific permissions to COURSE_MANAGER role
        $courseManagerRole = Role::where('name', 'MANAGER')->first();
        if ($courseManagerRole) {
            $courseManagerPermissions = [
                'view-dashboard',
            ];
            $courseManagerRole->givePermissionTo($courseManagerPermissions);
        }
    }
}
