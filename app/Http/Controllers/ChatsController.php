<?php

namespace App\Http\Controllers;

use App\Message;
use App\Events\MessageSent;
use App\Events\UpdateRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ChatsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show chats
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('chat');
  }

  /**
  * Fetch all messages
  *
  * @return Message
  */
  public function fetchMessages(Request $req, $id)
  {
    $messages =  DB::table('messages')->where('order_id', $id)->get();
    return $messages;
  }

  public function getMessage(Request $request)
  {
    //return $request->user();
    //$user = Auth::user();

  }
  /**
  * Persist message to database
  *
  * @param  Request $request
  * @return Response
  */
  public function sendMessage(Request $request)
  {
    $user = Auth::user();
    $arr = $request['message'];
    $deArr = json_decode($arr);
    $message = $user->messages()->create([
      'message' => $deArr->message,
      'order_id' => $request['order_id'],
      'user_name' => $user->name,
    ]);

    //dd($request);
    //$order_id = $request->$order_id;

    broadcast(new MessageSent($user->name, $message))->toOthers();
    broadcast(new UpdateRequest())->toOthers();


    return ['status' => 'Message Sent!'];
  }
}
