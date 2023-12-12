<?php 

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy 
{
    use HandlesAuthorization;

    public function show(User $user,User $user2)
    {
        return (Auth::user() || $user->is_public == false);
    }

    public function editUser(User $user) 
    {
        return $user->id == Auth::user()->id;
    }

    public function edit()
    {
        return Auth::check();
    }
    public function searchPage()
    {
        return Auth::check();
    }
    public function search() 
    {
        return Auth::check();
    }

    public function delete (User $user)
    {
        return ((Auth::check() && Auth::user()->isAdmin(Auth::user()))|| (Auth::check() && Auth::user()->id == $user->id));
    }

    public function follow() 
    {
        return Auth::check();
    }
    public function unfollow(User $user)
    {
        return (Auth::check());
    }

    public function request(User $user) 
    {
        return ((Auth::check() && Auth::user()->isAdmin(Auth::user()))|| (Auth::check() && Auth::user()->id == $user->id));
    }
}




?>