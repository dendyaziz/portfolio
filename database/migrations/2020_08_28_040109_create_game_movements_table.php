<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('game_id')->nullable();
            $table->unsignedInteger('step_id')->nullable();
            $table->unsignedInteger('player_id')->nullable();
            $table->unsignedInteger('point_id')->nullable();
            $table->tinyInteger('die_number')->nullable();
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
        Schema::dropIfExists('game_movements');
    }
}
