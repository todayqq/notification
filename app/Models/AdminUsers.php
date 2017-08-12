<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUsers extends Authenticatable
{
	use Notifiable;

    protected $hidden = ['password', 'remember_token'];

    protected $fillable = ['username', 'password', 'name', 'avatar', 'email', 'activation_token'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }
}
