<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/17
 * Time: 9:39
 */

namespace App\Channels;


use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class SendcloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable);
    }
}