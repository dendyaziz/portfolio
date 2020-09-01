<?php

namespace App\Http\Controllers;

use App\Island;
use App\Transformers\IslandTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Fractalistic\ArraySerializer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class IslandController extends Controller
{
    protected function validator(array $data, $id= null)
    {
        return Validator::make($data, [
            'name' => ['required', 'string'],
            'code' => ['nullable', 'string', 'min:2', 'max:4', Rule::unique('users')->ignore($id)],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $islands = fractal()->collection(Island::all())
            ->transformWith(new IslandTransformer())
            ->serializeWith(ArraySerializer::class);

        return $this->successResponse([
            'data' => $islands,
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

            $island = Island::create($request->all());

            $island = fractal()->item($island)
                ->transformWith(new IslandTransformer())
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $island,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }
}
