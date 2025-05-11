<?php

// database/migrations/[timestamp]_create_media_galleries_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['activity', 'project', 'event', 'other']);
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();
        });

        Schema::create('media_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->string('file_path');
            $table->string('file_type'); // image, video
            $table->string('caption')->nullable();
            $table->timestamps();

            $table->foreign('gallery_id')->references('id')->on('media_galleries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('media_items');
        Schema::dropIfExists('media_galleries');
    }
};