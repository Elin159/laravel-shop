<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraeteShoppingCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //购物车主表
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('total_quantity')->comment('总件数');
            $table->string('add_time', 13)->comment('添加时间');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        //购物车子表
        Schema::create('cart_info', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shopping_cart_id')->comment('购物车主表id');
            $table->unsignedInteger('product_id')->comment('商品id');
            $table->tinyInteger('quantity')->comment('件数');

            $table->foreign('shopping_cart_id')
                ->references('id')->on('shopping_cart')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cart_info');
        Schema::drop('shopping_cart');
    }
}
