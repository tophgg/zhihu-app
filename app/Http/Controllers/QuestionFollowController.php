<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuestionRepository;

class QuestionFollowController extends Controller
{
	protected $question;
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');
        $this->question = $question;
    }

    public function follow($question)
    {
        user()->followThis($question);

        return back();
    }

    public function follower()
    {
	    $followed = user('api')->followed(request('question'));
	    if($followed){
	        return response()->json(['followed' => true]);
	    }

	    return response()->json(['followed' => false]);
	}

	public function followThisQuestion()
	{
	    $question = $this->question->byId(request('question'));
	    $followed = user('api')->followThis($question->id);
	    if(count($followed['detached']) >0){
	        $question->decrement('followers_count');
	        return response()->json(['followed' => false]);
	    }

	    $question->increment('followers_count');
	    return response()->json(['followed' => true]);
	}
}
