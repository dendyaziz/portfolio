<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameStealPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_steal_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('game_movement_id')->nullable();
            $table->unsignedInteger('target_player_id')->nullable();
            $table->unsignedInteger('lose_point_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_steal_points');
    }
}
