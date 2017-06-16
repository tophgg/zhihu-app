<?php
/**
 * Created by PhpStorm.
 * User: KF012
 * Date: 2017/6/1
 * Time: 16:46
 */

namespace App\Repositories;

use App\Topic;

/**
 * Class TopicsRepository
 * @package App\Repositories
 */
class TopicsRepository
{
    public function create($attribute)
    {
        return Topic::create($attribute);
    }
    public function byId($id)
    {
        return Topic::find($id);
    }
    public function getTopicsForTagging(Request $request)
    {
        $topics = Topic::select(['id','name'])->where('name','like','%'.$request->query('q').'%')
            ->get();
        return $topics;
    }
}