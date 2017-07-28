<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/12
 * Time: 14:52
 */

namespace App\Repositries;


use App\Answer;

/**
 * Class AnswerRepository
 * @package App\Repositries
 */
class AnswerRepository
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }

    public function getAnswerCommentsByid($id)
    {
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();

        return $answer->comments;
    }
}