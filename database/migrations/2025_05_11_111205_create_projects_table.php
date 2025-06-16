<?php

// database/migrations/[timestamp]_create_projects_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('objectives')->nullable();
            $table->text('impact')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'completed', 'postponed', 'cancelled'])->default('planned');
            $table->boolean('needs_volunteers')->default(false);
            $table->boolean('needs_donations')->default(false);
            $table->timestamps();
        });
    }
 

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
