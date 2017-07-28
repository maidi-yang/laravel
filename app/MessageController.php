<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/19
 * Time: 15:51
 */

namespace App;


use Illuminate\Database\Eloquent\Collection;

class MessageController extends  Collection
{
    public function markAsRead()
    {
        $this->each(function($message){
            if($message->to_user_id === user()->id) {
                $message->markAsRead();
            }
        });
    }
}