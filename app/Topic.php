<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name','questions_count','followers_count','bio'];

    public function questions()
    {
        //带上timestamps 包括create和update
        return $this->belongsToMany(Question::class)->withTimestamps();
    }
}
