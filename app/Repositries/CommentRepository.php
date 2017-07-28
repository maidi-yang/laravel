<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/18
 * Time: 15:51
 */

namespace App\Repositries;


use App\Comment;

class CommentRepository
{
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }

}