<?php

namespace Database\Seeders;

use App\Enums\RoleConstEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => RoleConstEnum::ADMIN->value,
                'role_key' => 'admin',
                'role_description' => 'db__admin_desc',
            ],
            [
                'id' => RoleConstEnum::AUTHOR->value,
                'role_key' => 'author',
                'role_description' => 'db__author_desc',
            ],
            [
                'id' => RoleConstEnum::CUSTOMER->value,
                'role_key' => 'customer',
                'role_description' => 'db__customer_desc',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
