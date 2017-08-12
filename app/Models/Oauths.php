<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oauths extends Model
{
    protected $fillable = ['name', 'description', 'auth_url'];
}
