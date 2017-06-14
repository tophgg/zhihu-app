<?php
/**
 * Created by PhpStorm.
 * User: KF012
 * Date: 2017/6/2
 * Time: 14:01
 */

namespace App\Repositories;
use App\Comment;

class CommentRepository
{
    public function create($attribute)
    {
        return Comment::create($attribute);
    }

    public function byId($id)
    {
        return Comment::find($id);
    }
}