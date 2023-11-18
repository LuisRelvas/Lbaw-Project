<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Space;

class SpaceController extends Controller 
{

  public function show(int $id) : View
  {
      $space = Space::findOrFail($id);
      return view('pages.space', [
          'space' => $space
      ]);
  }


  public function list()
  { 
    if (!Auth::check()) {
      $spaces = Space::publicSpaces()->get();
      return view('pages.home', ['spaces' => $spaces]);
    }
    $followingIds = Auth::user()->showFollows()->pluck('id');
    $spaces = Space::whereIn('user_id', $followingIds)->get(); 
    return view('pages.home', [
        'spaces' => $spaces
    ]);
  }

 
    public function edit(Request $request)
    {
        $space = Space::find($request->id);
        $space->content = $request->input('content');
        $space->is_public = $request->input('is_public', false); // Default to false if not provided
        $space->save();
    }


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

    public function delete($id)
    {
        $space = Space::find($id);

        if (!$space) {
            return response()->json(['error' => 'Space not found'], 404);
        }

        $space->delete();

        return response()->json(['message' => 'Space deleted successfully']);
    }

}




?>