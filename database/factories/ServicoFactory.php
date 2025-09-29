<?php

namespace Database\Factories;

use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Servico::class;

    public function definition(): array
    {

        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'titulo' => $this->faker->sentence(3),
            'tags_padroes' => implode('/', $this->faker->words(3)),
            'resumo' => $this->faker->paragraph(),
            'profissoes' => implode('/', $this->faker->words(2)),
            'qtd_vagas' => $this->faker->numberBetween(1, 3),
            'valor_minimo' => $this->faker->randomFloat(2, 50, 500),
            'valor_maximo' => $this->faker->randomFloat(2, 501, 2000),
            'data_prevista_entrega' => $this->faker->dateTimeBetween('now', '+30 days'),
            'data_maxima_entrega' => $this->faker->dateTimeBetween('+31 days', '+60 days'),
            'status' => $this->faker->numberBetween(1, 3),
            'ativo' => $this->faker->boolean(90),
        ];
    }
}
