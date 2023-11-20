<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\Follow;
use Illuminate\Support\Facades\DB;
use App\Models\Block;


class UserController extends Controller {

    public function show(int $id)
    {
        if(Auth::check()){
        $user = User::findOrFail($id);
        $isBlocked = Block::where('user_id', $id)->exists();
        $isFollowing = Auth::user()->isFollowing($user);
        return view('pages.user', [
            'user' => $user,
            'isFollowing' => $isFollowing,
            'isBlocked' => $isBlocked
        ]);}
        else
        {
            $user = User::findOrFail($id);
            if($user->is_public == 1)
            {
                return back()->withErrors([
                    'profile' => 'The provided profile is private.'
                ]);
            }
            else{
            return view('pages.user', [
                'user' => $user,
            ]);}
        }
    }


public function editUser()
{
    $this->authorize('editUser', Auth::user());
    if(Auth::check()){
    return view('pages.editUser',['user'=> Auth::user()->name,
                            Auth::user()->email,
                            Auth::user()->password
    ]);}
    else 
    {
        return redirect('/homepage');
    }
}


 public function follow(Request $request, $id) {
    $this->authorize('follow', User::class);
     Follow::insert([
         'user_id1' => Auth::user()->id,
         'user_id2' => $id,
     ]);
     return redirect('/profile/'.$id)->withSuccess('Followed successfully!');
 }

 public function unfollow(Request $request, $id) {
    $this->authorize('unfollow', User::class);
    Follow::where('user_id1', Auth::user()->id)->where('user_id2', $id)->delete();
    return redirect('/profile/'.$id)->withSuccess('Unfollowed successfully!');
}

public function edit(Request $request) 
{   
    $this->authorize('edit', User::class);
    if(Auth::user()->isAdmin(Auth::user()))
    {
        $user = User::find($request->input('user_id'));
        if($request->name != null)
        {
            $user->name = $request->name;             
        }
        if($request->email != null)
        {
            $user->email = $request->email;
        }
        if($request->is_public != null)
        {
            $user->is_public = $request->is_public;
        }
        if($request->password != null) 
        {
            $user->password = $request->password;
         }
        $user->save();
        return redirect('/profile/'.$user->id)->withSuccess('User edited successfully!');
    }
    else{
    $user = Auth::user();
    if($request->name == null) 
    {
        $user->name = Auth::user()->name;
    }
    else if($request-> name != null) 
    {
        $user->name = $request->name;
    }
    if($request->email == null)
    {
        $user->email = Auth::user()->email;
    }
    else if($request->email != null)
    {
        $user->email = $request->email;
    }
    if($request->is_public == null) 
    {
        $user->is_public = Auth::user()->is_public;
    }
    else if($request->is_public != null)
    {
        $user->is_public = $request->is_public;
    }
    $user->password = $request->password;
    $user->save();
    return redirect('/profile/'.$user->id)->withSuccess('User edited successfully!');}

}

public function delete(Request $request, $id)
    {
        $this->authorize('delete', User::class);
        // Find the user.
        $user = User::find($id);

        // Delete the user and return it as JSON.
        $user->delete();
        redirect('/homepage')->withSuccess('User deleted successfully!');
        return response()->json($user);
    }

public function searchPage() {
        return view('pages.search');
}

public function search(Request $request) {
        
    $input = $request->get('search') ? $request->get('search').':*' : "*";
    $users = User::select('users.id', 'users.name', 'users.username')
    ->whereRaw("users.tsvectors @@ to_tsquery(?)", [$input])
    ->get();

        return view('partials.searchUser', compact('users'))->render();
    }


}

?> 