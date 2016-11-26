<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //地区表
        Schema::create('region', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->comment('父级id');
            $table->string('shortname', 100)->nullable()->comment('简称');
            $table->string('name')->nullable()->comment('名称');
            $table->string('merger_name')->nullable()->comment('全称');
            $table->tinyInteger('level')->nullable()->comment('层级 0 1 2 省市区县');
            $table->string('pinyin', 100)->comment('拼音');
            $table->string('code', 100)->comment('长途区号');
            $table->string('zip_code', 100)->comment('邮编');
            $table->string('first', 50)->comment('首字母');
            $table->string('lng', 100)->comment('经度');
            $table->string('lat', 100)->comment('纬度');
        });

        //配送地址表
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('region_province_id')->comment('省id');
            $table->unsignedInteger('region_city_id')->comment('市id');
            $table->unsignedInteger('region_country')->comment('区、县id');
            $table->string('consignee', 30)->comment('收货人');
            $table->string('address', 100)->comment('详细地址');
            $table->string('mobile', 11)->comment('手机号码');
            $table->string('telephone', 20)->comment('固定电话');
            $table->string('email', 50)->comment('邮箱');
            $table->string('post_code')->comment('邮编');
            $table->tinyInteger('is_default')->comment('是否默认');
            $table->timestamps();

            $table->foreign('region_province_id')
                ->references('id')->on('region');
            $table->foreign('region_city_id')
                ->references('id')->on('region');
            $table->foreign('region_country')
                ->references('id')->on('region');
        });

        //配送时间
        Schema::create('delivery_time', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
        });

        //配送方式
        Schema::create('delivery_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('名称');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('delivery_address');
        Schema::drop('region');
        Schema::drop('delivery_time');
        Schema::drop('delivery_type');
    }
}
