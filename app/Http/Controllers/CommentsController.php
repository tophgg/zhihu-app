<?php

namespace App\Http\Controllers;


use App\Repositories\CommentRepository;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    protected $comment;
    protected $answer;
    protected $question;

    public function __construct(CommentRepository $comment, AnswerRepository $answer, QuestionRepository $question)
    {
        $this->comment = $comment;
        $this->answer = $answer;
        $this->question = $question;
    }
    public function answer($id)
    {
    	// comments model中的user一对一关系
    	return $this->answer->getAnswerCommentsById($id);

    }

    public function question($id)
    {
    	return $this->question->getQuestionCommentsById($id);
    }

    public function store()
    {
    	$model = $this->getModelNameFromType(request('type'));
    	$comment = $this->comment->create([
    	    'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id'   => Auth::guard('api')->user()->id,
            'body'  => request('body')
        ]);

    	return $comment;
    }

    public function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\question' : 'App\answer';
    }
}
