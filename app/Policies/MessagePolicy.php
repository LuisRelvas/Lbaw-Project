<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    use HandlesAuthorization;

    public function list()
    {
        return Auth::check();
    }
    public function show() 
    {
        return Auth::check(); 
    }

    public function send() 
    {
        return Auth::check();
    }
}