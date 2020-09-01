<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('game_movement_id')->nullable();
            $table->unsignedInteger('question_id')->nullable();
            $table->string('answerable_type')->nullable();
            $table->integer('answerable_id')->nullable();
            $table->string('other_answer')->nullable();
            $table->boolean('is_correct')->nullable()->default(false);
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
        Schema::dropIfExists('game_questions');
    }
}
