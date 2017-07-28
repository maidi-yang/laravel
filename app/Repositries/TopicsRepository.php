<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/18
 * Time: 16:59
 */

namespace App\Repositries;


use App\Topic;
use Illuminate\Http\Request;

class TopicsRepository
{
    public function getTopicsForTagging(Request $request)
    {
        return Topic::select(['id','name'])
            ->where('name','like','%'.$request->query('q').'%')
            ->get();
    }
}