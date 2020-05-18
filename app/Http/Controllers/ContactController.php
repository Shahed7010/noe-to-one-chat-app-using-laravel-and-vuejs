<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContacts(){
        $contacts = User::whereNotIn('id',[auth()->user()->id])->get();
        return response()->json($contacts);
    }
    public function getMessages($id){
        $messages = Message::where('from',$id)->orWhere('to',$id)->get();
        return response()->json($messages);
    }
    public function send(Request $request){
        $message = Message::create([
            'from' => auth()->user()->id,
            'to' => $request->contact_id,
            'text' => $request->message
        ]);
        broadcast(new SendMessage($message));
        return response()->json($message);
    }
}
