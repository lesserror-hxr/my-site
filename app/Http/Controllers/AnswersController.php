<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

class AnswersController extends Controller
{
    protected $answer;

    /**
     * AnswersController constructor.
     *
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function store(StoreAnswerRequest $request,$question)
    {
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id'     => Auth::id(),
            'body'        => $request->get(),
        ]);

        $answer->question()->increment('answers_count');

        return back();
    }
}
