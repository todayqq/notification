<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLogs extends Model
{
    protected $fillable = ['pid', 'name', 'info', 'content'];

 //    public function project()
	// {
 //    	return $this->belongsTo('App\Models\Projects');
	// }
}
