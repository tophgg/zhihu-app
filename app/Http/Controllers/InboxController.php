<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use App\Notifications\NewMessageNotification;

class InboxController extends Controller
{
	protected $message;
	public function __construct(MessageRepository $message)
	{
		// 登录后才有权限访问
		$this->middleware('auth');
		$this->message = $message;
	}

	// 私信列表入口
    public function index()
    {
    	// $messages = user()->messages->groupBy('from_user_id');
    	$messages = $this->message->getAllMessage();
    	// return [ 'messages' => $messages->groupBy('to_user_id') ];
    	return view('inbox.index',[ 'messages' => $messages->groupBy('dialog_id') ]);
    }

    public function show($dialogId)
    {
    	$messages = $this->message->getDialogMessageBy($dialogId);
		
		$messages->markAsRead();
    	return view('inbox.show',compact('messages','dialogId'));
    }

    public function store($dialogId)
    {
    	$message = $this->message->getSingleMessageBy($dialogId);
    	// 判断接受人的user_id
    	$toUserId = $message->from_user_id === user()->id ? $message->to_user_id : $message->from_user_id;
    	$newMessage = $this->message->create([
    		'from_user_id' => user()->id,
    		'to_user_id'   => $toUserId,
    		'body'	=> request('body'),
    		'dialog_id' => $dialogId
    	]);

    	// 接收人收到私信
    	$newMessage->toUser->notify(new NewMessageNotification($newMessage));

    	return back();
    }
}
