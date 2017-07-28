<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name','questions_count','bio'];

    public function questions()
    {
        /*声明多对多关系，连接关联表*/
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
