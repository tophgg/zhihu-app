<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/14
 * Time: 0:28
 * Describ:
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{
    public function create($attribute)
    {
        return Message::create($attribute);
    }

    public function byId($id)
    {
        return Message::find($id);
    }

    public function getAllMessage()
    {
    	$message = Message::where('to_user_id',user()->id)->orwhere('from_user_id',user()->id)
    		->with(['fromUser' => function($query){
    			return $query->select(['id','name','avatar']);
    		},'toUser' => function($query){
    			return $query->select(['id','name','avatar']);
    		}])->latest()->get();
    	return $message;
    }

    public function getDialogMessageBy($dialogId)
    {
    	$message = Message::where('dialog_id',$dialogId)->with(['fromUser' => function($query){
    			return $query->select(['id','name','avatar']);
    		},'toUser' => function($query){
    			return $query->select(['id','name','avatar']);
    		}])->latest()->get();
    	return $message;
    }

    public function getSingleMessageBy($dialogId)
    {
    	$message = Message::where('dialog_id',$dialogId)->first();
    	return $message;
    }
}