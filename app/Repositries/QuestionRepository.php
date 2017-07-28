<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/7
 * Time: 16:22
 */

namespace App\Repositries;

use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositries
 */
class QuestionRepository
{
    /**
     * @param $id
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id',$id)->with(['topics','answers'])->first();
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $numTopic = Topic::create(['name' => $topic,'questions_count' => 1]);
            return $numTopic->id;
        })->toArray();
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    public function getQuestionCommentsByid($id)
    {
        $question = Question::with('comments','comments.user')->where('id',$id)->first();

        return $question->comments;
    }
}