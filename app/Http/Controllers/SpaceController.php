<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Space;

class SpaceController extends Controller 
{
    public function add(Request $request)
    {
    $space = new Space();
      $space->user_id = Auth::user()->id;
      $space->group_id = null;
      $space->is_public = false;
      $space->content = $request->input('content');
      $space->date = date('Y-m-d H:i');
      $space->is_public = null !== $request->input('public');
      $space->save();
      return redirect('/homepage');
    }

}




?>