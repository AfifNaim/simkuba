<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => bcrypt('manager'),
            'company_id' => 1,
            'phone' => '085210523378',
            'email_verified_at' => now()
        ]);

        $role = Role::create(['name' => 'Manager']);

        $user->assignRole('Manager');

        $permissions = [
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
            'company-profile',
            'company-create',
            'company-show',
            'company-edit',
            'company-delete',
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
