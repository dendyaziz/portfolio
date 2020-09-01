<?php

namespace App\Http\Controllers;

use App\Game;
use App\Transformers\GameTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Fractalistic\ArraySerializer;

class GameController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'skin_id' => ['required', 'numeric'],
            'board_id' => ['required', 'numeric'],
            'max_player' => ['required', 'numeric'],
        ]);
    }

    public function index()
    {
        $games = Game::searchable()->sortable()->paginate(10);

        $games = fractal()->collection($games)
            ->transformWith(new GameTransformer())
            ->serializeWith(ArraySerializer::class);

        $total = Game::searchable()->count();

        return $this->successResponse([
            'data' => $games,
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return $this->failureResponse($validator->errors(), 400);
            }

            $roomName = 'room-' . time();

            $game = Game::create([
                'skin_id' => $request->input('skin_id'),
                'board_id' => $request->input('board_id'),
                'max_player' => $request->input('max_player'),
                'room_master_id' => Auth::user()->profile->id,
                'room_name' => $roomName,
                'password' => Crypt::encryptString($roomName),
            ]);

            $game = fractal()->item($game)
                ->transformWith(new GameTransformer())
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $game,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }
}
