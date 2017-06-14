<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function answer()
    {
    	// comments model中的user一对一关系
    	$comments = Answer::with('comments','comments.user')->where('commentable_id',$id)->first();
    	return $comments;
    }

    public function question()
    {
    	$answers = Question::with('comments','comments.user')->where('commentable_id',$id)->first();
    	return $comments;
    }

    public function store()
    {
    	$model = $this->getModelNameFromType(request('type'));
    }
}
