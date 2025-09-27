<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Le modèle correspondant au factory.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Définir l'état par défaut du modèle.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genre = $this->faker->randomElement(['Homme', 'Femme']);
        $picture = $genre === 'Femme' ? 'default-female.webp' : 'default-male.webp';

        return [
            'name' => $this->faker->name($genre === 'Homme' ? 'male' : 'female'),
            'company' => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
            'rating' => $this->faker->randomElement([1.0, 1.5, 2.0, 2.5, 3.0, 3.5, 4.0, 4.5, 5.0]), // Notes par incréments de 0.5
            'validation' => $this->faker->boolean(80), // 80% de chance d'être validé
            'comment' => $this->faker->realText(150),
            'genre' => $genre,
            'picture' => 'assets/images/reviews/' . $picture,
            'course_id' => function () {
                return \App\Models\Course::where('deleted', 0)->inRandomOrder()->first()->id;
            },
            'deleted' => 0,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * État pour une review non validée.
     */
    public function unvalidated(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'validation' => false
            ];
        });
    }

    /**
     * État pour une review avec une note excellente.
     */
    public function excellent(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => 5.0,
                'validation' => true,
                'comment' => $this->faker->randomElement([
                    "Formation exceptionnelle ! Le contenu est très complet et parfaitement structuré.",
                    "Une expérience d'apprentissage incroyable. Je recommande vivement !",
                    "Excellente formation qui m'a permis d'acquérir de nouvelles compétences essentielles.",
                ])
            ];
        });
    }

    /**
     * État pour une review avec une note moyenne.
     */
    public function average(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->randomFloat(1, 3.0, 3.5),
                'validation' => true,
                'comment' => $this->faker->randomElement([
                    "Formation correcte mais pourrait être plus approfondie.",
                    "Contenu intéressant mais présentation moyenne.",
                    "Formation satisfaisante dans l'ensemble.",
                ])
            ];
        });
    }
}
