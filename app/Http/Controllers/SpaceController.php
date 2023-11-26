<?php 

namespace App\Http\Controllers;
use App\Models\LikesSpaces;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\User;

class SpaceController extends Controller 
{

    public function show(int $id)
    {
        $space = Space::findOrFail($id);
        $user = User::findOrFail($space->user_id);
        if($user->is_public == 0 || (Auth::check() && Auth::user()->id == $space->user_id) || (Auth::Check() && Auth::user()->isAdmin(Auth::user())) || (Auth::check() &&Auth::user()->isFollowing($user))){
        {
            return view('pages.space', [
                'space' => $space
            ]);}
        } else {
            return back()->withErrors([
                'profile' => 'The provided space is private.'
            ]);
        }
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
        $space = Space::find($request->id);
        $this->authorize('edit', [Auth::user(),$space]);
        $space->content = $request->input('content');
        $space->is_public = $request->input('is_public', false);
        $space->save();
        return redirect('/space/'.$request->space_id)->withSuccess('Space edited successfully!');

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
      return redirect('/homepage')->withSuccess('Space created successfully!');
    }

    public function delete($id)
    {

        $space = Space::find($id);

        if (!$space) {
            return response()->json(['error' => 'Space not found'], 404);
        }

        $space->delete();

        return response()->json([
            'isAdmin' => Auth::user()->isAdmin(Auth::user()),
            redirect('/homepage')->withSuccess('Space deleted successfully!')
        ]);    
    }

    public function searchPage() {
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


public function like_on_spaces(Request $request) 
{
    $space = Space::find($request->id);

    LikesSpaces::insert([
        'user_id' => Auth::user()->id,
        'space_id' => $space->id
    ]);
}

public function unlike_on_spaces(Request $request)
{
    $space = Space::find($request->id);

    LikesSpaces::where('user_id', Auth::user()->id)
        ->where('space_id', $space->id)
        ->delete();
}
}





?>