<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{


    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function avatar()
    {
        return view('users.avatar');
    }

    public function changAvatar(Request $request)
    {
        $file = $request->file('img');

        /*$filename = md5(time().user()->id).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'),$filename);
        user()->avatar = '/avatars/'.$filename;*/

        $filename = 'avatars/'.md5(time().user()->id).'.'.$file->getClientOriginalExtension();
        Storage::disk('qiniu')->writeStream($filename,fopen($file->getRealPath(),'r'));
        user()->avatar = 'http://'.config('filesystems.disks.qiniu.domain').'/'.$filename;

        user()->save();

        return ['url' => user()->avatar];
    }
}
