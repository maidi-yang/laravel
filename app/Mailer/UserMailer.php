<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/17
 * Time: 11:41
 */

namespace App\Mailer;

use App\User;
use Auth;
class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = ['url' => config('app.url') , 'name' => Auth::guard('api')->user()->name];

        $this->senTo('zhihu_app_new_user_follow', $email, $data);
    }

    public function passwordReset($email, $token)
    {
        $data = ['url' => url(config('app.url').route('password.reset', $token, false))];

        $this->senTo('zhihu_app_password_reset', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify',['token' => $user->confirmation_token]),
            'name' => $user->name
        ];

        $this->senTo('laravel_app_register', $user->email, $data);
    }
}