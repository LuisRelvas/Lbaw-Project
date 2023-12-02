<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use App\Events\Messages;
use App\Models\Follow;

class MessageController extends Controller 
{
    public function list() 
    {
        $users = Auth::user()->getUserDMs();
        $emits_ids = collect($users)->pluck('emits_id');
        
        $followings = Follow::select('*')->where('user_id1',Auth::user()->id)->get();
        $followings = $followings->reject(function ($following) use ($emits_ids) {
            return $emits_ids->contains($following->user_id2);
        });
        return view('pages.messages', ['users' => $users,'followings' => $followings]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $all_1 = Message::select('*')->where('received_id', Auth::user()->id)->where('emits_id', $id);
        $all_2 = Message::select('*')->where('received_id', $id)->where('emits_id',Auth::user()->id);
        $all = $all_1->union($all_2)->get();
        return view('pages.message', [
            'all' => $all
    ]);
    }

    public function send(Request $request) 
    {
        $message = new Message();
        $message->emits_id = Auth::user()->id;
        $message->received_id = $request->received_id;
        $message->content = $request->input('content'); 
        $message->date = now(); // Use the now() helper to get the current timestamp
        $message->save();
        broadcast(new Messages($message))->toOthers();
        

        return redirect()->back();
    }
}
