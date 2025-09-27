<?php

namespace Database\Factories;

use App\Models\CourseFaq;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFaqFactory extends Factory
{
    protected $model = CourseFaq::class;

    public function definition()
    {
        $questions = [
            'Quels sont les prérequis pour suivre cette formation ?',
            'Cette formation est-elle accessible à distance ?',
            'Y a-t-il un certificat à la fin de la formation ?',
            'Quelle est la durée moyenne pour compléter la formation ?',
            'La formation est-elle adaptée aux débutants ?',
            'Y a-t-il un support pédagogique fourni ?',
            'Quelles sont les modalités de paiement ?',
            'Est-ce que je peux suivre cette formation en parallèle de mon activité professionnelle ?',
            'Quels sont les débouchés après cette formation ?',
            'Y a-t-il un suivi post-formation ?'
        ];

        return [
            'question' => $this->faker->randomElement($questions),
            'answer' => $this->faker->paragraph(3),
            'order' => $this->faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
