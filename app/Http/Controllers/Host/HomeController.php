<?php

namespace App\Http\Controllers\Host;

use App\Apartment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index(){
        return view('host.home');
    }

    public function listMessage(){
        $user_id = Auth::user()->id;

        $apartments = Apartment::where('user_id', $user_id)->get();
        $apartments_id = [];
        foreach($apartments as $apartment){
            array_push($apartments_id, $apartment->id);
        }

        $messages = Message::all();
        $messages_id= [];
        foreach($messages as $message){
            array_push($messages_id, $message->apartment_id);
        }

        // $user_messages = Message::find(in_array('apartment_id', $apartments_id));
        $user_messages = [];
        foreach($messages as $message){
            if(in_array($message->apartment_id, $apartments_id)){
                array_push($user_messages, $message);
            }
        };

        return view('host.messages.index', compact('apartments', 'user_messages'));
    }

    public function showMessage($id){
        $message = Message::where('id', $id)->first();
        return view('host.messages.show', compact('message'));
    }

    public function destroyMessage(Message $message){
        $message->delete();
        return redirect()->route('host.messages')->with('deleted-message', 'Messaggio eliminato');
    }
}
