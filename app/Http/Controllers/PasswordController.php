<?php

namespace App\Http\Controllers;

use Hash;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PasswordController
 * @package App\Http\Controllers
 */
class PasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        return view('users.password');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ChangePasswordRequest $request)
    {
        if(Hash::check($request->get('old_password'),user()->password)){
            user()->password = bcrypt($request->get('password'));
            user()->save();
            flash('密码修改成功')->success()->important();
            return back();
        }
        flash('密码修改失败')->error()->important();
        return back();
    }
}
