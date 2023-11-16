<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TagController;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Follow;
use App\Models\Blocked;
use App\Models\Configuration;
use App\Models\Notification;
use App\Models\RequestFollow;
use App\Http\Controllers\Controller;
use App\Models\UserNotification;

class UserController extends Controller {


 public function show(int $id) : View
{

    
    $user = User::findOrFail($id);
    return view('pages.user', [
        'user' => $user
    ]);
}

public function editUser() : View
{
    return view('pages.editUser',['user'=> Auth::user()->name,
                            Auth::user()->email,
                            Auth::user()->password
]);
 }

public function edit(Request $request) 
{   
    $user = Auth::user();
    $user->name = $request->name;
    $user->email = $request->email;
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
    $users = User::select('users.id', 'users.name')->get();

        return view('partials.searchUser', compact('users'))->render();
    }

}

?> 