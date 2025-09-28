<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Apparence};
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
        ]);



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
