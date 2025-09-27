<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientSeeder
 * @package Database\Seeders
 */
class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tronquer la table clients avant d'insérer les nouvelles données
        DB::table('clients')->truncate();

        $clients = [
            [
                'name' => 'Danone',
                'icon_image' => 'assets/images/clients/icons/danone.webp',
                'image' => 'assets/images/clients/danone.webp',
                'link' => 'https://www.danone.com/',
                'is_priority' => true,
            ],
            [
                'name' => 'Kuehne + Nagel',
                'icon_image' => 'assets/images/clients/icons/kuehne-nagel.webp',
                'image' => 'assets/images/clients/kuehne-nagel.webp',
                'link' => 'https://www.kuehne-nagel.com/',
                'is_priority' => true,
            ],
            [
                'name' => 'Agence nationale de l\'aviation civile',
                'icon_image' => 'assets/images/clients/icons/agence-nationale-de-laviation-civile.webp',
                'image' => 'assets/images/clients/agence-nationale-de-laviation-civile.webp',
                'link' => 'https://www.anac.ml/',
                'is_priority' => false,
            ],
            [
                'name' => 'Pharma 5',
                'icon_image' => 'assets/images/clients/icons/pharma5.webp',
                'image' => 'assets/images/clients/pharma5.webp',
                'link' => 'https://www.pharma5.ma/',
                'is_priority' => false,
            ],
            [
                'name' => 'BOAD',
                'icon_image' => 'assets/images/clients/icons/boad.webp',
                'image' => 'assets/images/clients/boad.webp',
                'link' => 'https://www.boad.org/',
                'is_priority' => false,
            ],
            [
                'name' => 'BMS',
                'icon_image' => 'assets/images/clients/icons/bms.webp',
                'image' => 'assets/images/clients/bms.webp',
                'link' => 'https://www.bms.com/',
                'is_priority' => false,
            ],
            [
                'name' => 'JTI',
                'icon_image' => 'assets/images/clients/icons/jti.webp',
                'image' => 'assets/images/clients/jti.webp',
                'link' => 'https://www.jti.com/',
                'is_priority' => false,
            ],
            [
                'name' => 'PMU Mali',
                'icon_image' => 'assets/images/clients/icons/pmu-mali.webp',
                'image' => 'assets/images/clients/pmu-mali.webp',
                'link' => 'https://www.pmu-mali.ml/',
                'is_priority' => false,
            ],
            [
                'name' => 'UNICEF',
                'icon_image' => 'assets/images/clients/icons/unicef.webp',
                'image' => 'assets/images/clients/unicef.webp',
                'link' => 'https://www.unicef.org/',
                'is_priority' => false,
            ],
            [
                'name' => 'UM6P',
                'icon_image' => 'assets/images/clients/icons/um6p.webp',
                'image' => 'assets/images/clients/um6p.webp',
                'link' => 'https://www.um6p.ma/',
                'is_priority' => false,
            ],
            [
                'name' => 'Caisse Malienne de Sécurité Sociale',
                'icon_image' => 'assets/images/clients/icons/caisse-malienne-de-sécurité-sociale.webp',
                'image' => 'assets/images/clients/caisse-malienne-de-sécurité-sociale.webp',
                'link' => 'https://www.cmss.ml/',
                'is_priority' => false,
            ],
            [
                'name' => 'Banque des États de l\'Afrique Centrale',
                'icon_image' => 'assets/images/clients/icons/banque-des-etats-de-lafrique-centrale.webp',
                'image' => 'assets/images/clients/banque-des-etats-de-lafrique-centrale.webp',
                'link' => 'https://www.beac.int/',
                'is_priority' => true,
            ],
            [
                'name' => 'Central Bank of Mauritania',
                'icon_image' => 'assets/images/clients/icons/central-bank-of-mauritania.webp',
                'image' => 'assets/images/clients/central-bank-of-mauritania.webp',
                'link' => 'http://www.bcm.mr/',
                'is_priority' => false,
            ],
        ];

        foreach ($clients as $client) {
            Client::create([
                'name' => $client['name'],
                'icon_image' => $client['icon_image'],
                'image' => $client['image'],
                'link' => $client['link'],
                'is_priority' => $client['is_priority'],
                'deleted' => 0,
                'deleted_at' => null,
                'deleted_by' => null,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
