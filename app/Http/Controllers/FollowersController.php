<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositries\UserRepository;
use Auth;

class FollowersController extends Controller
{
    protected $user;

    /**
     * FollowersController constructor.
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }


    public function index($id)
    {
        $user = $this->user->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if(in_array(user('api')->id, $followers)){
            return response()->json(['followed' => true]);
        }

        return response()->json(['followed' => false]);
    }

    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));
        $followed = user('api')->followThisUser($userToFollow->id);
        if(count($followed['attached']) >0 ){
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            return response()->json(['followed' => true]);
        }

        $userToFollow->decrement('followers_count');
        return response()->json(['followed' => false]);
    }
}
