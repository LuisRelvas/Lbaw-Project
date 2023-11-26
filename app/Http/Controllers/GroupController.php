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
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use App\Models\GroupJoinRequest;
use App\Models\Notification;
use App\Models\GroupNotification;

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
        $members = $group->members;
        $joins = GroupJoinRequest::whereIn('group_id', [$group->id])->get();
        return view('pages.group',['group' => $group, 'members' => $members, 'joins' => $joins]);
    }

    public function list() 
    {
        $user = Auth::user(); 
        $groups = Group::whereIn('user_id', [$user->id])->get();
        $publics = Group::where('is_public',false)->get();
        return view('pages.listGroups',[
        'groups' => $groups,
        'publics' => $publics]);
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

    public function join(Request $request) 
    {
        $group = Group::find($request->id);  

        DB::beginTransaction(); 

        Member::insert([
            'user_id' => Auth::user()->id,
            'group_id' => $group->id,
            'is_favorite' => false
        ]);

        Notification::insert([
            'received_user' => $group->user_id,
            'emits_user' => Auth::user()->id,
            'viewed' => false,
            'date' => date('Y-m-d H:i')
        ]);

        $lastNotification = Notification::orderBy('id', 'desc')->first();

        GroupNotification::insert([
            'id' => $lastNotification->id,
            'group_id' => $group->id,
            'notification_type' => 'joined group'
        ]);

        DB::commit();
    }

    public function leave_group(Request $request) 
{
    $group = Group::find($request->id);
    DB::beginTransaction();
    Member::where('group_id', $group->id)->where('user_id', Auth::user()->id)->delete();
    Notification::insert([
        'received_user' => $group->user_id,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => date('Y-m-d H:i')
    ]);
    $lastNotification = Notification::orderBy('id','desc')->first();
    GroupNotification::insert([
        'id' => $lastNotification->id,
        'group_id' => $group->id,
        'notification_type' => 'leave group'
    ]);
    DB::commit();
}

public function remove_member(Request $request)
{
    DB::beginTransaction();

    Member::where('group_id', $request->groupId)->where('user_id', $request->userId)->delete();  // Corrected line

    Notification::insert([
        'received_user' => $request->userId,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => date('Y-m-d H:i')
    ]);
    $lastNotification = Notification::orderBy('id','desc')->first();
    GroupNotification::insert([
        'id' => $lastNotification->id,
        'group_id' => $request->groupId,
        'notification_type' => 'remove'
    ]);

    DB::commit();

    return response()->json([
        'success' => 'Member removed successfully!'
    ]);
}

public function join_request(Request $request)
{
    $group = Group::find($request->id);  

    DB::beginTransaction(); 

    GroupJoinRequest::insert([
        'user_id' => Auth::user()->id,
        'group_id' => $group->id,
    ]);

    Notification::insert([
        'received_user' => $group->user_id,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => date('Y-m-d H:i')
    ]);
    $lastNotification = Notification::orderBy('id','desc')->first();
    GroupNotification::insert([
        'id' => $lastNotification->id,
        'group_id' => $group->id,
        'notification_type' => 'request_join'
    ]);
    DB::commit();
}

public function accept_join_request(Request $request)
{
    $group = Group::find($request->group_id);
    DB::beginTransaction();
    GroupJoinRequest::where([
        'user_id' => $request->id,
        'group_id' => $group->id
    ])->delete();    
    
    Member::insert([
        'user_id' => $request->id,
        'group_id' => $group->id,
        'is_favorite' => false
    ]);

    Notification::insert([
        'received_user' => $request->id,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => date('Y-m-d H:i')
    ]);
    $lastNotification = Notification::orderBy('id','desc')->first();
    GroupNotification::insert([
        'id' => $lastNotification->id,
        'group_id' => $group->id,
        'notification_type' => 'accepted_join'
    ]);
    

    DB::commit();
}

public function decline_join_request(Request $request)
{
    $group = Group::find($request->group_id);
    DB::beginTransaction();
    GroupJoinRequest::where([
        'user_id' => $request->id,
        'group_id' => $group->id
    ])->delete();    
    DB::commit();
    
}

public function invite(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'group_id' => 'required|exists:groups,id',
    ]);

    $group = Group::find($request->input('group_id'));
    $userToInvite = User::where('email', $request->input('email'))->first();

    // Send a notification to the user
    $userToInvite->notify(new InviteNotification($group));

    return back()->with('success', 'Invitation sent!');
}

}


?>
