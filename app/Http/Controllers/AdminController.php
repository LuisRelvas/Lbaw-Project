<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;
use App\Models\User;
use App\Models\Space;
use App\Models\Comment;
use App\Models\Block;
class AdminController extends Controller 
{
    public function show()
    {  
        return view('pages.admin');
    }

    public function block(Request $request) 
    {
        Block::insert(['user_id' => $request->id]);
        return redirect('/profile/'.$request->id);

    }

    public function unblock(Request $request)
    {
        Block::where(['user_id' => $request->id])->delete();
        return redirect('/profile/'.$request->id);
    }



}

?>