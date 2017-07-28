<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class NotificationsController
 * @package App\Http\Controllers
 */
class NotificationsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index',compact('user'));
    }

    /**
     * @param DatabaseNotification $notification
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        return redirect(\Request::query('redirect_url'));
    }
}
