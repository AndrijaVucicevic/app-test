<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            if (str_contains($user->email, 'autor')) {
                Author::create([
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
