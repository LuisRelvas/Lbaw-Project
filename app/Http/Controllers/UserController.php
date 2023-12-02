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
use App\Models\FollowsRequest;
use App\Models\Notification;
use App\Models\UserNotification;

class UserController extends Controller {

    public function show(int $id)
    {
        if(Auth::check()){
        $user = User::findOrFail($id);
        $isBlocked = Block::where('user_id', $id)->exists();
        $isFollowing = Auth::user()->isFollowing($user);
        $wants = FollowsRequest::whereIn('user_id2',[$user->id])->get();
        return view('pages.user', [
            'user' => $user,
            'isFollowing' => $isFollowing,
            'isBlocked' => $isBlocked,
            'wants' => $wants
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

    Notification::insert([
        'received_user' => $id,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => now()
     ]);

     $lastNotification = Notification::orderBy('id', 'desc')->first();

     UserNotification::insert([
        'id' => $lastNotification->id,
        'notification_type' => 'started_following'
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


public function follow_request(Request $request) {
        $user = User::find($request->user_id2);
        DB::beginTransaction();
        FollowsRequest::insert([
            'user_id1' => $request->user_id1,
            'user_id2' => $user->id
        ]);

        Notification::insert([
            'received_user' => $user->id,
            'emits_user' => $request->user_id1,
            'viewed' => false,
            'date' => now()
        ]);

        $lastNotification = Notification::orderBy('id', 'desc')->first();

        UserNotification::insert([
            'id' => $lastNotification->id,
            'notification_type' => 'request_follow'
        ]);
        DB::commit();
}

public function accept_follow_request(Request $request) {
    $user1 = User::find($request->user_id1);
    $user2 = User::find($request->user_id2);
    DB::beginTransaction();
    FollowsRequest::where([
        'user_id1' => $user1->id,
        'user_id2' => $user2->id

    ])->delete();

    Notification::insert([
        'received_user' => $user1->id,
        'emits_user' => $user2->id,
        'viewed' => false,
        'date' => now()
    ]);

    $lastNotification = Notification::orderBy('id','desc')->first();

    $old = Notification::join('user_notification', 'notification.id', '=', 'user_notification.id')
    ->where('user_notification.notification_type', 'request_follow')
    ->orderBy('notification.id', 'desc')
    ->first();

    UserNotification::where('id',$old->id)->update([
        'notification_type' => 'accepted_follow'
    ]);

    
    Follow::insert([
        'user_id1' => $user1->id,
        'user_id2' => $user2->id
    ]);

    DB::commit();
}

public function decline_follow_request(Request $request) 
{
    $user1 = User::find($request->user_id1);
    $user2 = User::find($request->user_id2);
    DB::beginTransaction();
    FollowsRequest::where([
        'user_id1' => $user1->id,
        'user_id2' => $user2->id
    ])->delete();

    Notification::insert([
        'received_user' => $user1->id,
        'emits_user' => $user2->id,
        'viewed' => false,
        'date' => now()
    ]);

    UserNotification::insert([
        'notification_type' => 'declined_follow_request'
    ]);
    DB::commit();
}

public function search_exact(Request $request)
{
    $input = $request->input('search');
    $users = User::where('username', 'like', '%' . $input . '%')->orderBy('username')->get();
    return view('pages.search', ['users' => $users]);
}

}
?> 