<?php

namespace App\Http\Controllers;

use App\Repositries\QuestionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class QuestionFollowController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $question;
    /**
     * QuestionFollowController constructor.
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow($question)
    {
        Auth::user()->followThis($question);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follower(Request $request) {
        if(user('api')->followed($request->get('question'))){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function followThisQuestion(Request $request) {
        $question = $this->question->byId($request->get('question'));
        $followed = user('api')->followThis($question->id);
        if(count($followed['detached']) > 0){
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }


        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
