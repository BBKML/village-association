<?php

// database/seeders/InitialDataSeeder.php
namespace Database\Seeders;

use App\Models\Association;
use App\Models\History;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Données de l'association
        Association::create([
            'name' => 'Association du Village',
            'description' => 'L\'association du village a pour but de promouvoir les activités locales et de préserver notre patrimoine.',
            'objectives' => json_encode([
                'Promouvoir les activités culturelles',
                'Maintenir les traditions locales',
                'Améliorer la vie communautaire',
                'Organiser des événements'
            ]),
            'main_image' => null
        ]);

        // Historique du village
        History::create([
            'title' => 'Histoire de notre village',
            'content' => 'Notre village a été fondé en 1850 par...',
            'image' => null,
            'founder_name' => 'Jean Dupont',
            'founder_description' => 'Fondateur visionnaire qui a établi les bases de notre communauté.'
        ]);

        // Ajoutez d'autres données initiales selon vos besoins
    }
}
