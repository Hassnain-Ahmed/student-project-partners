<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPartnerRequest extends Model
{
    protected $fillable = ['requester_id', 'receiver_id', 'course_id', 'status'];
}
