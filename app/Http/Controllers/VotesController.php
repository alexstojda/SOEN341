<?php

    namespace App\Http\Controllers;

    use App\Answer;
    use App\Question;
    use Illuminate\Database\Eloquent\ModelNotFoundException;

    /**
     * Class VotesController
     *
     *
     * @package App\Http\Controllers
     */
    class VotesController extends Controller {
        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function show($model, $id) {
            try {
                switch ($model) {
                    case 'answers' :
                        $result = Answer::find($id);
                        break;
                    case 'questions' :
                        $result = Question::find($id);
                        break;
                    default :
                        return redirect()->back();
                }
            } catch (ModelNotFoundException $exception) {
                return redirect()->back();
            }

            return response()->json([
                'total'   => $result->countTotalVotes(),
                'up'      => $result->countUpVoters(),
                'down'    => $result->countDownVoters(),
                'turnout' => $result->countVoters(),
                'voters'  => $result->voters,
                //'voted'   => $result->isVotedBy(),
            ]);
        }
    }
