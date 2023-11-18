<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\Follow;

class UserController extends Controller {


    public function show(int $id)
    {
        $user = User::findOrFail($id);
        $isFollowing = Auth::user()->isFollowing($user);
        return view('pages.user', [
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }


public function editUser() : View
{
    return view('pages.editUser',['user'=> Auth::user()->name,
                            Auth::user()->email,
                            Auth::user()->password
]);
}


 public function follow(Request $request, $id) {
    
     Follow::insert([
         'user_id1' => Auth::user()->id,
         'user_id2' => $id,
     ]);
     return redirect('/profile/'.$id);
 }

 public function unfollow(Request $request, $id) {
    Follow::where('user_id1', Auth::user()->id)->where('user_id2', $id)->delete();
    return redirect('/profile/'.$id);
}

public function edit(Request $request) 
{   
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
    return redirect('/profile/'.$user->id);

}

public function delete(Request $request, $id)
    {
        echo('the value of the id is: '.$id);
        // Find the user.
        $user = User::find($id);

        // Delete the user and return it as JSON.
        $user->delete();

        return response()->json($user);
    }

public function searchPage() {
        $this->authorize('searchPage', User::class);
        return view('pages.search');
}

public function search(Request $request) {
        
    if (!Auth::check()) return null;
    $input = $request->get('search') ? $request->get('search').':*' : "*";
    $users = User::select('users.id', 'users.name', 'users.username')
    ->whereRaw("users.tsvectors @@ to_tsquery(?)", [$input])
    ->get();

        return view('partials.searchUser', compact('users'))->render();
    }

}

?> 