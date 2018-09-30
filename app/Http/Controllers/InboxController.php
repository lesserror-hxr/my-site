<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;

class InboxController extends Controller
{

    /**
     * InboxController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $messages = Message::where('to_user_id',user()->id)
            ->orWhere('from_user_id',user()->id)
            ->with(['fromUser' => function ($query){
                return $query->select(['id','name','avatar']);
            },'toUser' => function ($query){
                return $query->select(['id','name','avatar']);
            }])->latest()->get();

        return view('inbox.index',['messages' => $messages->groupBy('dialog_id') ]);
    }

    public function show($dialogId)
    {
        $messages = Message::where('dialog_id',$dialogId)->with(['fromUser' => function ($query){
            return $query->select(['id','name','avatar']);
        },'toUser' => function ($query){
            return $query->select(['id','name','avatar']);
        }])->latest()->get();

        $messages->markAsRead();

        return view('inbox.show',compact('messages','dialogId'));
    }

    public function store($dialogId)
    {
        $message   = Message::where('dialog_id',$dialogId)->first();

        $toUserId  = $message->from_user_id === user()->id ? $message->to_user_id : $message->from_user_id;
        Message::create([
            'from_user_id' => user()->id,
            'to_user_id'   => $toUserId,
            'body'         => request('body'),
            'dialog_id'    => $dialogId
        ]);

        return back();
    }
}
