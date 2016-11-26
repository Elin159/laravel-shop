<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //退单状态
        Schema::create('return_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('名称');
        });

        //退款方式表
        Schema::create('refund_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('名称');
        });

        //退货原因表
        Schema::create('return_reason', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('名称');
        });

        //退单主表
        Schema::create('order_return', function (Blueprint $table) {
            $table->increments('id');
            $table->string('return_oid')->comment('订单号');
            $table->string('order_info_oid')->comment('原订单号');
            $table->unsignedInteger('order_info_id')->comment('原订单id');
            $table->double('refund_payable', 10)->comment('应退金额');
            $table->double('refund_paid', 10)->comment('已退金额');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('mobile', 13)->comment('手机号码');
            $table->string('consignee', 50)->comment('收货人');
            $table->string('address')->comment('收货地址');
            $table->string('province', 20)->comment('省份');
            $table->string('city', 20)->comment('城市');
            $table->string('country', 20)->comment('县区');
            $table->unsignedInteger('return_status_id')->comment('退单状态id');
            $table->double('freight', 10)->comment('运费');
            $table->double('product_total_price', 10)->comment('商品总金额');
            $table->string('remark_customer')->comment('客户的备注');
            $table->string('remark_system')->comment('客服的备注');
            $table->string('ip', 40)->comment('ip地址');
            $table->string('post_code', 10)->comment('邮编');
            $table->string('telephone', 20)->comment('固定电话');
            $table->string('email', 100)->comment('邮箱');
            $table->string('add_time', 15)->comment('添加地址');
            $table->unsignedInteger('return_reason_id')->comment('退货原因id');
            $table->string('custom_return_reason')->comment('客户自定义退货原因');
            $table->unsignedInteger('refund_type_id')->comment('退货方式id');

            $table->foreign('return_reason_id')
                ->references('id')->on('return_reason');

            $table->foreign('refund_type_id')
                ->references('id')->on('refund_type');

            $table->foreign('order_info_id')
                ->references('id')->on('order_info');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('return_status_id')
                ->references('id')->on('return_status');
        });

        //退单字表
        Schema::create('order_return_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_return_id')->comment('退单主表id');
            $table->string('return_oid')->comment('退单单号');
            $table->string('name', 50)->comment('商品名称');
            $table->tinyInteger('quantity')->comment('数量');
            $table->double('subtotal', 10)->comment('小计');
            $table->double('market_price', 10)->comment('市场价格(原价)');
            $table->double('deal_price', 10)->comment('成交价');

            $table->foreign('order_return_id')
                ->references('id')->on('order_return')
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
        Schema::drop('order_return_detail');
        Schema::drop('order_return');
        Schema::drop('return_status');
        Schema::drop('refund_type');
        Schema::drop('return_reason');
    }
}
