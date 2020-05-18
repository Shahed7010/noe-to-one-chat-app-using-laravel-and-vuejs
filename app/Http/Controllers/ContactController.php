<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{
    public function getContacts(){
        $contacts = User::where('id','!=',[auth()->user()->id])->get();
        $unreadIds = Message::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->user()->id)
            ->where('read', false)
            ->groupBy('from')->get();
        $contacts = $contacts->map(function ($contact) use ($unreadIds){
            $unreadId = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $unreadId ? $unreadId->messages_count : 0 ;
            return $contact;
        });
        return response()->json($contacts);
    }
    public function getMessages($id){
        Message::where('from', $id)->where('to', auth()->user()->id)->update(['read'=>true]);
        $messages = Message::where(function ($q) use ($id){
            $q->where('from', auth()->user()->id);
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id){
            $q->where('from', $id);
            $q->where('to', auth()->user()->id);
        })->get();
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
