<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Fractalistic\ArraySerializer;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(
            [
                'status' => 'success',
                'users' => $users->toArray()
            ], 200);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return response()->json(
            [
                'status' => 'success',
                'user' => $user->toArray()
            ], 200);
    }

    public function user(Request $request)
    {
        try {
            $user = fractal()->item(auth()->user())
                ->transformWith(new UserTransformer())
                ->serializeWith(ArraySerializer::class);

            return $this->successResponse([
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            Log::info($e);

            return $this->failureResponse($e->getMessage());
        }
    }
}
