<?php

// database/migrations/[timestamp]_create_local_services_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('local_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['commerçant', 'artisan', 'médical', 'école', 'autre']);
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('local_services');
    }
};
