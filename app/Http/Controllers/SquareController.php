<?php

namespace App\Http\Controllers;

use App\File;
use App\Skin;
use App\Square;
use App\SquareSkin;
use App\Transformers\SquareCompactTransformer;
use App\Transformers\SquareTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Fractalistic\ArraySerializer;

class SquareController extends Controller
{

    protected function mainValidator(array $data)
    {
        return Validator::make($data, [
            'type' => ['required', 'string'],
            'image' => ['required', 'image', 'max:1000'],
        ]);
    }

    protected function subValidator($type, array $data)
    {
        $hasColor = in_array($type, ['start', 'question', 'arrow']);
        $hasStar = in_array($type, ['get_star', 'lose_star', 'steal_star']);
        $hasIsland = in_array($type, ['question']);

        return Validator::make($data, [
            'color' => [$hasColor ? 'required' : 'nullable', 'string'],
            'star' => [$hasStar ? 'required' : null, 'numeric'],
            'island_id' => [$hasIsland ? 'required' : 'nullable', 'string'],
        ]);
    }

    public function index()
    {
        $squares = Square::searchable()->sortable()->paginate(10);

        $squares = fractal()->collection($squares)
            ->transformWith(new SquareTransformer())
            ->serializeWith(ArraySerializer::class);

        $total = Square::searchable()->count();

        return $this->successResponse([
            'data' => $squares,
            'total' => $total
        ]);
    }

    public function list()
    {
        $squares = Square::searchable()->sortable()->paginate(16);

        $squares = fractal()->collection($squares)
            ->transformWith(new SquareCompactTransformer())
            ->serializeWith(ArraySerializer::class);

        $total = Square::searchable()->count();

        return $this->successResponse([
            'data' => $squares,
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $mainValidator = $this->mainValidator($request->only(['type', 'image']));

            if ($mainValidator->fails()) {
                return $this->failureResponse($mainValidator->errors(), 400);
            }

            $subValidator = $this->subValidator($request->type, $request->except(['type', 'image']));

            if ($subValidator->fails()) {
                return $this->failureResponse($subValidator->errors(), 400);
            }

            $square = Square::create($request->except('image'));

            $image = $this->uploadFileToS3($request->image, 'image');

            SquareSkin::create([
                'image_id' => $image->id,
                'square_id' => $square->id,
                'skin_id' => Skin::first()->id,
            ]);

            $square = fractal()->item($square)
                ->transformWith(new SquareTransformer())
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $square,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }

    public function uploadFileToS3($file, $folder)
    {
        $storage = Storage::disk('s3');
        $remotePath = $storage->putFile($folder, $file, 'public');

        $file = File::create([
            'title' => $folder,
            'path' => $remotePath,
            'size' => $file->getSize(),
        ]);

        return $file;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $square = Square::find($id);
            $square->mapSquares()->delete(); //delete on future iteration
            $square->delete();

            $square = fractal()->item($square)
                ->transformWith(new SquareTransformer())
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $square,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }
}
