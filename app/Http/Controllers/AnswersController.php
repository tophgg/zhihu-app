<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    protected $answerRepository;
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }
    public function store(StoreAnswerRequest $request,$question)
    {
        $answer = $this->answerRepository->create([
            'question_id' => $question,
            'user_id'     => Auth::id(),
            'body'        => $request->get('body')
        ]);
        // 该问题评论+1
        $answer->question()->increment('answers_count');
        return back();
    }
}
