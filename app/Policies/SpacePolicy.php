<?php 

namespace App\Policies;

use App\Models\Space;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SpacePolicy
{
    use HandlesAuthorization;

    public function show(?User $user,Space $space)
    {
    // echo ("<script>console.log('PHP:')</script>");
    return ($user->is_public === false || 
        (Auth::check() && (Auth::user()->isAdmin(Auth::user()) || 
                           Auth::user()->id == $user->id || 
                           Auth::user()->isFollowing($user->id))));
    }   

    public function add(User $user) 
    {
        return $user->id == Auth::user()->id;
    }
    public function edit(User $user, Space $space)
    {
        return ((Auth::check() && Auth::user()->isAdmin(Auth::user())) || (Auth::check() && Auth::user()->id == $space->user_id));
    }
    public function delete(User $user, Space $space)
    {
        return (Auth::check() && Auth::user()->isAdmin(Auth::user())) || (Auth::check() && Auth::user()->id == $space->user_id);
    }
    public function search()
    {
        return Auth::check();
    }
}


?>