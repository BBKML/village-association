<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddOrderAndAltTextColumnsToMediaItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_items', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('caption');
            $table->string('alt_text')->nullable()->after('order');
        });

        // Mettre à jour l'ordre des éléments existants avec SQLite
        // SQLite ne supporte pas ROW_NUMBER donc on fait simple ici
        $mediaItems = DB::table('media_items')
            ->orderBy('gallery_id')
            ->orderBy('created_at')
            ->get();

        $currentGallery = null;
        $order = 1;

        foreach ($mediaItems as $item) {
            if ($item->gallery_id !== $currentGallery) {
                $currentGallery = $item->gallery_id;
                $order = 1;
            }

            DB::table('media_items')
                ->where('id', $item->id)
                ->update(['order' => $order]);

            $order++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_items', function (Blueprint $table) {
            $table->dropColumn(['order', 'alt_text']);
        });
    }
}
