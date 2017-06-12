<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/11
 * Time: 10:37
 * Describ:
 */

namespace App\Mailer;
use Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function sendTo($template, $email, $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use($email){
            $message->from('395886828@qq.com', 'Zhihu');
            $message->to($email);
        });
    }
}