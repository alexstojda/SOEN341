<?php

    namespace App\Http\Controllers;

    use App\Question;
    use App\Http\Resources\Question as QuestionResource;
    use cebe\markdown\GithubMarkdown;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Auth;

    class QuestionsController extends Controller {
        public function __construct() {
            $this->middleware('auth')->except(['show', 'listAll', 'apiIndex', 'apiTop', 'apiShow']);
            $this->middleware('api')->only(['apiStore']);
        }

        public function apiIndex() {
            $questions = Question::latest()->get();

            if ($questions->first()) {
                return QuestionResource::collection($questions);
            }

            return null; //TODO: write failure json
        }

        public function apiTop() {
            $questions = Question::latest()->paginate(5);

            if ($questions->first()) {
                return QuestionResource::collection($questions);
            }

            return null; //TODO: write failure json
        }

        public function apiShow($id) {
            $question = Question::whereId($id)->first();
            if ($question) {
                return new QuestionResource($question);
            }

            return null; //TODO: write failure json
        }

        public function listAll() {
            $questions = Question::latest()->get();

            return view('questions', compact('questions'));
        }

        public function show($id) {
            try {
                $question = Question::findOrFail($id);
            } catch (ModelNotFoundException $exception) {
                return redirect('questions');
            }

            $comments = $question->comments;

            $parser = new GithubMarkdown();
            $answers = $question->answers;

            $aComments = [];
            foreach ($answers as $answer) {
                $aComments[] = $answer->comments;
            }
            $answerComments = collect($aComments);

            $user = Auth::user();

            $canAcceptAnswer = ($question['author_id'] == $user['id']);
            $hasAcceptedAnswer = (isset($question['answer_id']));

            return view('questions.show',
                compact('question', 'answers', 'comments', 'answerComments', 'parser', 'canAcceptAnswer',
                    'hasAcceptedAnswer'));
        }

        public function newQuestion() {
            $this->apiStore();
            return redirect('questions');
        }

        public function create() {
            return view('questions.create');
        }

        public function apiStore() {
            $this->validate(request(), [
                'title' => 'required',
                'body'  => 'required',
            ]);

            $q = Question::create([
                'title'     => request('title'),
                'body'      => request('body'),
                'author_id' => Auth::guard('api')->id() //use this when sessions are created
            ]);

            return $this->apiShow($q->id);
        }
    }