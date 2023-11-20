<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Space extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

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
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}


?>