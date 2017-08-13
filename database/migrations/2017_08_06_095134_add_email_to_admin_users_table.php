<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailToAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('password')->nullable()->change();
            if (!Schema::hasColumn('admin_users', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('admin_users', 'activation_token')) {
                $table->string('activation_token')->nullable();
            }
            if (!Schema::hasColumn('admin_users', 'pid')) {
                $table->integer('pid')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            if (Schema::hasColumn('admin_users', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('admin_users', 'activation_token')) {
                $table->dropColumn('activation_token');
            }
            if (Schema::hasColumn('admin_users', 'pid')) {
                $table->dropColumn('pid');
            }
        });
    }
}
