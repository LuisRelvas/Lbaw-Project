<?php 

namespace App\Policies;

use App\Models\Comment; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;


class CommentPolicy 
{
    use HandlesAuthorization;

    public function delete(User $user, Comment $comment)
    {
        return (Auth::check() && Auth::user()->isAdmin(Auth::user())) || (Auth::check() && Auth::user()->id == $comment->author_id);
    }

    public function edit(User $user, Comment $comment)
    {
        return (Auth::check() && Auth::user()->isAdmin(Auth::user())) || (Auth::check() && Auth::user()->id == $comment->author_id);
    }

    public function create() 
    {
        return Auth::check();
    }

}
?>