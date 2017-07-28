<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/14
 * Time: 15:04
 */

namespace App\Repositries;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}