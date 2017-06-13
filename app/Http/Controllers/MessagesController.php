<?php

namespace App\Http\Controllers;

use Auth;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    protected $messageRepository;
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }
    public function store()
    {
        $user = request('user');
        $message = $this->messageRepository->create([
            'from_user_id' => Auth::guard('api')->user()->id,
            'to_user_id'  => request('user'),
            'body'        => request('body')
        ]);
        if($message){
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
