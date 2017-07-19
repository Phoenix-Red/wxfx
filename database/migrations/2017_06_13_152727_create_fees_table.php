<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 佣金表
         */
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('fid');//主键
            $table->integer('oid');//订单号
            $table->integer('byid');//买家id
            $table->integer('uid');//卖家id(受益者id)
            $table->float('money',7,2);//受益金额
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fees');
    }
}
