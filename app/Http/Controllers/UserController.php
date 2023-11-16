<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TagController;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;
use App\Models\Group;
use App\Models\Follow;
use App\Models\Blocked;
use App\Models\Configuration;
use App\Models\Notification;
use App\Models\RequestFollow;
use App\Http\Controllers\Controller;
use App\Models\UserNotification;

class UserController extends Controller {


public function getUser() 
{
    if(!Auth::check()){
        return redirect('/login');
    }
    else 
    {
        $user = Auth::user();
        return view('pages.user', [
            'user' => $user
        ]);
    }
}    
public function show(int $id) : View
{

    
    $user = User::findOrFail($id);
    return view('pages.user', [
        'user' => $user
    ]);

}
}

?> 