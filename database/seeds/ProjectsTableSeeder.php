<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('projects')->delete();
        
        \DB::table('projects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'name' => 'Test',
                'description' => 'This is a test',
                'webhook' => '82ec8f736d9b0481724ec39fb5021710',
                'email_status' => 0,
                'send_email_users' => NULL,
                'tb_pid' => NULL,
                'coding_msg_status' => 0,
                'sentry_msg_status' => 0,
                'tb_roomid' => NULL,
                'tb_tasklistid' => NULL,
                'tb_stageid' => NULL,
                'tb_executorid' => NULL,
                'tb_personid' => NULL,
                'created_at' => '2011-09-16 00:53:20',
                'updated_at' => '2011-09-16 00:53:20',
            ),
        ));
        
        
    }
}