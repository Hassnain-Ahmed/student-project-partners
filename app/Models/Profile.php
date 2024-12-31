<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'university',
        'program',
        'batch',
        'course',
        'user_id'
    ];
}
