<?php

namespace App\Http\Controllers;

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
        if(user('api')->hasVoteFor($answer)){
            return response()->json(['voted' => true]);
        }
        return response()->json(['voted' => false]);
    }

    public function vote()
    {
        $answer = $this->answer->byId(request('answer'));
        $voted = user('api')->voteFor($answer->id);
        if(count($voted['detached']) >0){
            $answer->decrement('votes_count');
            return response()->json(['voted' => false]);
        }
        // 发私信
        $answer->increment('votes_count');
        return response()->json(['voted' => true]);
    }
}
