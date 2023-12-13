<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Models\Space;
use App\Models\User;
class FileController extends Controller 
{
    public static function update(int $id, string $type, Request $request)
    {
    if ($request->file('image')) {
        foreach ( glob(public_path().'/images/'.$type.'/'.$id.'.*',GLOB_BRACE) as $image){
            if (file_exists($image)) unlink($image);
        }
    }
    $file= $request->file('image');
    $filename= $id.".jpg";
    $file->move(public_path('images/'. $type. '/'), $filename);
    }
}