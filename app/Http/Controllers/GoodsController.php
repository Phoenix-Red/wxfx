<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Cart;
use Session;
use App\Order;
use App\User;
use App\Item;
use App\Fee;

class GoodsController extends Controller
{
	/**
	 * 商品添加
	 * @return [type] [description]
	 */
	public function insert(){
		$data = [
			['goods_name'=>'月季','goods_price'=>'23.8','goods_img'=>'goods_1.jpg'],
			['goods_name'=>'玫瑰','goods_price'=>'45.6','goods_img'=>'goods_2.jpg'],
			['goods_name'=>'桃花','goods_price'=>'30.8','goods_img'=>'goods_3.jpg'],
			['goods_name'=>'妖姬','goods_price'=>'55.6','goods_img'=>'goods_4.jpg']
		];
		DB::table('goods')->insert($data);
	}

	/**
	 * 首页展示
	 * @return [type] [description]
	 */
    public function index(){
    	$goods = DB::table('goods')->get();
    	return view('index',['goods'=>$goods]);
    }

    /**
     * 商品详情页
     * @param  [type] $gid [description]
     * @return [type]      [description]
     */
    public function goods($gid){
    	$goods_info = DB::table('goods')->where('gid',$gid)->first();
    	return view('goods',['goods_info'=>$goods_info]);
    }

    /**
     * 添加购物车
     * @param  [type] $gid [description]
     * @return [type]      [description]
     */
    public function buy($gid){
		$goods_info = DB::table('goods')->where('gid',$gid)->first();

		//cart类中add方法添加购物车
		Cart::add(array(
		    'id' => $goods_info->gid,
		    'name' => $goods_info->goods_name,
		    'price' => $goods_info->goods_price,
		    'quantity' => 1,
		    'attributes' => array()
		));
		//var_dump(cart::getContent());exit();
		return redirect('cart');
    }

    /**
     * 查看购物车
     * @return [type] [description]
     */
    public function cart(){
    	//获取购物车的商品
    	$goods = Cart::getContent();
    	//计算价格
    	$total = Cart::getTotal();
    	return view('cart',['goods'=>$goods,'total'=>$total]);
    }

    /**
     * 清除购物车
     * @return [type] [description]
     */
    public function cart_clear(){
    	Cart::clear();
    	return redirect('cart');
    }

    /**
     * 订单入库
     * @return function [description]
     */
    public function done(Request $req){
    	$user = session()->get('wechat_user');
    	// var_dump($user);exit();
    	$openid = $user->getId();
    	// var_dump($openid);exit();

    	//获取用户信息
    	$user_info = DB::table('users')->where('openid',$openid)->first();
    	$order = new Order();
    	$total = Cart::getTotal();//总金额

    	//写入数据库order表
    	$order->ordsn = date('YmdHis').mt_rand(10000,99999);
		$order->uid = $user_info->uid;
		$order->openid = $user_info->openid;
		$order->xm = $req->xm;
		$order->address = $req->address;
		$order->tel = $req->mobile;
		$order->money = $total;
		$order->ispay = 0;
		$order->ordtime = time();
		$order->save();

		//获取假如购物车内容
		$goods = Cart::getContent();

		//写入商品表信息
		foreach($goods as $g){
			$item = new Item();
			$item->oid = $order->oid;
			$item->gid = $g->id;
			$item->goods_name = $g->name;
			$item->price = $g->price;
			$item->amount = $g->quantity;
			$item->save();
		}

		//清除购物车
		$this->cart_clear();

		return view('zhifu',['oid'=>$order->oid]);

    }

    /**
     * 确认支付
     * @param  Request $req [description]
     * @return [type]       [description]
     */
    public function pay(Request $req){
    	$oid = $req->oid;
		DB::table('orders')->where('oid',$oid)->update(['ispay'=>1]);
		return $this->fee($req);
		//return '购买成功';
    }

    /**
     * 产生佣金
     * @return [type] [description]
     */
    public function fee($req){
    	//修改订单状态
		$order = Order::where('oid' , $req->oid)->first();
		$user = User::where('openid' , $order->openid)->first();
		
		//为上线生成收益
		//p1 0.4 p2 0.2 p3 0.1
		$shouyi = [$user->p1,$user->p2,$user->p3];//$v
		$yj = [0.4,0.2,0.1];//$yj[$k]
		foreach ($shouyi as $k => $v) {
			if($v>=0){
				$fee = new Fee();
				$fee->oid = $order->oid; //订单号
				$fee->byid = $user->uid; //买家ID
				$fee->uid = $v; //卖家id(受益者id)
				$fee->money = $order->money * $yj[$k]; //收益金额
				$fee->save();
			}
		}
    }

}
