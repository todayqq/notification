<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'administrator',
                'created_at' => '2017-07-26 02:00:39',
                'updated_at' => '2017-07-26 02:00:39',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'slug' => 'admin',
                'created_at' => '2017-08-12 01:36:59',
                'updated_at' => '2017-08-12 01:36:59',
            ),
        ));
        
        
    }
}