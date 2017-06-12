<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/11
 * Time: 10:39
 * Describ:
 */

namespace App\Mailer;
use Auth;

class UserMailer extends Mailer
{
    public function followNotify($email)
    {
        $data = [
            'url' => 'http://zhihu.dev',
            'name' => Auth::guard('api')->user()->name,
        ];

        $this->sendTo('zhihu_app_new_follower', $email, $data);
    }

    public function userRegister($user)
    {
        $data = [
            'url' => route('email.verify',['token' => $user->confirmation_token]),
            'name' => $user->name,
        ];

        $this->sendTo('zhihu_app_register', $user->email, $data);
    }

    public function passwordReset($email,$token)
    {
        $data = [
            'url' => url('password/reset', $token)
        ];

        $this->sendTo('zhihu_app_password_reset', $email, $data);
    }
}