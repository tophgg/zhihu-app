<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/14
 * Time: 0:28
 * Describ:
 */

namespace App\Repositories;


use App\Message;

class MessageRepository
{
    public function create($attribute)
    {
        return Message::create($attribute);
    }

    public function byId($id)
    {
        return Message::find($id);
    }
}