<?php

// database/migrations/[timestamp]_create_news_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->timestamp('published_at');
        $table->string('image')->nullable();
        $table->boolean('is_published')->default(false);
        $table->boolean('is_featured')->default(false);  // Vérifier cette ligne
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
