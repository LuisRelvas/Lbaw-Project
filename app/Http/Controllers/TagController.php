<?php 

namespace App\Http\Controllers;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\User;
use App\Events\LikesSpaces;
use App\Models\Comment;

class TagController extends Controller 
{

    public static function tag(String $string){
        $words = explode(" ", $string);
        $modifiedWords = [];

        foreach($words as $word)
        {
            if($word[0] == "@")
            {
                $username = str_replace("@", "", $word);
                if(User::where('username', $username)->exists())
                {
                    $getUser = User::where('username', $username)->first();
                    $word = "<a href='/profile/$getUser->id'>$getUser->username</a>";
                }
            }
            $modifiedWords[] = $word;
        }

        $string = implode(" ", $modifiedWords);
        return $string; 
    }

}