<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_id','body','commentable_id','commentable_type'];

    // 根据字段commentable_xx命名 多态关系
    public function commentable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
