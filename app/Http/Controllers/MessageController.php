<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 

class MessageController extends Controller 
{
    public function list() 
    {
        $users = Auth::user()->getUserDMs();
        return view('pages.messages', ['users' => $users]);
    }

    public function show($id)
    {

        $user = Auth::user();
        $all_1 = Message::select('*')->where('received_id', Auth::user()->id)->where('emits_id', $id);
        $all_2 = Message::select('*')->where('received_id', $id)->where('emits_id',Auth::user()->id);
        $all = $all_1->union($all_2)->get();
        return view('pages.message', ['all' => $all]);
    }

    public function send(Request $request) 
    {
        $message = new Message();
        $message->emits_id = Auth::user()->id;
        $message->received_id = $request->received_id;
        $message->content = $request->input('content'); 
        $message->date = date('Y-m-d H:i:s');
        $message->save();
        return redirect()->back();

    
    }

}
