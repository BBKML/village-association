<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Utilisation de DB au lieu du modèle
use Illuminate\Support\Str;

class AddSlugToHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histories', function (Blueprint $table) {
            if (!Schema::hasColumn('histories', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
        });

        // Générer les slugs pour les entrées existantes sans utiliser Eloquent
        $histories = DB::table('histories')->get();

        foreach ($histories as $history) {
            DB::table('histories')
                ->where('id', $history->id)
                ->update(['slug' => Str::slug($history->title)]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('histories', function (Blueprint $table) {
            if (Schema::hasColumn('histories', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
}
