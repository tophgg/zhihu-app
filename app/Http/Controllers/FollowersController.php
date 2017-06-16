<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if(in_array(user('api')->id,$followers)){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow()
    {
        $user = user('api');
        $userToFollow = $this->user->byId(request('user'));
        $followed = $user->followThisUser($userToFollow->id);
        if(count($followed['detached']) >0){
            $userToFollow->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        // 发私信
        $userToFollow->notify(new NewUserFollowNotification());
        $userToFollow->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
