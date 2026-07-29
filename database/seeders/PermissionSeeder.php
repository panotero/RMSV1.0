<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\SettingRole;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seeds the permission keys that exist so far. This table is meant
     * to grow incrementally as each module adopts permission-gating -
     * it isn't meant to be fully populated up front.
     */
    public function run(): void
    {
        $permissions = [
            ['key' => 'roles.manage', 'label' => 'Manage roles & permissions', 'module' => 'Roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['key' => $permission['key']],
                ['label' => $permission['label'], 'module' => $permission['module']]
            );
        }

        // superadmin gets everything seeded so far by default - assign
        // additional permissions to other roles via the Roles panel on the
        // Users Management page as the permission list grows.
        $superadmin = SettingRole::where('role_name', 'superadmin')->first();

        if ($superadmin) {
            $superadmin->permissions()->syncWithoutDetaching(
                Permission::whereIn('key', array_column($permissions, 'key'))->pluck('id')
            );
        }
    }
}
