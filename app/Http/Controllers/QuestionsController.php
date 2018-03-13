<?php

    namespace App\Http\Controllers;

    use App\Question;
    use App\Http\Resources\Question as QuestionResource;
    use cebe\markdown\GithubMarkdown;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Auth;

    class QuestionsController extends Controller {
        public function __construct() {
            $this->middleware('auth')->except(['index','accept', 'show', 'QuestionsList', 'QuestionView']);
        }

        public function index() {
            $questions = Question::latest()->get();

            if ($questions->first()) {
                return QuestionResource::collection($questions);
            }

            return null; //TODO: write failure json
        }

        public function show($id) {
            $question = Question::whereId($id)->first();
            if ($question) {
                return new QuestionResource($question);
            }

            return null; //TODO: write failure json
        }

        public function QuestionsList() {
            $questions = Question::latest()->get();

            return view('questions', compact('questions'));
        }

        public function QuestionView($id) {
            try {
                $question = Question::whereId($id)->first();
                $comments = $question->comments;

                $parser = new GithubMarkdown();
                $answers = $question->answers;

                $aComments = [];
                foreach ($answers as $answer) {
                    $aComments[] = $answer->comments;
                }
                $answerComments = collect($aComments);

            } catch (ModelNotFoundException $exception) {
                return redirect('questions');
            }

            $user = Auth::user();

            $canAcceptAnswer = ($question['author_id'] == $user['id']);
            $hasAcceptedAnswer = (isset($question['answer_id']));

            return view('questions.show',
                compact('question', 'answers', 'comments', 'answerComments', 'parser', 'canAcceptAnswer',
                    'hasAcceptedAnswer'));
        }

        public function create() {
            return view('questions.create');
        }

        public function store() {
            $this->validate(request(), [
                'title' => 'required',
                'body'  => 'required',
            ]);

            Question::create([
                'title'     => request('title'),
                'body'      => request('body'),
                'author_id' => Auth::id() //use this when sessions are created
            ]);

            return redirect('questions');
        }
    }