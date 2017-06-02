<?php

namespace App;

use Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $data = [
            'url' => url('password/reset', $token)
        ];
        $template = new SendCloudTemplate('zhihu_app_password_reset', $data);

        Mail::raw($template, function ($message){
            $message->from('395886828@qq.com', 'Zhihu');
            $message->to($this->email);
        });
    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    //用户属于多个关联表
    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }
    //关注or取消关注
    public function followThis($question)
    {
        // toggle就是每次调用时删除/增加对应的数据 （若存在则删除）
        return $this->follows()->toggle($question);
    }
    // 已关注人数
    public function followed($question)
    {
        return $this->follows()->where('question_id',$question)->count();
    }
}
