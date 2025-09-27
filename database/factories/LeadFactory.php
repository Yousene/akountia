<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Statut;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour le modèle Lead
 */
class LeadFactory extends Factory
{
    /**
     * Le modèle associé à la factory
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Définit l'état par défaut du modèle
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Particulier', 'Entreprise']),
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'email' => $this->faker->safeEmail(),
            'city' => $this->faker->randomElement(['Casablanca', 'Rabat', 'Reste du monde']),
            'course' => $this->faker->sentence(3),
            'category' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
            'created_by' => 1,
            'updated_by' => null,
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
            'statut' => Statut::inRandomOrder()->first()->id ?? null,
        ];
    }

    /**
     * Indique que le lead est supprimé
     */
    public function deleted(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted' => 1,
                'deleted_at' => now(),
                'deleted_by' => 1,
            ];
        });
    }
}
