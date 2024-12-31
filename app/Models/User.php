<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'university_name',
        'program',
        'batch_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sentRequests()
    {
        return $this->hasMany(ProjectPartnerRequest::class, 'requester_id');
    }

    public function receivedRequests()
    {
        return $this->hasMany(ProjectPartnerRequest::class, 'receiver_id');
    }
}
