<?php

namespace App\Http\Controllers;

use App\BlueAnswer;
use App\BlueQuestion;
use App\File;
use App\Question;
use App\Transformers\QuestionTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Fractalistic\ArraySerializer;

class BlueQuestionController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'question_audio' => ['required', 'file', 'max:1000'],
            'question_text' => ['nullable', 'string'],
            'options' => ['required', 'array'],
            'options.*' => ['required', 'image', 'max:1000'],
            'answer' => ['required', 'numeric'],
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

            $audio = $this->uploadFileToS3($request->question_audio, 'audio');

            $question = Question::create([
                'difficulty' => 1,
            ]);

            $blueQuestion = BlueQuestion::create([
                'audio_id' => $audio->id,
                'audio_text' => $request->question_text,
            ]);

            $blueQuestion->question()->save($question);

            foreach ($request->options as $key => $option) {
                $image = $this->uploadFileToS3($option, 'image');
                BlueAnswer::create([
                    'blue_question_id' => $blueQuestion->id,
                    'image_id' => $image->id,
                    'is_correct' => $request->answer == $key,
                ]);
            }

            $question = fractal()->item($question)
                ->transformWith(new QuestionTransformer())
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $question,
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
}
