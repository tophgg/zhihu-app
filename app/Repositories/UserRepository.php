<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/9
 * Time: 23:33
 * Describ:
 */
namespace App\Repositories;
use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}