<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 商品表
         */
        Schema::create('items', function (Blueprint $table) {
            $table->increments('iid');//主键
            $table->integer('oid');//订单号
            $table->integer('gid');//商品id
            $table->string('goods_name',40);//商品名称
            $table->float('price' , 7,2);//价格
            $table->smallinteger('amount');//数量
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
