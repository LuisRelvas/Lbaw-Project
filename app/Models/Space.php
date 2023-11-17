<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TagController;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserNotification; 

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
}


?>