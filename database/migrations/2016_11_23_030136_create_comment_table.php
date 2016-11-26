<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //评论表主表
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_detail_id')->comment('订单详情id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('title', 30)->comment('标题');
            $table->text('content')->comment('评论内容');
            $table->unsignedInteger('parent_id')->comment('父级id 回复');
            $table->double('score_avg', 10)->comment('1-5分 有小数');
            $table->string('add_time', 13)->comment('添加时间');
            $table->unsignedInteger('admin_id')->comment('后台账户id');
            $table->string('review_time')->comment('审核时间');
            $table->tinyInteger('review_status')->comment('审核状态');
            $table->string('review_result')->comment('审核结果说明');

            $table->foreign('order_detail_id')
                ->references('id')->on('order_detail')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });

        //评论打分表 记录每个商品类型的打分项目
        Schema::create('comment_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_type_id')->comment('商品类型id');
            $table->string('item_name')->comment('打分项名字  物流/快递/服务');
            $table->tinyInteger('score')->comment('分数值');
            $table->tinyInteger('is_enable')->comment('是否启用');

            $table->foreign('product_type_id')
                ->references('id')->on('product_type')
                ->onDelete('cascade');
        });

        //评论后果统计表
        Schema::create('comment_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('商品id');
            $table->unsignedInteger('comment_item_id')->comment('评论打分表id');
            $table->string('times')->comment('打分次数');
            $table->double('score_avg', 10)->comment('平均分， 1~5有小数概念');
            $table->double('total_score', 10)->comment('总评分');
            $table->double('rate', 10)->comment('百分比');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreign('comment_item_id')
                ->references('id')->on('comment_item');
        });

        //评论打分结果详细表
        Schema::create('comment_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comment_id')->comment('评论id');
            $table->unsignedInteger('comment_item_id')->comment('打分项id');
            $table->double('score', 10)->comment('分数');
            $table->string('add_time', 13)->comment('添加时间');

            $table->foreign('comment_id')
                ->references('id')->on('comment')
                ->onDelete('cascade');

            $table->foreign('comment_item_id')
                ->references('id')->on('comment_item');

        });

        //评论级别
        Schema::create('comment_level', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->comment('好中差评');
            $table->double('start_from', 10)->comment('从多少分');
            $table->double('start_to', 10)->comment('到多少分');
        });

        //评论汇总表
        Schema::create('comment_product', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->comment('商品id');
            $table->unsignedInteger('comment_level_id')->comment('级别id');
            $table->string('times')->comment('评论数');
            $table->double('rate', 10)->comment('好中差评率');

            $table->foreign('product_id')
                ->references('id')->on('products');

            $table->foreign('comment_level_id')
                ->references('id')->on('comment_level');
        });

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comment_product');
        Schema::drop('comment_level');
        Schema::drop('comment_detail');
        Schema::drop('comment_statistics');
        Schema::drop('comment_item');
        Schema::drop('comment');
    }
}
