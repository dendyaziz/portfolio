<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('skin_id')->nullable();
            $table->unsignedInteger('board_id')->nullable();
            $table->unsignedInteger('room_master_id')->nullable();
            $table->string('room_name');
            $table->string('password')->nullable();
            $table->tinyInteger('max_player')->default(1);
            $table->timestamp('started_at', 0)->nullable();
            $table->timestamp('ended_at', 0)->nullable();
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
        Schema::dropIfExists('games');
    }
}
