<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'phone' => '085210523378',
            'email_verified_at' => now()
        ]);

        $role = Role::create(['name' => 'Admin']);

        $user->assignRole('Admin');

        $permissions = [
            'dashboard-access',
            'category-access',
            'category-create',
            'category-show',
            'category-edit',
            'category-delete',
            'company-access',
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

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}
