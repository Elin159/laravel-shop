<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单状态--客户
        Schema::create('order_status_customer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
        });

        //订单状态--客服
        Schema::create('order_status_system', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
        });

        //发票类型
        Schema::create('invoice_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
        });

        //支付类型
        Schema::create('pay_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
        });

        //支付方式
        Schema::create('pay', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pay_type_id')->comment('支付类型id');
            $table->string('name',30)->comment('名称');
            $table->string('is_enable')->comment('是否启用');
            $table->tinyInteger('order_by')->comment('排序');
            $table->foreign('pay_type_id')
                ->references('id')->on('pay_type')
                ->onDelete('cascade');
        });

        //订单来源  淘宝，京东，本站等
        Schema::create('order_source', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->comment('名称');
        });

        //订单主表
        Schema::create('order_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('oid')->comment('订单号');
            $table->string('relate_oid')->comment('关联单号，与物流单号挂钩');
            $table->double('amount_payable', 10)->comment('应付金额');
            $table->double('amount_paid', 10)->comment('已付金额');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('consignee', 100)->comment('收货人');
            $table->string('mobile', 11)->comment('手机号');
            $table->string('address', 100)->comment('收货地址');
            $table->unsignedInteger('delivery_time_id')->comment('配送时间id');
            $table->unsignedInteger('pay_id')->comment('支付方式');
            $table->unsignedInteger('delivery_type_id')->comment('配送方式id');
            $table->string('province', 20)->comment('省份');
            $table->string('city', 20)->comment('城市');
            $table->string('country', 20)->comment('县,区');
            $table->unsignedInteger('order_source_id')->comment('订单来源id');
            $table->tinyInteger('pay_status')->comment('订单支付状态');
            $table->unsignedInteger('order_status_customer_id')->comment('订单状态--客户  id');
            $table->unsignedInteger('order_status_system_id')->comment('订单状态--客服 id');
            $table->tinyInteger('order_type')->comment('订单状态 1:正常 2.退 3.退换');
            $table->unsignedInteger('invoice_type_id')->comment('发票类型id');
            $table->string('invoice_head', 100)->comment('发票抬头');
            $table->double('freight_reduce',10)->comment('运费优惠');
            $table->double('freight_payable', 10)->comment('应付运费');
            $table->double('product_total_price', 10)->comment('商品总金额');
            $table->double('discount', 10)->comment('优惠金额');
            $table->string('remark_customer')->comment('客户备注');
            $table->string('remark_system')->comment('客服备注 客服沟通的临时记录');
            $table->string('ip', 40)->comment('ip地址');
            $table->string('post_code', 10)->comment('邮政编码');
            $table->string('telephone', 20)->comment('固定电话');
            $table->string('email', 50)->comment('邮箱');
            $table->string('add_time', 13)->comment('添加时间');
            $table->string('pay_time', 13)->comment('付款时间');
            $table->string('exchange')->comment('换单单号');
            $table->string('return_oid')->comment('发生退货时记录的单号');
            $table->double('custom_price', 10)->comment('客服自定义金额');
            $table->string('coupon_code')->comment('优惠券号');
            $table->string('coupon_reduce_price')->comment('优惠券优惠金额');
            $table->string('cash_reduce_price')->comment('现金账户优惠金额');

            //建立索引
            $table->foreign('order_status_customer_id')
                ->references('id')->on('order_status_customer');
            $table->foreign('order_status_system_id')
                ->references('id')->on('order_status_system');
            $table->foreign('delivery_time_id')
                ->references('id')->on('delivery_time');
            $table->foreign('delivery_type_id')
                ->references('id')->on('delivery_type');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('pay_id')
                ->references('id')->on('pay');
            $table->foreign('invoice_type_id')
                ->references('id')->on('invoice_type');
            $table->foreign('order_source_id')
                ->references('id')->on('order_source');

            $table->index('oid');
            $table->index('order_type');
            $table->index('pay_status');
        });

        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_info_id')->comment('订单主表id');
            $table->string('oid')->comment('订单号');
            $table->string('name')->comment('商品名字');
            $table->string('avatar')->comment('商品头像');
            $table->tinyInteger('quantity')->comment('数量');
            $table->double('subtotal', 10)->comment('小计');
            $table->double('market_price', 10)->comment('市场价格 (原价)');
            $table->double('deal_price', 10)->comment('成交价');
            $table->double('discount_rate', 10)->comment('折扣比例');
            $table->tinyInteger('is_comment')->comment('是否评论');
            $table->tinyInteger('is_gift')->comment('是否评论');

            $table->foreign('order_info_id')
                ->references('id')->on('order_info')
                ->onDelete('cascade');
        });

        //运费模板
        Schema::create('freight_template', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->comment('名称');
            $table->unsignedInteger('region_id')->comment('省市县id');
            $table->unsignedInteger('delivery_type_id')->comment('配送id');
            $table->unsignedInteger('pay_id')->comment('配送id');
            $table->string('remark')->comment('备注');
            $table->double('initial_weight_freight', 10)->comment('首重运费');
            $table->double('additional_weight_freight', 10)->comment('续重运费');
            $table->tinyInteger('is_cod')->comment('是否支持到付');
            $table->string('min_eta')->comment('最短到货时间');
            $table->string('max_eta')->comment('最长到货时间');
            $table->tinyInteger('is_enable')->comment('是否启用');

            $table->foreign('region_id')
                ->references('id')->on('region')
                ->onDelete('cascade');
            $table->foreign('delivery_type_id')
                ->references('id')->on('delivery_type')
                ->onDelete('cascade');
            $table->foreign('pay_id')
                ->references('id')->on('pay')
                ->onDelete('cascade');

        });

        //订单配送信息
        Schema::create('order_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_info_id')->comment('订单主表id');
            $table->string('oid')->comment('订单单号');
            $table->string('express_company')->comment('快递公司');
            $table->string('tracking_number')->comment('快递单号');
            $table->string('send_time', 13)->comment('发货时间');
            $table->string('initial_weight')->comment('首重');
            $table->string('additional_weight')->comment('续重');
            $table->string('remark')->comment('备注');

            $table->foreign('order_info_id')
                ->references('id')->on('order_info')
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
        Schema::drop('order_delivery');
        Schema::drop('freight_template');
        Schema::drop('order_detail');
        Schema::drop('order_info');
        Schema::drop('pay');
        Schema::drop('order_status_customer');
        Schema::drop('order_status_system');
        Schema::drop('invoice_type');
        Schema::drop('pay_type');
        Schema::drop('order_source');
    }
}
