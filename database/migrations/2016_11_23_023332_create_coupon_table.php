<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //优惠券类型
        Schema::create('coupon_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('名称');
        });

        //优惠券主表
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('优惠券名称');
            $table->unsignedInteger('coupon_type_id')->comment('优惠券类型id');
            $table->double('face_value', 10)->comment('优惠券面值');
            $table->string('description')->comment('优惠券描述');
            $table->string('delay_day', 13)->comment('多少天后执行');
            $table->tinyInteger('is_reuse')->comment('是否重复执行');
            $table->double('enough_money', 10)->comment('满多少钱可以用');
            $table->tinyInteger('discount')->default('1')->comment('打多少折扣 默认1为不打折');
            $table->string('include_group')->comment('包含分类组');
            $table->string('exclude_group')->comment('排除分类组');
            $table->string('begin_time',13)->comment('开始时间');
            $table->unsignedInteger('admin_id')->comment('后台管理员id');
            $table->tinyInteger('is_enable')->comment('是否启用');
            $table->timestamps();

            $table->foreign('coupon_type_id')
                ->references('id')->on('coupon_type')
                ->onDelete('cascade');
        });

        //优惠券明细
        Schema::create('coupon_code', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coupon_id')->comment('券主表id');
            $table->string('code', 50)->comment('编号');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->tinyInteger('is_user')->comment('是否使用过');
            $table->string('add_time', 13)->comment('添加时间');
            $table->tinyInteger('is_enable')->comment('是否启用');

            $table->foreign('coupon_id')
                ->references('id')->on('coupon')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('coupon_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->comment('优惠券编码');
            $table->string('tx_behavior')->comment('行为结果-订单号');
            $table->string('add_time')->comment('添加时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupon_history');
        Schema::drop('coupon_code');
        Schema::drop('coupon');
        Schema::drop('coupon_type');
    }
}
