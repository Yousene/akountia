<?php

namespace Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => 1,
            'type' => 1,
            'client' => null,
            'employe' => 2,
            'login' => 'admin',
            'password' => Hash::make('12345678'), // Consider Hash::make('password') for hashing password
            'name' => 'Admin',
            'first_name' => 'Admin',
            'email' => '',
            'email_verified_at' => null,
            'remember_token' => null,
            'confirmation_token' => null,
            'photo' => 'profil.jpg',
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-02-01 11:56:49'),
            'created_by' => null,
            'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-21 19:21:19'),
            'updated_by' => null,
            'deleted' => 0,
            'deleted_at' => null,
            'deleted_by' => null,
            'activated_at' => null,
            'activated_by' => null,
            'validated' => 1,
            'validated_at' => null,
            'validated_by' => null
        ]);
        DB::table('roles')->insert([
            [
                'role' => 'Administrateur',
                'label' => 'Administrateur',
                'desc' => null,
                'color' => "primary",
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-02-26 07:51:58'),
                'created_by' => null,
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-02-26 07:51:58'),
                'updated_by' => null,
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
            ],
        ]);

        DB::table('quickyprojects')->insert([
            [
                'name' => 'User',
                'id_project' => 'User',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:56:38'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:56:38'),
            ],
            [
                'name' => 'Role',
                'id_project' => 'Role',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:56:52'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:56:52'),
            ],
            [
                'name' => 'Menu',
                'id_project' => 'Menu',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:57:12'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:57:12'),
            ],
            [
                'name' => 'Apparence',
                'id_project' => 'Apparence',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:59:35'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:59:35'),
            ],
            [
                'name' => 'Ressource',
                'id_project' => 'Ressource',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:59:58'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 00:59:58'),
            ],
            [
                'name' => 'Fonctionnalite',
                'id_project' => 'Fonctionnalite',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:15'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:15'),
            ],
            [
                'name' => 'Quickyproject',
                'id_project' => 'Quickyproject',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
            ], [
                'name' => 'Permission',
                'id_project' => 'Permission',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
            ], [
                'name' => 'Rolepermission',
                'id_project' => 'Rolepermission',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
            ], [
                'name' => 'Company',
                'id_project' => 'Company',
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2023-07-23 01:00:33'),
            ],
        ]);


    }
}
