<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('webhook');
            
            $table->boolean('email_status')->default(false);
            $table->string('send_email_users')->nullable();
            $table->string('tb_pid')->nullable();
            $table->boolean('coding_msg_status')->default(false);
            $table->boolean('sentry_msg_status')->default(false);
            $table->string('tb_roomid')->nullable();
            $table->string('tb_tasklistid')->nullable();
            $table->string('tb_stageid')->nullable();
            $table->string("tb_executorid")->nullable();
            $table->string('tb_personid')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
