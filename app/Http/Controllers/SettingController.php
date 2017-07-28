<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {

        return view('users.setting');
    }

    public function store(Request $request)
    {
        user()->settings()->merge($request->all());
        flash('修改成功')->success()->important();
        return back();
    }
}
