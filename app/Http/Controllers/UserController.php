<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;//EasyWeChat主项目入口文件类
use Session;

class UserController extends Controller
{
	public $app = null;
	public function __construct(){
		$options = [
		    'debug'  => true,
		    'app_id' => 'wxc0913e74ebecd67b',
		    'secret' => '1210e7bfbdeef868bb758a2d37c1b643',
		    'token'  => 'lxbWeChat',
		    // 'aes_key' => null, // 可选
		    'log' => [
		        'level' => 'debug',
		        'file'  => '../storage/logs/easywechat.log', // XXX: 绝对路径！！！！
		    ],
			//用户回调页面
			'oauth' => [
				'scopes' => ['snsapi_userinfo'],
				'callback' => '/login',//回调url
			],
		];
		$this->app = new Application($options);//实例化对象
	}

    /**
     * 网页授权
     */ 
    public function center(Request $req){
    	//没有用户登录跳转登录界面
    	if(!$req->session()->has('wechat_user')){
    		$oauth = $this->app->oauth;
    		return $oauth->redirect();//默认跳转到回调url
    	}
    	var_dump($req->session()->get('wechat_user'));
    	return "欢迎登录";
    }

    /**
     * 登录
     */
    public function login(){
    	$oauth = $this->app->oauth;
    	$user = $oauth->user();//微信提供的用户信息

    	Session::put('wechat_user',$user);//写入session中
    	 
    	return redirect('center');//登录成功返回回调界面
    }

    /**
     * 退出
     */
    public function logout(){
    	Session::forget('wechat_user');
    	return redirect('center');
    }

}
