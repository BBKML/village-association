<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('time')->nullable();
            $table->integer('available_spots')->nullable();
            $table->boolean('is_featured')->default(false);
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['category', 'time', 'available_spots', 'is_featured']);
        });
    }
}; 