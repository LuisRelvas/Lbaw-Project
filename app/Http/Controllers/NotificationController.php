<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Space;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\SpaceNotification;
use App\Models\UserNotification;
use App\Models\CommentNotification;
use App\Models\GroupNotification;
use App\Models\User;

class NotificationController extends Controller
{
    public function list() 
    {
        if(!Auth::check())
        {
            return redirect('/homepage')->with('error','qualquer coisa');
        }
        $notifications = Notification::where('received_user', Auth::user()->id)->get();
        $notificationsIds = $notifications->pluck('id');
        $userNotifications = UserNotification::whereIn('id', $notificationsIds)->get();
        $spaceNotifications = SpaceNotification::whereIn('id', $notificationsIds)->get();
        $commentNotifications = CommentNotification::whereIn('id', $notificationsIds)->get();
        $groupNotifications = GroupNotification::whereIn('id', $notificationsIds)->get();
        $notifications = $userNotifications->merge($spaceNotifications)->merge($commentNotifications)->merge($groupNotifications);
        $final = [];
        foreach($notifications as $notification) 
        {
            $type = $notification->notification_type;
            $aux = Notification::select('emits_user')->where('id',$notification->id)->first();
            $name = User::select('name')->where('id',$aux->emits_user)->first();
            array_push($final,[$type,$name]);
        }
        return response()->json($final);
    }

    public function edit(int $id) 
    {
        $notification = Notification::findOrFail($id);
        $notification->viewed = true;
        $notification->save();
        return redirect('/notification')->with('success', 'Notification updated successfully!');
    }


    public function delete(int $id) 
    {
        $notification = Notification::findOrFail($id);
        DB::beginTransaction();
        UserNotification::where('id', $id)->delete();
        SpaceNotification::where('id', $id)->delete();
        CommentNotification::where('id', $id)->delete();
        GroupNotification::where('id', $id)->delete();
        DB::commit();
        $notification->delete();   
        return redirect('/notification')->with('success', 'Notification deleted successfully!');
    }

}