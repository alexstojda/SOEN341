<?php

    namespace App\Http\Controllers;

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;

    /**
     * Class Controller
     * @package App\Http\Controllers
     */
    class Controller extends BaseController {
        use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        /**
         * @param string $model
         * @param int $id
         * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse|null|object|static
         */
        protected function determineModel(string $model, int $id) {
            try {
                switch ($model) {
                    case 'answers' :
                        try {
                            return \App\Answer::whereId($id)->first();
                        } catch (ModelNotFoundException $exception) {
                            return redirect()->back();
                        }
                        break;
                    case 'questions' :
                        try {
                            return \App\Question::whereId($id)->first();
                        } catch (ModelNotFoundException $exception) {
                            return redirect()->back();
                        }
                        break;
                    default :
                        return redirect()->back();
                }
            } catch (ModelNotFoundException $exception) {
                return redirect()->back();
            }
        }
    }
