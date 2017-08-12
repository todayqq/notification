<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OauthsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(AdminMenuTableSeeder::class);
        $this->call(AdminRoleMenuTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(AdminRoleUsersTableSeeder::class);
    }
}
