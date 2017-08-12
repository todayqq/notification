<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '首页',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => '2017-08-12 01:40:47',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 6,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => '2017-08-12 01:32:07',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 0,
                'order' => 3,
                'title' => '用户',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => '2017-08-12 01:41:07',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Permission',
                'icon' => 'fa-user',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 11,
                'title' => 'Helpers',
                'icon' => 'fa-gears',
                'uri' => '',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 8,
                'order' => 12,
                'title' => 'Scaffold',
                'icon' => 'fa-keyboard-o',
                'uri' => 'helpers/scaffold',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 13,
                'title' => 'Database terminal',
                'icon' => 'fa-database',
                'uri' => 'helpers/terminal/database',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 14,
                'title' => 'Laravel artisan',
                'icon' => 'fa-terminal',
                'uri' => 'helpers/terminal/artisan',
                'created_at' => NULL,
                'updated_at' => '2017-08-06 11:28:55',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 2,
                'title' => '项目',
                'icon' => 'fa-product-hunt',
                'uri' => 'projects',
                'created_at' => '2017-07-26 02:19:22',
                'updated_at' => '2017-08-12 01:40:58',
            ),
            12 => 
            array (
                'id' => 14,
                'parent_id' => 0,
                'order' => 4,
                'title' => '授权',
                'icon' => 'fa-key',
                'uri' => 'oauths',
                'created_at' => '2017-08-02 09:23:36',
                'updated_at' => '2017-08-12 01:41:16',
            ),
            13 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'order' => 5,
                'title' => '通知 Log',
                'icon' => 'fa-commenting-o',
                'uri' => 'notificationlogs',
                'created_at' => '2017-08-06 11:28:49',
                'updated_at' => '2017-08-12 01:41:56',
            ),
        ));
        
        
    }
}