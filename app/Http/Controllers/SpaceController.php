<?php 

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\User;

class SpaceController extends Controller 
{

  public function show(int $id) : View
  {
      $space = Space::findOrFail($id);
      $user = User::findOrFail($space->user_id);
      $this->authorize('show', $user);
      return view('pages.space', [
          'space' => $space
      ]);
  }


  public function list()
  { 
      $publics = Space::publicSpaces()->get();
  
      if (!Auth::check()) {
          return view('pages.home', ['publics' => $publics, 'spaces' => $publics]);
      }
  
      $followingIds = Auth::user()->showFollows()->pluck('id');
      $spaces = Space::whereIn('user_id', $followingIds)->get(); 
      $mines = Space::where('user_id', Auth::user()->id)->get();
  
      return view('pages.home', [
          'publics' => $publics,
          'spaces' => $spaces,
          'mines' => $mines
      ]);
  }

 
    public function edit(Request $request)
    {
        $this->authorize('edit', Space::class);
        $space = Space::find($request->id);
        $space->content = $request->input('content');
        $space->is_public = $request->input('is_public', false); // Default to false if not provided
        $space->save();
    }


    public function add(Request $request)
    {
    $this->authorize('add', Space::class);
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

        return response()->json([
            'message' => 'Space deleted successfully',
            'isAdmin' => Auth::user()->isAdmin(Auth::user())
        ]);    
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'username');
    }
    public function searchPage() {
        $this->authorize('searchPage', User::class);
        return view('pages.search');
}
public function search(Request $request) 
{
    $input = $request->get('search', '*');
    
        $spaces = Space::select('id', 'content', 'date', 'user_id', 'group_id')
            ->whereRaw("tsvectors @@ to_tsquery(?)", [$input])
            ->orderByRaw("ts_rank(tsvectors, to_tsquery(?)) ASC", [$input])
            ->get();

    return view('partials.searchSpace', compact('spaces'))->render();
}


}




?>