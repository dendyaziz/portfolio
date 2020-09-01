<?php

namespace App\Http\Controllers;

use App\Board;
use App\Square;
use App\Step;
use App\Transformers\StepTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Spatie\Fractalistic\ArraySerializer;

class StepController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $steps = Step::searchable()->sortable()->paginate(10);

        $steps = fractal()->collection($steps)
            ->transformWith(new StepTransformer(true, true, true, true))
            ->serializeWith(ArraySerializer::class);

        $total = Step::searchable()->count();

        return $this->successResponse([
            'data' => $steps,
            'total' => $total,
        ]);
    }

    public function show($id)
    {
        try {
            $step = Step::findOrFail($id);

            $step = fractal()->item($step)
                ->transformWith(new StepTransformer(true, true, true))
                ->serializeWith(ArraySerializer::class);

            return $this->successResponse([
                'data' => $step,
            ]);
        } catch (\Exception $e) {
            Log::info($e);

            return $this->failureResponse($e->getMessage());
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'square_id' => ['required', 'numeric'],
            'next_square_id' => ['required', 'numeric'],
            'switch_step_id' => ['numeric'],
            'previous_square_id' => ['numeric'],
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return $this->failureResponse($validator->errors(), 400);
            }

            $square = Square::findOrFail($request->input('square_id'));

            $step = Step::where(function (Builder $query) use ($request) {
                $query->whereHas('previousStep', function (Builder $query) use ($request) {
                    $query->whereHas('square', function (Builder $query) use ($request) {
                        $query->where('id', $request->input('previous_square_id'));
                    });
                })->orWhere(function (Builder $query) {
                    $query->whereHas('previousSwitchStep')->doesntHave('previousStep');
                });
            })
//                ->where('square_id', $request->input('square_id'))
//                ->get();
//                ->orDoesntHave('previousSwitchStep')
                ->firstOrCreate([
                    'board_id' => Board::first()->id,
                    'square_id' => $request->input('square_id'),
                ]);

            $wasRecentlyCreated = $step->wasRecentlyCreated;

//            return $this->failureResponse([
//                'data' => $step,
//                'recentlyCreated' => $wasRecentlyCreated,
//            ]);

            if ($request->filled('previous_square_id')) {
                $previousSquare = Square::findOrFail($request->input('previous_square_id'));

                $previousStepQuery = Step::where('square_id', $request->input('previous_square_id'))
                    ->whereHas('nextStep', function (Builder $query) use ($request) {
                        $query->whereHas('square', function (Builder $query) use ($request) {
                            $query->where('id', $request->input('square_id'));
                        });
                    });

                if ($previousStepQuery->count() === 0)
                    $previousStepQuery = Step::where('square_id', $request->input('previous_square_id'))
                        ->whereHas('switchStep', function (Builder $query) use ($request) {
                            $query->whereHas('square', function (Builder $query) use ($request) {
                                $query->where('id', $request->input('square_id'));
                            });
                        });

                if ($previousStepQuery->count() === 0)
                    $previousStepQuery = Step::where('board_id', Board::first()->id)
                        ->where('switchStep', $request->input('previous_square_id'))
                        ->doesntHave('nextStep');

//                if ($previousStepQuery->count() > 0) {
//                    $previousStep = $previousStepQuery->first();
//                } else {
//                    $previousStep = Step::create([
//                        'board_id' => Board::first()->id,
//                        'square_id' => $request->input('previous_square_id')
//                    ]);
//                }

                $previousStep = $previousStepQuery->firstOrCreate([], [
                    'board_id' => Board::first()->id,
                    'square_id' => $request->input('previous_square_id')
                ]);

//                return $this->failureResponse([
//                    'data' => $previousStep,
//                    'recentlyCreated' => $previousStep->wasRecentlyCreated,
//                ]);

                $step->previous_step_id = $previousStep->id; // try to put it inside if condition below

                if ($previousStep->wasRecentlyCreated || !$previousStep->nextStep()->exists()) {
                    $previousStep->next_step_id = $step->id;
                }

//                return $this->failureResponse([
//                    'data' => $previousStep,
//                    'recentlyCreated' => $previousStep->wasRecentlyCreated,
//                ]);

                $previousStep->save();
            }

            if ($request->filled('next_square_id')) {
                $isSwitch = $square->isSwitch;
                $isPreviousSwitchStepId = $square->isStart || ($isSwitch && isset($previousSquare)
                        && $previousSquare->isSwitch);

                $nextStep = Step::where(function (Builder $query) use ($request, $isPreviousSwitchStepId) {
                    $query->whereHas('previousStep', function (Builder $query) use ($request) {
                        $query->whereHas('square', function (Builder $query) use ($request) {
                            $query->where('id', $request->input('square_id'));
                        });
                    })->orWhere(function (Builder $query) use ($request, $isPreviousSwitchStepId) {
                        if ($isPreviousSwitchStepId) {
                            $query->whereHas('previousSwitchStep', function (Builder $query) use ($request) {
                                $query->whereHas('square', function (Builder $query) use ($request) {
                                    $query->where('id', $request->input('square_id'));
                                });
                            })->orDoesntHave('previousSwitchStep');
                        }
                    })->orDoesntHave('previousStep');
                })
//                    ->where('square_id', $request->input('next_square_id'))
//                    ->get();
                    ->firstOrCreate([
                        'board_id' => Board::first()->id,
                        'square_id' => $request->input('next_square_id')
                    ]);

                $step->next_step_id = $nextStep->id;

                if ($isPreviousSwitchStepId) {
                    $nextStep->previous_switch_step_id = $step->id;
                } else if ($nextStep->wasRecentlyCreated || !$nextStep->previousStep()->exists()) {
                    $nextStep->previous_step_id = $step->id;
                }

//                return $this->failureResponse([
//                    'data' => $nextStep,
//                    'recentlyCreated' => $nextStep->wasRecentlyCreated,
//                ]);

                $nextStep->save();
            }

            if ($request->filled('switch_step_id')) {
                $switchStep = Step::whereHas('previousStep', function (Builder $query) use ($request) {
                    $query->whereHas('square', function (Builder $query) use ($request) {
                        $query->where('id', $request->input('square_id'));
                    })->whereHas('previousStep', function (Builder $query) use ($request) {
                        $query->whereHas('square', function (Builder $query) use ($request) {
                            $query->where('id', $request->input('previous_square_id'));
                        });
                    });
                })
                    ->firstOrCreate([
                        'board_id' => Board::first()->id,
                        'square_id' => $request->input('switch_step_id')
                    ]);

                $step->switch_step_id = $switchStep->id;
                $switchStep->previous_step_id = $step->id;

//                return $this->failureResponse([
//                    'data' => $switchStep,
//                    'recentlyCreated' => $switchStep->wasRecentlyCreated,
//                ]);

                $switchStep->save();
            }

            $step->save();

//            return $this->failureResponse([
//                'data' => $step,
//                'recentlyCreated' => $wasRecentlyCreated,
//            ]);

//            return $this->successResponse([
//                'data' => $step,
//                'updated' => !$wasRecentlyCreated,
//            ]);


//            $step = Step::firstOrCreate([
//                'board_id' => Board::first()->id,
//                'square_id' => $request->input('square_id'),
//            ]);
//
//            $wasRecentlyCreated = $step->wasRecentlyCreated;
//
//            $nextStep = Step::firstOrCreate([
//                'board_id' => Board::first()->id,
//                'square_id' => $request->input('next_square_id')
//            ]);
//
//            $step->next_step_id = $nextStep->id;
//
//            if ($nextStep->wasRecentlyCreated) {
//                $nextStep->previous_step_id = $step->id;
//            }
//
//            $nextStep->save();
//
//            if ($request->filled('switch_step_id')) {
//                $switchStep = Step::whereNot('id', $request->input('square_id'))
//                    ->firstOrCreate([
//                        'board_id' => Board::first()->id,
//                        'square_id' => $request->input('switch_step_id')
//                    ]);
//
//                $step->switch_step_id = $switchStep->id;
//                $switchStep->previous_step_id = $step->id;
//
//                $switchStep->save();
//            }
//
//            $step->save();

            $step = fractal()->item($step)
                ->transformWith(new StepTransformer(true, true, false))
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $step,
                'updated' => !$wasRecentlyCreated,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            return $this->failureResponse($e->getMessage());
        }
    }

    public function updateSquare(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'square_id' => ['required', 'numeric'],
            ]);

            if ($validator->fails()) {
                return $this->failureResponse($validator->errors(), 400);
            }

            $step = Step::findOrFail($id);
            $step->update($request->all());

            $step = fractal()->item($step)
                ->transformWith(new StepTransformer(true, true, true, true))
                ->serializeWith(ArraySerializer::class);

            DB::commit();
            return $this->successResponse([
                'data' => $step,
            ]);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();

            if ($e instanceof ModelNotFoundException)
                return $this->failureResponse('Record could not be found', 404);

            return $this->failureResponse($e->getMessage());
        }
    }
}
