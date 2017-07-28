<?php

namespace App\Http\Controllers;

use App\Notifications\NewMessageNotification;
use App\Repositries\MessageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class MessagesController extends Controller
{
    protected $message;

    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }


    public function store()
    {
        $message = $this->message->create([
            'to_user_id' => request('user'),
            'from_user_id' => user('api')->id,
            'body' => request('body'),
            'dialog_id' => time().Auth::id(),
        ]);
        if($message) {
            $message->toUser->notify(new NewMessageNotification($message));

            return response()->json(['status' => true]);
        }


        return  response()->json(['status' => false]);
    }
}
