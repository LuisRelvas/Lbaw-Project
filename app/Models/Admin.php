<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Admin extends Model 
{
    use HasFactory;

    protected $table = 'admin';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}