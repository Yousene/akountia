<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Exécute le seeding des catégories
     *
     * @return void
     */
    public function run()
    {
        try {
            \DB::beginTransaction();

            $categories = [
                'Développement Informatique & Digital' => [
                    'short' => 'Formez-vous aux technologies du développement web pour créer des sites et applications modernes',
                    'long' => 'Le développement web est au cœur de la transformation digitale des entreprises. Cette catégorie regroupe nos formations en programmation web, du front-end au back-end. Vous y trouverez des modules adaptés à tous les niveaux, que vous soyez débutant ou développeur confirmé souhaitant vous perfectionner. Nos formations couvrent les langages fondamentaux comme HTML, CSS et JavaScript, ainsi que les frameworks modernes tels que React, Angular ou Laravel. Les sessions sont conçues pour être pratiques avec de nombreux exercices et projets concrets. Nous mettons l\'accent sur les bonnes pratiques de développement et la compréhension des concepts plutôt que sur la simple mémorisation du code. Les formateurs, tous professionnels actifs, partagent leur expertise technique et leur expérience du terrain.',
                    'icon_image' => 'developpement-web-informatique-digital.svg',
                    'background_image' => 'developpement-web-informatique-digital.webp',
                    'portrait_image' => 'developpement-web-informatique-digital.webp'
                ],

                'Management des SI & Gestion de Projet' => [
                    'short' => 'Pilotez efficacement vos projets IT et optimisez la gestion de vos systèmes d\'information',
                    'long' => 'Le management des SI et la gestion de projet sont des compétences clés pour assurer le succès des initiatives IT. Cette catégorie regroupe nos formations en gestion de projet informatique et pilotage des systèmes d\'information. Les modules couvrent les méthodologies projet (traditionnelles et agiles), les frameworks de gouvernance IT, et les bonnes pratiques de gestion des services informatiques. Nous mettons l\'accent sur les aspects pratiques et humains du management IT, au-delà des processus et des outils. Les participants apprennent à gérer efficacement les équipes, les budgets et les risques, tout en assurant l\'alignement entre l\'IT et les objectifs business. Les formations s\'appuient sur des cas concrets et des retours d\'expérience réels.',
                    'icon_image' => 'management-des-systemes-dinformation-gestion-de-projet.svg',
                    'background_image' => 'management-des-systemes-dinformation-gestion-de-projet.webp',
                    'portrait_image' => 'management-des-systemes-dinformation-gestion-de-projet.webp'

                ],

                'Cloud, DevOps et Virtualisation' => [
                    'short' => 'Découvrez les technologies cloud et les pratiques DevOps pour moderniser vos infrastructures',
                    'long' => 'Le Cloud Computing et le DevOps transforment profondément la manière dont les entreprises gèrent leurs infrastructures IT. Cette catégorie couvre les technologies et méthodologies essentielles pour cette transformation digitale. Vous y trouverez des formations sur les principales plateformes cloud (AWS, Azure, Google Cloud), les pratiques DevOps, et les solutions de virtualisation. Les modules sont conçus pour être très pratiques, avec des labs et des mises en situation réelles. Nous abordons aussi bien les aspects techniques que méthodologiques, permettant aux participants de comprendre comment ces technologies s\'intègrent dans une stratégie IT globale. Les formations sont régulièrement mises à jour pour suivre l\'évolution rapide de ces technologies et répondre aux besoins concrets des entreprises.',
                    'icon_image' => 'cloud-devops-virtualisation.svg',
                    'background_image' => 'cloud-devops-virtualisation.webp',
                    'portrait_image' => 'cloud-devops-virtualisation.webp'
                ],
                'Sécurité Informatique & Gouvernance IT' => [
                    'short' => 'Apprenez à protéger vos systèmes d\'information et à mettre en place une gouvernance IT efficace',
                    'long' => 'La sécurité informatique et la gouvernance IT sont devenues des enjeux majeurs pour toutes les organisations. Cette catégorie regroupe nos formations en cybersécurité, gestion des risques IT et gouvernance des systèmes d\'information. Les modules couvrent aussi bien les aspects techniques de la sécurité que les dimensions organisationnelles et réglementaires. Vous apprendrez à identifier les menaces, mettre en place des mesures de protection adaptées, et gérer les incidents de sécurité. Nos formations incluent également la mise en conformité avec les normes et réglementations, ainsi que les bonnes pratiques de gouvernance IT. Les sessions sont animées par des experts du domaine qui partagent leur expérience pratique et les dernières tendances du secteur.',
                    'icon_image' => 'securite-informatique-gouvernance-it.svg',
                    'background_image' => 'securite-informatique-gouvernance-it.webp',
                    'portrait_image' => 'securite-informatique-gouvernance-it.webp'
                ],
                'Réseaux & Télécommunication' => [
                    'short' => 'Formez-vous aux technologies des réseaux et télécommunications modernes',
                    'long' => 'Les réseaux et les télécommunications constituent l\'épine dorsale de tout système d\'information moderne. Cette catégorie rassemble nos formations dédiées aux infrastructures réseau, des fondamentaux aux technologies les plus avancées. Les modules couvrent l\'ensemble des aspects essentiels : protocoles réseau, équipements, sécurité, téléphonie IP et solutions de communication unifiée. Nos formations sont fortement orientées pratique, avec des travaux sur équipements réels dans nos laboratoires. Les participants acquièrent une compréhension approfondie des architectures réseau modernes et des compétences pratiques immédiatement applicables. Les cours sont régulièrement actualisés pour intégrer les dernières évolutions technologiques du secteur.',
                    'icon_image' => 'reseaux-telecom.svg',
                    'background_image' => 'reseaux-telecom.webp',
                    'portrait_image' => 'reseaux-telecom.webp'
                ],
                'Base de Données & Big Data, BI' => [
                    'short' => 'Gérez et analysez efficacement vos données pour une meilleure prise de décision',
                    'long' => 'La gestion et l\'analyse des données sont devenues des compétences stratégiques pour les entreprises. Cette catégorie couvre l\'ensemble des technologies et méthodologies liées aux bases de données, au Big Data et à la Business Intelligence. De la conception de bases de données à l\'analyse prédictive, nos formations permettent de maîtriser les outils et techniques essentiels. Les modules abordent aussi bien les bases de données relationnelles traditionnelles que les solutions NoSQL et les technologies Big Data. L\'accent est mis sur les cas d\'usage concrets et les bonnes pratiques, permettant aux participants de comprendre comment transformer les données en insights actionnables. Les formations sont conçues pour être accessibles aux profils techniques comme aux utilisateurs métier.',
                    'icon_image' => 'base-de-donnees-big-data-bi.svg',
                    'background_image' => 'base-de-donnees-big-data-bi.webp',
                    'portrait_image' => 'base-de-donnees-big-data-bi.webp'
                ],
                'Bureautique' => [
                    'short' => 'Maîtrisez les outils bureautiques essentiels pour améliorer votre efficacité professionnelle',
                    'long' => 'La bureautique est un ensemble indispensable de compétences dans le monde professionnel moderne. Cette catégorie rassemble nos formations aux outils bureautiques courants et avancés. De la suite Microsoft Office aux outils collaboratifs, nous proposons des modules adaptés à chaque niveau et besoin professionnel. Nos formations mettent l\'accent sur la pratique et les cas d\'usage réels, permettant une application immédiate en contexte professionnel. Au-delà des fonctionnalités de base, nous abordons les fonctions avancées qui permettent d\'optimiser son travail : automatisation des tâches, analyse de données, création de documents professionnels, et collaboration efficace. Les participants apprennent également les meilleures pratiques en matière d\'organisation et de gestion documentaire numérique.',
                    'icon_image' => 'bureautique.svg',
                    'background_image' => 'bureautique.webp',
                    'portrait_image' => 'bureautique.webp'
                ],

                'Développement Personnel' => [
                    'short' => 'Développez vos soft skills et votre leadership pour une meilleure performance professionnelle',
                    'long' => 'Le développement personnel est un facteur clé de réussite professionnelle dans le monde moderne. Cette catégorie rassemble nos formations axées sur les compétences comportementales et le leadership. Les modules couvrent des aspects essentiels comme la communication, la gestion du stress, le travail en équipe et le management. Nos formations sont conçues pour être interactives et pratiques, avec de nombreux exercices et mises en situation. L\'approche pédagogique favorise l\'apprentissage par l\'expérience et l\'application immédiate des concepts. Les participants développent leur conscience de soi et leurs capacités relationnelles, tout en acquérant des outils concrets pour améliorer leur efficacité professionnelle.',
                    'icon_image' => 'developpement-personnel.svg',
                    'background_image' => 'developpement-personnel.webp',
                    'portrait_image' => 'developpement-personnel.webp'
                ],
                'Qualité, Hygiène, Sécurité, Environnement' => [
                    'short' => 'Maîtrisez les normes et pratiques QHSE pour améliorer la performance de votre organisation',
                    'long' => 'La démarche QHSE est essentielle pour garantir la performance durable des organisations. Cette catégorie regroupe nos formations en Qualité, Hygiène, Sécurité et Environnement. Les modules couvrent les normes et référentiels internationaux, les outils qualité, la prévention des risques et le management environnemental. Nous adoptons une approche pratique, basée sur des cas réels et des retours d\'expérience. Les participants apprennent à mettre en place et piloter des systèmes de management intégrés, à conduire des audits et à gérer des projets d\'amélioration continue. Les formations sont régulièrement mises à jour pour intégrer les évolutions réglementaires et les meilleures pratiques du secteur.',
                    'icon_image' => 'qualite-hygiene-securite-environnement.svg',
                    'background_image' => 'qualite-hygiene-securite-environnement.webp',
                    'portrait_image' => 'qualite-hygiene-securite-environnement.webp'
                ],
                'Comptabilité & Finance' => [
                    'short' => 'Développez vos compétences en gestion financière et comptable pour optimiser la performance de votre entreprise',
                    'long' => 'La maîtrise des aspects financiers et comptables est fondamentale pour la gestion d\'entreprise. Cette catégorie rassemble nos formations en comptabilité, finance et contrôle de gestion. Les modules couvrent aussi bien les fondamentaux que les aspects plus avancés, adaptés aux contextes marocain et international. Nous mettons l\'accent sur la pratique, avec de nombreux cas concrets et l\'utilisation des principaux logiciels du marché. Les participants acquièrent une compréhension approfondie des mécanismes comptables et financiers, ainsi que des compétences pratiques immédiatement applicables. Les formations sont animées par des professionnels expérimentés qui partagent leur expertise du terrain.',
                    'icon_image' => 'comptabilite-finance.svg',
                    'background_image' => 'comptabilite-finance.webp',
                    'portrait_image' => 'comptabilite-finance.webp'
                ],
                'Multimedia' => [
                    'short' => 'Explorez les techniques de création multimédia pour produire des contenus visuels professionnels',
                    'long' => 'Le multimédia est devenu incontournable dans la communication moderne. Cette catégorie regroupe nos formations en création numérique, design graphique et production audiovisuelle. Les modules couvrent l\'utilisation des principaux logiciels créatifs, les techniques de conception graphique, et les principes de la communication visuelle. Nous privilégions une approche pratique, où chaque participant travaille sur des projets concrets correspondant à des besoins réels. Les formations abordent aussi bien les aspects techniques que créatifs, permettant aux participants de développer leur propre style tout en maîtrisant les outils professionnels. Les sessions sont animées par des créatifs expérimentés qui partagent leur expertise et les tendances du secteur.',
                    'icon_image' => 'multimedia.svg',
                    'background_image' => 'multimedia.webp',
                    'portrait_image' => 'multimedia.webp'
                ]
            ];


            foreach ($categories as $categoryName => $data) {
                Category::create([
                    'name' => $categoryName,
                    'link' => Str::slug($categoryName),
                    'short_description' => $data['short'],
                    'description' => $data['long'],
                    'background_image' => 'assets/images/categories/' . $data['background_image'],
                    'icon_image' => 'assets/images/categories/icons/' . $data['icon_image'],
                    'portrait_image' => 'assets/images/categories/portrait/' . $data['portrait_image'],
                    'deleted' => 0,
                    'deleted_at' => null,
                    'deleted_by' => null,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            \DB::commit();
            \Log::info('Categories seeded successfully');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error seeding categories: ' . $e->getMessage());
            throw $e;
        }
    }
}
