<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositries\QuestionRepository;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionsController extends Controller
{
    protected $questionRepository;
    /**
     * QuestionsController constructor.
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        /*设置中间件，填入不需要登陆的页面*/
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return string
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];

        $question = $this->questionRepository->create($data);

        /*attach()创建*/
        $question->topics()->attach($topics);

        return redirect()->route('questions.show',[$question->id]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

        return view('questions.show',compact('question'));
    }

    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }
    public function update(StoreQuestionRequest $request,$id)
    {
        $requestion = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $requestion->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        /*attach()同步*/
        $requestion->topics()->sync($topics);

        return redirect()->route('questions.show',[$requestion->id]);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            $question->delete();
            return redirect('/');
        }

        abort(403,'Forbidden');
    }

}
