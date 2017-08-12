<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
	protected $casts = [
        'tb_personid' => 'array',
        'send_email_users' => 'array'
        // 'coding_msg_status' => 'boolean'
    ];
    
    protected $fillable = [
        'name', 'user_id', 'description', 'webhook', "tb_pid", "coding_msg_status", "tb_roomid", "tb_tasklistid", "tb_stageid", "tb_executorid", "tb_personid", 'email_status', 'send_email_users', 'sentry_msg_status'
    ];

    // public function notifcation_logs()
    // {
    //     return $this->hasMany('App\Models\NotificationLogs', 'foreign_key', 'pid');
    // }
}
