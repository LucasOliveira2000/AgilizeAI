<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'nome_social' => $this->faker->optional()->firstName(),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'cep' => $this->faker->numerify('#####-###'),
            'endereco' => $this->faker->streetAddress(),
            'rua' => $this->faker->streetName(),
            'bairro' => $this->faker->citySuffix(),
            'numero' => $this->faker->buildingNumber(),
            'complemento' => $this->faker->optional()->word(),
            'tipo' => $this->faker->randomElement([1, 2, 3]),
            'ativo' => true,
            'profissao_principal' => $this->faker->jobTitle(),
            'profissoes_extras' => $this->faker->optional()->jobTitle(),
            'nivel' => $this->faker->numberBetween(1, 5),
            'estrela' => $this->faker->boolean(),
            'password' => Hash::make('SenhaForte@123'),
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
}
