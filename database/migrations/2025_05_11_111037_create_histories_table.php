<?php

// database/migrations/[timestamp]_create_histories_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // database/migrations/xxxx_create_histories_table.php
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->string('founder_name')->nullable();
            $table->text('founder_description')->nullable();
            $table->timestamps();
            
            $table->index('slug');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('histories');
    }
};