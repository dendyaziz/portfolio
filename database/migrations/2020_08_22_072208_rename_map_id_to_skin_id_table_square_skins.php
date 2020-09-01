<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMapIdToSkinIdTableSquareSkins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('square_skins', function (Blueprint $table) {
            $table->renameColumn('map_id', 'skin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('square_skins', function (Blueprint $table) {
            $table->renameColumn('skin_id', 'map_id');
        });
    }
}
