<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthMasterController extends Controller
{
    private function guard()
    {
        return Auth::guard();
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', Rule::unique('users')],
                'password' => ['required', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return $this->failureResponse($validator->errors(), 400);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            DB::commit();
            return $this->successResponse();
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
        ]);

        if ($validator->fails()) {
            return $this->failureResponse($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = $this->guard()->attempt($credentials)) {
            return $this->failureResponse('Wrong email or password', 401);
        }

        if (!auth()->user()->isMaster) {
            return $this->failureResponse('Wrong email or password', 403);
        }

        return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::user()->id);

            return $this->successResponse([
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            Log::info($e);

            if ($e instanceof ModelNotFoundException)
                return $this->failureResponse('Record could not be found', 404);

            return $this->failureResponse($e->getMessage());
        }
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }

        return $this->failureResponse('Refresh token error', 401);
    }
}
