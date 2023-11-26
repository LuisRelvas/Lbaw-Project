<?php

namespace App\Http\Controllers;
use App\Models\CommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Comment;
use App\Models\Space;   
use App\Models\LikesComments;
use App\Models\LikesSpaces; 
use App\Models\Notification;


class CommentController extends Controller 
{
    public function create(Request $request) 
    {
        $this->authorize('create', Comment::class);
        $comment = new Comment();
        $comment->author_id = Auth::user()->id;
        $comment->space_id = $request->space_id;
        $comment->username = Auth::user()->username;
        $comment->content = $request->content;
        $comment->date = date('Y-m-d H:i');
        $comment->save();
        return redirect('/space/'.$request->space_id)->withSuccess('Comment created successfully!');
    }

    public function edit(Request $request)
    {
        $comment = Comment::find($request->id);
        $this->authorize('edit', $comment);
        $comment->content = $request->input('content');
        $comment->save();
        return redirect('/space/'.$request->space_id)->withSuccess('Comment edited successfully!');
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        $this->authorize('delete', $comment);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $comment->delete();
        redirect('/space/'.$comment->space_id)->withSuccess('Comment deleted successfully!');
        return response()->json(['message' => 'Comment deleted successfully']);
    }


    public function like_on_comments(Request $request) 
{
    $comment = Comment::find($request->id);

    LikesComments::insert([
        'user_id' => Auth::user()->id,
        'comment_id' => $comment->id
    ]);

    Notification::insert([
        'received_user' => $comment->author_id,
        'emits_user' => Auth::user()->id,
        'viewed' => false,
        'date' => date('Y-m-d H:i'),
    ]); 

    $lastNotification = Notification::orderBy('id', 'desc')->first();

    CommentNotification::insert([
        'id' => $lastNotification->id,
        'comment_id' => $comment->id,
        'notification_type' => 'liked_comment'
    ]);
}

public function unlike_on_comments(Request $request)
{
    $comment = Space::find($request->id);
    
    $commentNotification = CommentNotification::where('comment_id', $comment->id)
        ->where('notification_type', 'liked_comment')
        ->first();
    
    if ($commentNotification) {
        $id = $commentNotification->id;
        $commentNotification->delete();
    }

    LikesComments::where('user_id', Auth::user()->id)
        ->where('comment_id', $comment->id)
        ->delete();
    Notification::where('id', $commentNotification->id)
        ->delete();
    
}
  
    
}


?>