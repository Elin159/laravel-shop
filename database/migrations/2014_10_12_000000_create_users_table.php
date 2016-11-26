<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户详细资料
        Schema::create('users', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name');
//            $table->string('email')->unique();
//            $table->string('password');
//            $table->rememberToken();
//            $table->timestamps();
            $table->increments('id');
            $table->string('nickname',30)->comment('账号昵称');
            $table->string('avatar')->comment('用户头像');
            $table->timestamps();

        });

        //用户认证
        Schema::create('user_auths', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->tinyInteger('identity')->comment('登陆类型 1手机,2邮箱,3用户名,11gitHub');
            $table->string('identifier')->comment('标识 136..');
            $table->string('credential')->comment('密码');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->unique('identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_auths');
        Schema::drop('users');

    }
}
