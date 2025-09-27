<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{Course, Category, User, Apparence, Client, CourseModule, CourseFaq, Contact, Lead};

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            ApparencesSeeder::class,
            StatutSeeder::class,
            CategorySeeder::class,
            ClientSeeder::class,
        ]);
        // Client::factory(16)->create()->each(function ($client, $index) {
        //     // Les 3 premiers clients seront prioritaires
        //     if ($index < 3) {
        //         $client->update(['is_priority' => true]);
        //     }
        // });

        // Récupérer les catégories existantes pour créer les cours
        $categories = Category::all();

        foreach ($categories as $category) {
            // Réduire à entre 2 et 5 cours par catégorie
            Course::factory(rand(10, 15))->create([
                'category_id' => $category->id
            ])->each(function ($course) {
                // Créer entre 3 et 8 modules pour chaque cours
                CourseModule::factory(rand(3, 8))->create([
                    'course_id' => $course->id
                ]);

                // Créer entre 3 et 5 FAQs pour chaque cours
                CourseFaq::factory(rand(3, 5))->create([
                    'course_id' => $course->id
                ]);
            });
        }

        // Créer 10 contacts
        Contact::factory()->count(10)->create();

        // Créer 50 leads
        Lead::factory(50)->create();

        // Génération des permissions
        Artisan::call('scan:permissions');

        // Ajout de toutes les permissions au rôle administrateur
        $permissions = DB::table('permissions')->pluck('id'); // Récupérer toutes les permissions
        foreach ($permissions as $permission) {
            DB::table('rolepermissions')->insert([
                'role_id' => 1, // ID du rôle administrateur
                'permission_id' => $permission,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
