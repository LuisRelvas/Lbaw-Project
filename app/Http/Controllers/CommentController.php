<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Comment;
use App\Models\Space;    


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
  
    
}


?>