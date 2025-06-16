<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('media_galleries', function (Blueprint $table) {
            $table->string('related_type')->nullable()->after('related_id');
        });
    }

    public function down()
    {
        Schema::table('media_galleries', function (Blueprint $table) {
            $table->dropColumn('related_type');
        });
    }

};
