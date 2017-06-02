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
}