<?php
/**
 * Created by PhpStorm.
 * User: KF012
 * Date: 2017/6/2
 * Time: 14:01
 */

namespace App\Repositories;
use App\Answer;

class AnswerRepository
{
    public function create($attribute)
    {
        return Answer::create($attribute);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }
    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();
        return $answer->comments;
    }
}