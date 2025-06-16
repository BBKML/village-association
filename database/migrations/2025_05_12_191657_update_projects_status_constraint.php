<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
  {
    if (DB::getDriverName() === 'sqlite') {
        // Désactiver temporairement les contraintes FOREIGN KEY pour SQLite
        DB::statement('PRAGMA foreign_keys=off;');
        
        // Créer une nouvelle table temporaire sans la contrainte CHECK
        Schema::create('projects_temp', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status')->default('planned');
            $table->string('image')->nullable();
            $table->boolean('needs_volunteers')->default(false);
            $table->boolean('needs_donations')->default(false);
            $table->timestamps();
        });
        
        // Copier les données
        DB::statement('INSERT INTO projects_temp SELECT * FROM projects;');
        
        // Supprimer l'ancienne table
        Schema::drop('projects');
        
        // Renommer la table temporaire
        Schema::rename('projects_temp', 'projects');
        
        // Réactiver les contraintes
        DB::statement('PRAGMA foreign_keys=on;');
    }
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
