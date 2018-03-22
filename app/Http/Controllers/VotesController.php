<?php

    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Auth;

    /**
     * Class VotesController
     *
     *
     * @package App\Http\Controllers
     */
    class VotesController extends Controller {
        public function __construct() {
            $this->middleware('auth:api')->except(['show','index']);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function index($model, $id) {
            $model = $this->determineModel($model, $id);

            return $this->generateResponse($model);
        }

        /**
         * @param $model
         * @param int $id
         * @return \Illuminate\Http\JsonResponse
         */
        public function upvote($model, int $id) {
            $model = $this->determineModel($model, $id);
            $user = Auth::guard('api')->user();


            if ($user->hasUpVoted($model)) {
                $user->cancelVote($model);
            } else {
                $user->upVote($model);
            }
            return $this->generateResponse($model);

        }

        /**
         * @param $model
         * @param int $id
         * @return \Illuminate\Http\JsonResponse
         */
        public function downvote($model, int $id) {
            $model = parent::determineModel($model, $id);
            $user = Auth::guard('api')->user();

            if ($user->hasDownVoted($model)) {
                $user->cancelVote($model);
            } else {
                $user->downVote($model);
            }

            return $this->generateResponse($model);
        }

        /**
         * @param $model
         * @return \Illuminate\Http\JsonResponse
         */
        private function generateResponse($model) {
            return response()->json([
                'total'   => $model->countTotalVotes(),
                'up'      => $model->countUpVoters(),
                'down'    => $model->countDownVoters(),
                'turnout' => $model->countVoters(),
                'voters'  => $model->voters,
                //'voted'   => $model->isVotedBy(),
            ]);
        }
    }
