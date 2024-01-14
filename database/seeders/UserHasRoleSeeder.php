<?php

namespace Database\Seeders;

use App\Enums\RoleConstEnum;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $roleId = str_contains($user->email, 'admin') ? RoleConstEnum::ADMIN->value : RoleConstEnum::AUTHOR->value;
            UserHasRole::create([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }
    }
}
