<?php
namespace App;

use Illuminate\Database\Eloquent\Collection;

class MessageCollection extends Collection
{
	public function markAsRead()
	{
		//$message为model实例
		$this->each(function($message){
			if($message->to_user_id == user()->id){
				$message->markAsRead();
			} 
		});
	}
}