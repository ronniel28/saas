<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Services\RoleService;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN (Global)
        |--------------------------------------------------------------------------
        */

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | COMPANY 1
        |--------------------------------------------------------------------------
        */

        $company1 = Company::create([
            'name' => 'Alpha Corp',
            'slug' => 'alpha-corp',
            'email' => 'alpha@example.com',
        ]);

        RoleService::seedCompanyRoles($company1);

        $owner1 = User::create([
            'company_id' => $company1->id,
            'name' => 'Alpha Owner',
            'email' => 'owner@alpha.com',
            'password' => Hash::make('password'),
        ]);

        $owner1->assignRole('Owner');

        $admin1 = User::create([
            'company_id' => $company1->id,
            'name' => 'Alpha Admin',
            'email' => 'admin@alpha.com',
            'password' => Hash::make('password'),
        ]);

        $admin1->assignRole('Admin');

        $member1 = User::create([
            'company_id' => $company1->id,
            'name' => 'Alpha Member',
            'email' => 'member@alpha.com',
            'password' => Hash::make('password'),
        ]);

        $member1->assignRole('Member');

        /*
        |--------------------------------------------------------------------------
        | COMPANY 2
        |--------------------------------------------------------------------------
        */

        $company2 = Company::create([
            'name' => 'Beta LLC',
            'slug' => 'beta-llc',
            'email' => 'beta@example.com',
        ]);

        RoleService::seedCompanyRoles($company2);

        $owner2 = User::create([
            'company_id' => $company2->id,
            'name' => 'Beta Owner',
            'email' => 'owner@beta.com',
            'password' => Hash::make('password'),
        ]);

        $owner2->assignRole('Owner');

        User::create([
            'company_id' => $company2->id,
            'name' => 'Beta Member',
            'email' => 'member@beta.com',
            'password' => Hash::make('password'),
        ])->assignRole('Member');
    }
}
