<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Models\Space;
use App\Models\Comment;

class GroupController extends Controller 
{
    public function add(Request $request)
    {
        $group = new Group();
        $group->name = $request->input('name');
        $group->user_id = Auth::user()->id;
        $group->description = $request->input('description');
        $group->is_public = null !== $request->public;
        $group->save();
        return redirect('/homepage')->withSuccess('Group created successfully!');
    } 

    public function show(int $id) 
    {
        $group = Group::findOrFail($id);
        return view('pages.group',['group' => $group]);
        
    }

    public function edit(Request $request)
    {
        $group = Group::find($request->id);
    
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();
    
        return redirect('/group/'.$request->id)->withSuccess('Group description edited successfully!');
    }

    public function delete(int $id)
    {
        $group = Group::find($id);
        $group->delete();

        // Check if the user is an admin
        $isAdmin = Auth::check() && Auth::user()->isAdmin(Auth::user());

        // Return a JSON response
        return response()->json([
            'success' => 'Group deleted successfully!',
            'isAdmin' => $isAdmin
        ]);
    }
    


}


?>
