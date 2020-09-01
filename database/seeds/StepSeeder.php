<?php

use App\Board;
use App\Step;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('steps')->truncate();

        $board = Board::first();

        Step::create([
            'id' => 1,
            'switch_step_id' => 5,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 2,
            'switch_step_id' => 15,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 3,
            'switch_step_id' => 25,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 4,
            'switch_step_id' => 35,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 5,
            'next_step_id' => 6,
            'previous_step_id' => 44,
            'previous_switch_step_id' => 1,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 6,
            'next_step_id' => 7,
            'previous_step_id' => 5,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 7,
            'next_step_id' => 8,
            'previous_step_id' => 6,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 8,
            'next_step_id' => 9,
            'previous_step_id' => 7,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 9,
            'next_step_id' => 10,
            'previous_step_id' => 8,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 10,
            'next_step_id' => 11,
            'previous_step_id' => 9,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 11,
            'next_step_id' => 12,
            'previous_step_id' => 10,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 12,
            'next_step_id' => 13,
            'previous_step_id' => 11,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 13,
            'next_step_id' => 14,
            'previous_step_id' => 12,
            'switch_step_id' => 46,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 14,
            'next_step_id' => 15,
            'previous_step_id' => 13,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 15,
            'next_step_id' => 16,
            'previous_step_id' => 14,
            'previous_switch_step_id' => 2,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 16,
            'next_step_id' => 17,
            'previous_step_id' => 15,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 17,
            'next_step_id' => 18,
            'previous_step_id' => 16,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 18,
            'next_step_id' => 19,
            'previous_step_id' => 17,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 19,
            'next_step_id' => 20,
            'previous_step_id' => 18,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 20,
            'next_step_id' => 21,
            'previous_step_id' => 19,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 21,
            'next_step_id' => 22,
            'previous_step_id' => 20,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 22,
            'next_step_id' => 23,
            'previous_step_id' => 21,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 23,
            'next_step_id' => 24,
            'previous_step_id' => 22,
            'switch_step_id' => 47,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 24,
            'next_step_id' => 25,
            'previous_step_id' => 23,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 25,
            'next_step_id' => 26,
            'previous_step_id' => 24,
            'previous_switch_step_id' => 3,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 26,
            'next_step_id' => 27,
            'previous_step_id' => 25,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 27,
            'next_step_id' => 28,
            'previous_step_id' => 26,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 28,
            'next_step_id' => 29,
            'previous_step_id' => 27,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 29,
            'next_step_id' => 30,
            'previous_step_id' => 28,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 30,
            'next_step_id' => 31,
            'previous_step_id' => 29,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 31,
            'next_step_id' => 32,
            'previous_step_id' => 30,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 32,
            'next_step_id' => 33,
            'previous_step_id' => 31,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 33,
            'next_step_id' => 34,
            'previous_step_id' => 32,
            'switch_step_id' => 48,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 34,
            'next_step_id' => 35,
            'previous_step_id' => 33,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 35,
            'next_step_id' => 36,
            'previous_step_id' => 34,
            'previous_switch_step_id' => 4,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 36,
            'next_step_id' => 37,
            'previous_step_id' => 35,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 37,
            'next_step_id' => 38,
            'previous_step_id' => 36,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 38,
            'next_step_id' => 39,
            'previous_step_id' => 37,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 39,
            'next_step_id' => 40,
            'previous_step_id' => 38,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 40,
            'next_step_id' => 41,
            'previous_step_id' => 39,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 41,
            'next_step_id' => 42,
            'previous_step_id' => 40,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 42,
            'next_step_id' => 43,
            'previous_step_id' => 41,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 43,
            'next_step_id' => 44,
            'previous_step_id' => 42,
            'switch_step_id' => 45,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 44,
            'next_step_id' => 5,
            'previous_step_id' => 43,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 45,
            'switch_step_id' => 49,
            'previous_switch_step_id' => 43,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 46,
            'switch_step_id' => 55,
            'previous_switch_step_id' => 13,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 47,
            'switch_step_id' => 61,
            'previous_switch_step_id' => 23,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 48,
            'switch_step_id' => 67,
            'previous_switch_step_id' => 33,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 49,
            'next_step_id' => 50,
            'previous_step_id' => 72,
            'previous_switch_step_id' => 45,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 50,
            'next_step_id' => 51,
            'previous_step_id' => 49,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 51,
            'next_step_id' => 52,
            'previous_step_id' => 50,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 52,
            'next_step_id' => 53,
            'switch_step_id' => 75,
            'previous_step_id' => 51,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 53,
            'next_step_id' => 54,
            'previous_step_id' => 52,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 54,
            'next_step_id' => 55,
            'previous_step_id' => 53,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 55,
            'next_step_id' => 56,
            'previous_step_id' => 54,
            'previous_switch_step_id' => 46,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 56,
            'next_step_id' => 57,
            'previous_step_id' => 55,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 57,
            'next_step_id' => 58,
            'previous_step_id' => 56,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 58,
            'next_step_id' => 59,
            'switch_step_id' => 77,
            'previous_step_id' => 57,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 59,
            'next_step_id' => 60,
            'previous_step_id' => 58,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 60,
            'next_step_id' => 61,
            'previous_step_id' => 59,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 61,
            'next_step_id' => 62,
            'previous_step_id' => 60,
            'previous_switch_step_id' => 47,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 62,
            'next_step_id' => 63,
            'previous_step_id' => 61,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 63,
            'next_step_id' => 64,
            'previous_step_id' => 62,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 64,
            'next_step_id' => 65,
            'switch_step_id' => 79,
            'previous_step_id' => 63,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 65,
            'next_step_id' => 66,
            'previous_step_id' => 64,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 66,
            'next_step_id' => 67,
            'previous_step_id' => 65,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 67,
            'next_step_id' => 68,
            'previous_step_id' => 66,
            'previous_switch_step_id' => 48,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 68,
            'next_step_id' => 69,
            'previous_step_id' => 67,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 69,
            'next_step_id' => 70,
            'previous_step_id' => 68,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 70,
            'next_step_id' => 71,
            'previous_step_id' => 69,
            'switch_step_id' => 73,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 71,
            'next_step_id' => 72,
            'previous_step_id' => 70,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 72,
            'next_step_id' => 49,
            'previous_step_id' => 71,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 73,
            'switch_step_id' => 74,
            'previous_switch_step_id' => 70,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 74,
            'switch_step_id' => 81,
            'previous_switch_step_id' => 73,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 75,
            'switch_step_id' => 76,
            'previous_switch_step_id' => 52,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 76,
            'switch_step_id' => 81,
            'previous_switch_step_id' => 75,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 77,
            'switch_step_id' => 78,
            'previous_switch_step_id' => 58,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 78,
            'switch_step_id' => 81,
            'previous_switch_step_id' => 77,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 79,
            'switch_step_id' => 80,
            'previous_switch_step_id' => 64,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 80,
            'switch_step_id' => 81,
            'previous_switch_step_id' => 79,
            'board_id' => $board->id,
        ]);

        Step::create([
            'id' => 81,
            'board_id' => $board->id,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
