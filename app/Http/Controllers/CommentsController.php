<?php

namespace App\Http\Controllers;

use App\Repositries\AnswerRepository;
use App\Repositries\CommentRepository;
use App\Repositries\QuestionRepository;
use Auth;

class CommentsController extends Controller
{
    protected $answer;
    protected $question;
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer, QuestionRepository $question, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }


    public function answer($id)
    {
        return $this->answer->getAnswerCommentsByid($id);
    }

    public function question($id)
    {
        return $this->question->getQuestionCommentsByid($id);
    }

    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));

        return $this->comment->create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => user('api')->id,
            'body' => request('body')
        ]);

    }

    public function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
