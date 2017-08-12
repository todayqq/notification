<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOauths extends Model
{
    protected $fillable = ['user_id', 'oauth_id', 'token'];
}
