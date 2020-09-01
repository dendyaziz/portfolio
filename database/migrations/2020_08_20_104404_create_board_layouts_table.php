<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_layouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('square_id');
            $table->unsignedInteger('next_square_order_id')->nullable();
            $table->unsignedInteger('turn_square_order_id')->nullable();
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
        Schema::dropIfExists('board_layouts');
    }
}
