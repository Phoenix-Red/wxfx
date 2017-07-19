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
        /**
         * 订单表
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('oid');//主键
            $table->string('ordsn');//订单号
            $table->integer('uid');//用户uid
            $table->string('openid',32);//用户openid
            $table->string('xm' , 15);//收货者姓名
            $table->string('address' , 30);//地址
            $table->string('tel' , 11);//电话
            $table->float('money' , 7,2);//订单金额
            $table->tinyinteger('ispay');//是否支付
            $table->integer('ordtime')->unsigned();//下单时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
