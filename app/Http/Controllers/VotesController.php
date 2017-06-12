<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Repositories\AnswerRepository;

class VotesController extends Controller
{
    protected $answer;

    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }
    public function users($answer)
    {
        $user = Auth()->guard('api')->user();

        if($user->hasVoteFor($answer)){
            return response()->json(['voted' => true]);
        }
        return response()->json(['voted' => false]);
    }

    public function vote()
    {
        $user = Auth()->guard('api')->user();
        $answer = $this->answer->byId(request('answer'));
        $voted = $user->voteFor($answer->id);
        if(count($voted['detached']) >0){
            $answer->decrement('votes_count');
            return response()->json(['voted' => false]);
        }
        // 发私信
        $answer->increment('votes_count');
        return response()->json(['voted' => true]);
    }
}
