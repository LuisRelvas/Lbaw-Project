<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class Space extends Model
{
    protected $table = 'space';

    public $timestamps = false; 

    protected $fillable = [
        'content',
        'user_id',
        'is_public',
        'group_id',
    ];

    public function user_id() {
        return $this->belongsTo('App\Models\User');
      }

      public static function publicSpaces() {
        return Space::select('space.*')
                    ->join('users', 'users.id', '=', 'space.user_id')
                    ->where('users.is_public', false)
                    ->where('space.is_public', false)
                    ->orderBy('date', 'desc');
      }

      public function comments()
{
    return $this->hasMany(Comment::class);
}
}


?>