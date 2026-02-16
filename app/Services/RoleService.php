<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public static function seedCompanyRoles($company)
    {
        $permissions = collect([
            'manage_projects',
            'manage_tasks',
            'manage_users'
        ]);

        $permissionModels = $permissions->map(
            fn (string $permission) => Permission::findOrCreate($permission, 'sanctum')
        );

        // Spatie roles are globally unique per guard unless teams mode is enabled.
        // Use global roles here so repeated seeding per company stays idempotent.
        $owner = Role::findOrCreate('Owner', 'sanctum');

        $owner->syncPermissions($permissionModels);

        $admin = Role::findOrCreate('Admin', 'sanctum');

        $admin->syncPermissions(
            $permissionModels->whereIn('name', ['manage_projects', 'manage_tasks'])
        );

        Role::findOrCreate('Member', 'sanctum');
    }
}
