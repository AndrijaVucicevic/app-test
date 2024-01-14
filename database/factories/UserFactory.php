<?php

namespace Database\Factories;

use App\Enums\RoleConstEnum;
use App\Models\Author;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('demodemo'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [

            ];
        })->afterCreating(function (User $user) {
            UserHasRole::create([
                'user_id' => $user->id,
                'role_id' => RoleConstEnum::ADMIN->value,
            ]);
        });
    }

    public function author()
    {
        return $this->state(function (array $attributes) {
            return [

            ];
        })->afterCreating(function (User $user) {
            UserHasRole::create([
                'user_id' => $user->id,
                'role_id' => RoleConstEnum::AUTHOR->value,
            ]);
            Author::create([
                'user_id' => $user->id
            ]);
        });
    }


    public function customer()
    {
        return $this->state(function (array $attributes) {
            return [

            ];
        })->afterCreating(function (User $user) {
            UserHasRole::create([
                'user_id' => $user->id,
                'role_id' => RoleConstEnum::CUSTOMER->value,
            ]);
        });
    }
}
