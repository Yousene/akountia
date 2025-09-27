<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Statut;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Le modèle associé à la factory.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Définit l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Récupérer un statut aléatoire existant
        $statut = Statut::inRandomOrder()->first();

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->paragraph(),
            'statut' => $statut ? $statut->id : null,
            'deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
            'created_by' => 1,
            'updated_by' => null,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    /**
     * Indique que le contact est supprimé.
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
