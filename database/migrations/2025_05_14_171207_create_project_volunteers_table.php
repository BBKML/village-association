<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{public function up()
{
    Schema::create('project_volunteers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->text('skills')->nullable();
        $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
        $table->timestamps();
        
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('project_volunteers');
}

};
