<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MessageCollection;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['from_user_id','to_user_id','body','dialog_id'];

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function markAsRead()
    {
        if(is_null($this->read_at)) {
            $this->forceFill(['has_read' => 'T' ,'read_at' => $this->freshTimestamp()])->save();
        }
    }

    // 重新定义collection  ，里面可以自定义collection方法
    public function newCollection(array $models = [])
    {
        return new MessageCollection($models);
    }

    public function read()
    {
        return $this->has_read === 'T';
    }

    public function unread()
    {
        return $this->has_read === 'F';
    }

    public function shouldAddUnreadClass()
    {
        if(user()->id === $this->from_user_id){
            return false;
        }
        return $this->unread();
    }
}
