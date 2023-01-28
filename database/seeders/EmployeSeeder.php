<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Employe',
            'email' => 'employe@gmail.com',
            'password' => bcrypt('employe'),
            'company_id' => 1,
            'phone' => '085210523378',
            'email_verified_at' => now()
        ]);

        $role = Role::create(['name' => 'Employe']);

        $user->assignRole('Employe');

        $permissions = [
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
            'user-profile',
        ];

        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}
