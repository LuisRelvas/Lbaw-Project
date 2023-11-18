<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the cards for a user.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
    public function visibleSpaces() {
        
        $own = Space::select('*')->where('space.user_id', '=', $this->id);

        $noGroups = Space::select('space.*')
            ->fromRaw('space,follows')
            ->where('follows.user_id2', '=', $this->id)
            ->whereColumn('follows.user_id1', '=', 'space.user_id')
            ->where('space.group_id', null);


        $fromGroups = Space::select('space.*')
            ->fromRaw('space,member')
            ->where('member.user_id', $this->id)
            ->whereColumn('space.group_id','member.group_id');
            

        return $own->union($noGroups)->union($fromGroups)
            ->orderBy('date','desc');
    }

    public function isFollowing(User $user) {
        return Follow::where('user_id1', $this->id)->where('user_id2', $user->id)->exists();
    }
}
