<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class ReviewTableSeeder extends Seeder
{
    /**
     * Exécuter le seeding de la base de données.
     *
     * @return void
     * @throws Exception Si une erreur survient pendant le seeding
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $courses = Course::where('deleted', 0)->get();

            if ($courses->isEmpty()) {
                Log::warning('Aucun cours trouvé pour créer des reviews');
                return;
            }

            foreach ($courses as $course) {
                Log::info("Création des reviews pour le cours ID: {$course->id}");

                // 5-10 reviews par cours
                $count = rand(1, 3);

                // 60% excellentes
                $this->createReviews(
                    $course,
                    ceil($count * 0.6),
                    'excellent',
                    [4.5, 5.0]
                );

                // 30% moyennes
                $this->createReviews(
                    $course,
                    ceil($count * 0.3),
                    'average',
                    [3.0, 3.5, 4.0]
                );

                // 10% non validées
                $this->createReviews(
                    $course,
                    ceil($count * 0.1),
                    'unvalidated',
                    [1.0, 1.5, 2.0, 2.5]
                );
            }

            DB::commit();
            Log::info('Seeding des reviews terminé avec succès');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors du seeding des reviews: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Créer un nombre spécifique de reviews pour un cours
     *
     * @param Course $course Le cours pour lequel créer les reviews
     * @param int $count Nombre de reviews à créer
     * @param string $type Type de review (excellent, average, unvalidated)
     * @param array $ratings Tableau des notes possibles
     * @return void
     */
    private function createReviews(Course $course, int $count, string $type, array $ratings): void
    {
        Review::factory()
            ->count($count)
            ->$type()
            ->create([
                'course_id' => $course->id,
                'rating' => fake()->randomElement($ratings)
            ]);
    }
}
