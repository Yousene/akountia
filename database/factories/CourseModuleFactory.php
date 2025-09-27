<?php

namespace Database\Factories;

use App\Models\CourseModule;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseModuleFactory extends Factory
{
    protected $model = CourseModule::class;

    private function generateBulletPoints(): string
    {
        $points = [];
        $numberOfPoints = rand(3, 6);

        $sections = [
            "Comprendre les concepts fondamentaux",
            "Maîtriser les outils essentiels",
            "Mettre en pratique les connaissances acquises",
            "Analyser et optimiser les performances",
            "Configurer et personnaliser l'environnement",
            "Développer des solutions avancées",
            "Gérer les aspects de sécurité",
            "Implémenter les bonnes pratiques",
            "Explorer les fonctionnalités avancées",
            "Intégrer avec d'autres systèmes",
            "Automatiser les processus clés",
            "Résoudre les problèmes courants"
        ];

        for ($i = 0; $i < $numberOfPoints; $i++) {
            $points[] = $this->faker->randomElement($sections) . " " .
                $this->faker->words(rand(3, 6), true) . ".";
        }

        // Utiliser deux sauts de ligne pour séparer les sections
        return implode("\n\n", $points);
    }

    public function definition()
    {
        $topics = [
            "Introduction à",
            "Les fondamentaux de",
            "Configuration avancée de",
            "Optimisation et performance de",
            "Gestion et administration de",
            "Développement avec",
            "Sécurité et maintenance de",
            "Architecture et conception de",
            "Intégration et déploiement de",
            "Bonnes pratiques pour"
        ];

        $technologies = [
            "l'Architecture Cloud",
            "la Virtualisation",
            "la Conteneurisation",
            "l'Intelligence Artificielle",
            "le Machine Learning",
            "la Cybersécurité",
            "le DevOps",
            "l'Infrastructure as Code",
            "la Gestion de Projet Agile",
            "l'Automatisation des Tests"
        ];

        $title = "" . $this->faker->randomElement($topics) . " " .
            $this->faker->randomElement($technologies);

        return [
            'title' => $title,
            'content' => $this->generateBulletPoints(),
            'order' => $this->faker->numberBetween(1, 10)
        ];
    }
}
