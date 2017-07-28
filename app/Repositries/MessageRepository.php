<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/17
 * Time: 17:03
 */

namespace App\Repositries;


use App\Answer;
use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositries
 */
class MessageRepository
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Answer::find($id);
    }

    /**
     * @return mixed
     */
    public function getAllMessages()
    {
        return Message::where('to_user_id',user()->id)
            ->orWhere('from_user_id',user()->id)
            ->with(['fromUser' => function($query){
                return $query->select(['id','name','avatar']);
            },'toUser' => function($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();
    }

    /**
     * @param $dialog_id
     * @return mixed
     */
    public function getDialogMassagesBy($dialog_id)
    {
        return Message::where('dialog_id',$dialog_id)
            ->with(['fromUser' => function($query){
                return $query->select(['id','name','avatar']);
            },'toUser' => function($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageBy($dialogId)
    {
        return Message::where('dialog_id',$dialogId)->first();
    }
}