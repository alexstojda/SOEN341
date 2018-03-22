<?php

    namespace App\Http\Controllers;

    use App\Answer;
    use App\Http\Resources\Answer as AnswerResource;
    use App\Question;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Auth;

    /**
     * Class AnswersController
     * @package App\Http\Controllers
     */
    class AnswersController extends Controller {
        /**
         * AnswersController constructor.
         */
        public function __construct() {
            $this->middleware('auth:api')->except(['show', 'index']);
        }

        /**
         * @param $id
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|null
         */
        public function store($id) {
            $this->validate(request(), [
                'body' => 'required',
            ]);

            $question = Question::whereId($id)->first();

            if ($question) {
                Answer::create([
                    'question_id' => $id,
                    'body'        => request('body'),
                    'author_id'   => Auth::guard('api')->id() //use this when sessions are created
                ]);

                return AnswerResource::collection($question->answers);
            }

            return null; //TODO: write failure json
        }

        /**
         * @param $id
         * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|null
         */
        public function index($id) {
            $question = Question::whereId($id)->first();
            if ($question) {
                return AnswerResource::collection($question->answers);
            }

            return null; //TODO: write failure json
        }

        /**
         * @param $id
         * @return AnswerResource|null
         */
        public function show($id) {
            $answer = Answer::whereId($id)->first();
            if ($answer) {
                return new AnswerResource($answer);
            }

            return null; //TODO: write failure json
        }

        /**
         * @param $id
         * @return AnswerResource|\Illuminate\Http\JsonResponse
         */
        public function accept($id) {
            try {
                $answer = Answer::whereId($id)->first();
            } catch (ModelNotFoundException $exception) {
                return response()->json(['status' => 'fail', 'message' => 'Answer - ModelNotFoundException']);
            }
            $answer->parent->acceptAnswer(Auth::guard('api')->id(), $id);

            //return response()->json(['status' => 'fail', 'message' => 'User did not ask the question']);

            return new AnswerResource($answer);
        }
    }

