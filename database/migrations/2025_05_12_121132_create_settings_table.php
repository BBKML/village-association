<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insertion des paramètres par défaut
        $defaultSettings = [
            [
                'key' => 'site_name',
                'value' => 'Mon Application Municipale',
                'type' => 'text',
                'description' => 'Nom officiel du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_description',
                'value' => 'Plateforme officielle de notre municipalité',
                'type' => 'text',
                'description' => 'Description générale du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'contact_email',
                'value' => 'contact@mairie.fr',
                'type' => 'text',
                'description' => 'Email de contact principal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'contact_phone',
                'value' => '+33 1 23 45 67 89',
                'type' => 'text',
                'description' => 'Numéro de téléphone de contact',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Mode maintenance du site',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'logo',
                'value' => null,
                'type' => 'file',
                'description' => 'Logo du site',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('settings')->insert($defaultSettings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}