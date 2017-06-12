<?php
/**
 * Created by PhpStorm.
 * User: dxh
 * Date: 2017/6/11
 * Time: 10:12
 * Describ:
 */

namespace App\Channel;


use Illuminate\Notifications\Notification;

class SendCloudChannel
{
    public function send($notifiable,Notification $notification)
    {
        $message = $notification->toSendCloud($notifiable);
    }
}