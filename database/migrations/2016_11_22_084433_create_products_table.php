<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //商品分类表
        Schema::create('product_type', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名称');
            $table->integer('parent_id')->default('0')->comment('父级id');
            $table->string('path')->default('0,')->comment('路径');
        });

        //商品表
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name')->comment('商品名称');
            $table->unsignedInteger('product_type_id')->comment('分类id');
            $table->double('price', 10)->comment('商品价格');
            $table->integer('stock')->comment('库存');
            $table->string('describe')->comment('商品描述');
            $table->tinyInteger('is_up')->comment('是否上下架');
            $table->integer('sales')->default('0')->comment('销售量');
            $table->integer('see_num')->default('0')->comment('浏览量');
            $table->string('avatar')->comment('商品头像地址');
            $table->timestamps();

            $table->foreign('product_type_id')
                ->references('id')->on('product_type')
                ->onDelete('cascade');

            $table->index('is_up');
            $table->index('stock');
        });

        //商品规格表
        Schema::create('parameter', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('商品id');
            $table->string('attr_name')->comment('商品属性名称');
            $table->string('attr_value')->comment('商品属性值');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

        });


        //商品详情内容表
        Schema::create('product_content', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('商品id');
            $table->text('content')->comment('商品详情内容');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

        });

        //商品推荐
        Schema::create('product_nominates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });

        //用户收藏商品表
        Schema::create('user_products', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('user_id');

//            $table->primary(['product_id', 'user_id']);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::drop('user_products');
        Schema::drop('parameter');
        Schema::drop('product_content');
        Schema::drop('product_nominates');
        Schema::drop('products');
        Schema::drop('product_type');
    }
}
