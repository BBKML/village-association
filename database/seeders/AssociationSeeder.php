<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Association;

class AssociationSeeder extends Seeder
{
    public function run()
    {
        Association::create([
            'name' => 'Association du Village',
            'description' => 'Notre association est dédiée à l\'amélioration de la vie dans notre village et au renforcement des liens entre les habitants.',
            'objectives' => "- Promouvoir la solidarité entre les habitants\n- Organiser des événements culturels et festifs\n- Préserver et valoriser notre patrimoine local\n- Soutenir les initiatives locales",
            'main_image' => 'default/association.jpg'
        ]);
    }
} 