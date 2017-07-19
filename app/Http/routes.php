<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*商城首页*/
Route::get('/','GoodsController@index');
/*商品添加*/
Route::get('insert','GoodsController@insert');
/*商品详情页*/
Route::get('goods/{gid}','GoodsController@goods');
/*加入购物车*/
Route::get('buy/{gid}','GoodsController@buy');
/*查看购物车*/
Route::get('cart','GoodsController@cart');
/*清空购物车*/
Route::get('cart_clear','GoodsController@cart_clear');
/*确认订单*/
Route::any('done','GoodsController@done');//订单入库
Route::post('pay','GoodsController@pay');//确认支付



Route::any('wxfx','WxfxController@Index');

//微博授权登录
Route::any('weibo','WeiBoController@Index');


//微信授权登录
Route::any('center','UserController@center');
Route::any('login','UserController@login');
Route::any('logout','UserController@logout');

