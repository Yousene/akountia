<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statut;

class StatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            \DB::beginTransaction();

            Statut::create([
                'label' => 'Non définie',
                'color' => '#808080',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            Statut::create([
                'label' => 'Nouveau',
                'color' => '#3498db',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Statut::create([
                'label' => 'En cours',
                'color' => '#f1c40f',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            Statut::create([
                'label' => 'Traité',
                'color' => '#2ecc71',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \DB::commit();
            \Log::info('Statuts créés avec succès');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Erreur lors de la création des statuts : ' . $e->getMessage());
            throw $e;
        }
    }
}
