<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Définition des menus principaux avec leurs ordres
        // Vider la table menus avant d'insérer les nouvelles données
        DB::table('menus')->truncate();
        $mainMenus = [
            'Tableaux de bord' => ['id' => 1, 'page' => 'admin', 'icon' => 'home-circle'],
            'Sécurité' => ['id' => 18, 'page' => null, 'icon' => 'check-shield'],
            'Paramétrage' => ['id' => 19, 'page' => null, 'icon' => 'cog'],
        ];

        // Définition des sous-menus avec leurs parents
        $subMenus = [
            'Sécurité' => [
                ['id' => 3, 'titre' => 'Utilisateurs', 'page' => 'user.index', 'icon' => 'people'],
                ['id' => 4, 'titre' => 'Rôles', 'page' => 'role_list', 'icon' => 'check_box'],
                ['id' => 5, 'titre' => 'Permissions', 'page' => 'permission.index', 'icon' => 'check_box'],
            ],
            'Paramétrage' => [
                ['id' => 7, 'titre' => 'Gestion du menu', 'page' => 'menu_list', 'icon' => 'dehaze'],
                ['id' => 8, 'titre' => 'Apparence', 'page' => 'apparence_list', 'icon' => 'dehaze'],
                ['id' => 9, 'titre' => 'Fonctionnalités', 'page' => 'fonctionnalite_list', 'icon' => 'dehaze'],
                ['id' => 10, 'titre' => 'Société', 'page' => 'company.index', 'icon' => 'dehaze'],
            ],
        ];

        try {
            DB::beginTransaction();

            // Insertion des menus principaux
            $mainOrder = 1;
            foreach ($mainMenus as $titre => $menu) {
                DB::table('menus')->insert([
                    'id' => $menu['id'],
                    'titre' => $titre,
                    'page' => $menu['page'],
                    'parent_menu' => null,
                    'ordre' => $mainOrder++,
                    'ressource' => null,
                    'statut' => '1',
                    'icon' => $menu['icon'],
                    'roles' => null,
                    'desc' => $menu['desc'] ?? null,
                    'deleted' => 0,
                    'deleted_at' => null,
                    'deleted_by' => null,
                    'created_by' => null,
                    'updated_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insertion des sous-menus
            foreach ($subMenus as $parentTitre => $children) {
                $parentId = collect($mainMenus)->filter(function ($menu, $titre) use ($parentTitre) {
                    return $titre === $parentTitre;
                })->first()['id'];

                $subOrder = 1;
                foreach ($children as $subMenu) {
                    DB::table('menus')->insert([
                        'id' => $subMenu['id'],
                        'titre' => $subMenu['titre'],
                        'page' => $subMenu['page'],
                        'parent_menu' => $parentId,
                        'ordre' => $subOrder++,
                        'ressource' => null,
                        'statut' => '1',
                        'icon' => $subMenu['icon'],
                        'roles' => null,
                        'desc' => null,
                        'deleted' => 0,
                        'deleted_at' => null,
                        'deleted_by' => null,
                        'created_by' => null,
                        'updated_by' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erreur lors du seeding des menus : ' . $e->getMessage());
            throw $e;
        }
    }
}
