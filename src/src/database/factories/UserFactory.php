<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            // Contraseña por defecto: password
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            
            // Campos específicos de HuelvaNotes
            'puntos' => 100,
            'centro_id' => null, // Lo asignaremos de forma aleatoria en el Seeder
        ];
    }
}
