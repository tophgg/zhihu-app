<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopicsController extends Controller
{
	protected $topic;
	public function __construct(TopicsRepository $topic)
	{
		$this->topic = $topic
	}
    public function index(Request $request)
    {
        $this->topic->getTopicsForTagging($request);
    }
}
