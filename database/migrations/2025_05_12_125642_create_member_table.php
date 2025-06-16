<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('joined_date')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_board_member')->default(false);
            $table->foreignId('association_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};