<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        foreach ($permissions as $permission){
            $permission->delete();
        }

        $permissionArray = [
            'report-access',
            'dashboard-access',
            'category-access',
            'category-create',
            'category-show',
            'category-edit',
            'category-delete',
            'cashbook-access',
            'cashbook-create',
            'cashbook-show',
            'cashbook-edit',
            'cashbook-delete',
            'company-access',
            'company-profile',
            'company-create',
            'company-show',
            'company-edit',
            'company-delete',
            'role-access',
            'role-create',
            'role-show',
            'role-edit',
            'role-delete',
            'permission-access',
            'permission-create',
            'permission-show',
            'permission-edit',
            'permission-delete',
            'user-profile',
            'user-access',
            'user-create',
            'user-show',
            'user-edit',
            'user-delete'
        ];

        foreach ($permissionArray as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
