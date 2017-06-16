<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Auth;
use App\Http\Requests\StoreQuestionRequest;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['show','index']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request) // 依赖注入
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $question = $this->questionRepository->create($data);

        // $topics 的value是topic的id值，这条问题与话题多对多attach后生成n条这个问题对应的话题
        $question->topics()->attach($topics);

        return redirect()->route('question.show',[$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // with 关联
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $question = $this->questionRepository->byId($id);
        $question->update([
            'title' => $request->get('title'),
            'body'  => $request->get('body'),
        ]);

        $question->topics()->sync($topics);

        return redirect()->route('question.show',[$question->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if(user()->owns($question)){
            $question->delete();
            return redirect('/');
        }
        abort(403,'Forbidden');//return back();
    }

    // 获取topic_id数组

}
