<?php
/**
 * Created by PhpStorm.
 * User: KF012
 * Date: 2017/6/1
 * Time: 16:46
 */

namespace App\Repositories;

use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    public function create($attribute)
    {
        return Question::create($attribute);
    }
    public function byId($id)
    {
        return Question::find($id);
    }

    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id',$id)->with(['topics','answers'])->first();
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            $newTopic = Topic::create(['name' => $topic,'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function getQuestionFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }
}