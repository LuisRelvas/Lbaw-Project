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
use App\Models\Group;
use App\Models\Comment;

class UserController extends Controller {

    public function show(int $id)
    {
        if(Auth::check()){
        $user = User::findOrFail($id);
        $isBlocked = Block::where('user_id', $id)->exists();
        $isFollowing = Auth::user()->isFollowing($user);
        $wants = FollowsRequest::whereIn('user_id2',[$user->id])->get();
        $countFollows = Follow::where('user_id1', $user->id)->count();
        $countFollowers = Follow::where('user_id2', $user->id)->count();
        return view('pages.user', [
            'user' => $user,
            'isFollowing' => $isFollowing,
            'isBlocked' => $isBlocked,
            'wants' => $wants,
            'countFollows' => $countFollows,
            'countFollowers' => $countFollowers
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
    if(Auth::user()->id == $id)
    {
        Follow::where('user_id1', $request->input('id'))->where('user_id2', $id)->delete();
        return redirect('/profile/'.$id)->withSuccess('Unfollowed successfully!');
    }
    else{
    Follow::where('user_id1', Auth::user()->id)->where('user_id2', $id)->delete();
    return redirect('/profile/'.$id)->withSuccess('Unfollowed successfully!');}
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
    if($request->file('image') != null)
    {
        if( !in_array(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION),['jpg','jpeg','png'])) {
            return redirect('user/edit')->with('error', 'File not supported');
        }
        $request->validate([
            'image' =>  'mimes:png,jpeg,jpg',
        ]);
        UserController::update($user->id,'profile',$request);
    }
    $user->password = $request->password;
    $user->save();
    return redirect('/profile/'.$user->id)->withSuccess('User edited successfully!');}

}

public function update(int $id, string $type, Request $request)
{
    if ($request->file('image')) {
        foreach ( glob(public_path().'/images/'.$type.'/'.$id.'.*',GLOB_BRACE) as $image){
            if (file_exists($image)) unlink($image);
        }
    }
    $file= $request->file('image');
    $filename= $id.".jpg";
    $file->move(public_path('images/'. $type. '/'), $filename);
}


public function updatePhoto(Request $request, $id)
{
    $user = User::find($id);
    if($request->hasFile('profile_picture')) {
        $filename = $user->id . '.jpg';
        $request->profile_picture->move(public_path('images/profile'), $filename);
    }

    return redirect('/profile/' . $id);
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

    UserNotification::insert([
        'id' => $lastNotification->id,
        'user_id' => $user1->id,
        'notification_type' => 'accepted_follow'
    ]);

    
    Follow::insert([
        'user_id1' => $user1->id,
        'user_id2' => $user2->id
    ]);

    DB::commit();
    return response()->json(['sucess' => 'User accepted successfully']);
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

    DB::commit();
    return response()->json(['sucess' => 'User declined successfully']);

}


public function search_exact(Request $request)
{
    $date = $request->input('date');
    $input = $request->input('search');
    $profileType = $request->input('profileType');
    $spaceType = $request->input('spaceType');
    $groupType = $request->input('groupType');
    $users = collect(); 
    $spaces = collect();
    $groups = collect();
    $comments = collect();
    if($date != null) 
    {
        $spaces = Space::where('content', 'like', '%' . $input . '%')->where('date',$date)->orderBy('content')->get();
        $comments = Comment::where('content', 'like', '%' . $input . '%')->where('date',$date)->orderBy('content')->get(); 
    }
    if($input == null && $date == null && $profileType == null && $spaceType == null && $groupType == null)
    {
        return view('pages.search', ['users' => $users, 'spaces' => $spaces, 'comments' => $comments, 'groups' => $groups]);
    }
    if($profileType != null) 
    {
        if($profileType == 'public') 
        {
            $users = User::where('username', 'like', '%' . $input . '%')->where('is_public',false)->orderBy('username')->get();

        }
        else if($profileType == 'private')
        {
            $users = User::where('username', 'like', '%' . $input . '%')->where('is_public',true)->orderBy('username')->get();
        }
    }
    if($spaceType != null) 
    {
        if($spaceType == 'public') 
        {
            $spaces = Space::where('content', 'like', '%' . $input . '%')->where('is_public',false)->orderBy('content')->get();
        }
        else if($spaceType == 'private')
        {
            $spaces = Space::where('content', 'like', '%' . $input . '%')->where('is_public',true)->orderBy('content')->get();
        }
    }
    if($groupType != null) 
    {
        if($groupType == 'public') 
        {
            $groups = Group::where('name', 'like', '%' . $input . '%')->where('is_public',false)->orderBy('name')->get();
        }
        else if($groupType == 'private')
        {
            $groups = Group::where('name', 'like', '%' . $input . '%')->where('is_public',true)->orderBy('name')->get();
        }
    }
    if($input != null) {
    $spaces = Space::where('content', 'like', '%' . $input . '%')->orderBy('content')->get();
    $users = User::where('username', 'like', '%' . $input . '%')->orderBy('username')->get();
    $groups = Group::where('name', 'like', '%' . $input . '%')->orderBy('name')->get();
    $comments = Comment::where('content', 'like', '%' . $input . '%')->orderBy('content')->get();}

    return view('pages.search', ['users' => $users, 'spaces' => $spaces, 'comments' => $comments, 'groups' => $groups]);

}

}
?> 