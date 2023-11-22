<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Group extends Model 
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'groups'; 

    protected $fillable = [
        'name',
        'description'
    ];
}