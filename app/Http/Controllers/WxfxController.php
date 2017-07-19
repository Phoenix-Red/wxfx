<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use EasyWeChat\Foundation\Application;//EasyWeChat主项目入口文件类
use EasyWeChat\Message;
use DB;
use App\User;

class WxfxController extends Controller{
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
		   
		];
		$this->app = new Application($options);//实例化对象
	}

	/**
	 * 首页功能列表
	 */
    public function Index(){
		$this->app->server->setMessageHandler(function($message){//回复消息
			switch ($message->MsgType) {
		        case 'event':
		            return $this->shijian($message);
		            break;
		        case 'text':
		        	if($message->Content == '1'){
		        		return "请选择一张您要发送的图片";
		        	}else if($message->Content == '2'){
		        		// return "请稍后,正在计算您的坐标.....";
		        		return $this->map($message);
		        	}else if($message->Content == '3'){
		        		//return "请输入您要播放的歌曲信息";
		        		return $this->music($message);
		        	}else{
		        		return "正在为您处理,请稍后....";
		        	}

		            break;
		        case 'image':
		            return $this->facePlus($message);
		            break;
		        case 'voice':
		            return '收到语音消息';
		            break;
		        case 'video':
		            return '收到视频消息';
		            break;
		        case 'location':
		            return '收到坐标消息';
		            break;
		        case 'link':
		            return '收到链接消息';
		            break;
		        // ... 其它消息
		        default:
		            return '收到其它消息';
		            break;
    		}
		});

		//执行服务端业务
		$response = $this->app->server->serve();
		return $response;// 将响应输出
	}

	/**
	 * 关注与取关事件
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function shijian($message){
		$user = new User();
		//获取用户id
		$openid = $message->FromUserName;
		//获取关注用户的详细信息 userservice实例
		$userservice = $this->app->user;
		$userinfo = $userservice->get($openid);
		//获取用户昵称
		$name = $userinfo->nickname;
		//查询是否是重新关注的用户
		$olduser = $user->where('openid',$openid)->first();
		$this->qrcode($openid);
		if($message->Event == 'subscribe'){
			if($olduser){
				//修改数据库status的值
				$olduser->status = 1;
				$olduser->subtime = time();
				$olduser->save();
			}else{
				//写入数据库
				$user->name = $name;
				$user->openid = $openid;
				$user->subtime = time();
				//设置带参数的二维码
				if($message->EventKey){
					$p1_openid = str_replace('qrscene','',$message->EventKey);
					//查询修改
					$p = DB::table('user')->where('openid',$p1_openid)->first();
					//写入三级关系数据
					$user->p1 = $p->uid;
					$user->p2 = $p->p1;
					$user->p3 = $p->p2;
				}
				$user->save();
				//得带二维码实例
				$this->qrcode($openid);
			}
			$text = "请选择您想要实现的功能序号:\n"."1.人脸识别功能\n"."2.获取定位信息\n"."3.播放音乐功能";
			//返回xml格式数据
			return '现在时间'.date('Y-m-d H:i:s',time())."\n欢迎".$name."访问我的公众号\n".$text;
		}else if($message->Event == 'unsubscribe') {//取消关注
			if($olduser){
				//修改数据库中的status值
				$olduser->status = 0;
				$olduser->subtime = time();
				$olduser->save();	
			}
		}
	}

	/**
	 * 二维码自动生成
	 * @param  [type] $openid [description]
	 * @return [type]         [description]
	 */
	public function qrcode($openid){
		$qrcode = $this->app->qrcode;
		
		//创建永久二维码
		$result = $qrcode->forever($openid);// 或者 $qrcode->forever("foo");
		$ticket = $result->ticket; // 或者 $result['ticket']

		//获取二维码内容
		$url = $qrcode->url($ticket);

		// 得到二进制图片内容
		$content = file_get_contents($url); 
		$dir = $this->mkd().'/'.$openid.'.jpg';
		file_put_contents(public_path().'/qrcode'.$dir, $content); // 写入文件
	}

	/**
	 * 自定义创建目录
	 * @return [type] [description]
	 */
	public function mkd(){
		$today = date('/Ymd');
		if(!is_dir(public_path().'/qrcode'.$today)){
			$dir = mkdir(public_path().'/qrcode'.$today, 0777 ,true);
		}
		return $today;
	}

	/**
	 * 人脸识别接口 输入序号:1
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function facePlus($message){
		$data = [
			'api_key' => 'WhjcaDfZMXZddY5WJm717AFXVsmtuJqz',
			'api_secret' => 'M2MR3Nk7HTSIKQOiVhWUuriRLulforEs',
			'image_url' => $message->PicUrl,
			'return_landmark' => 1,//是否检测并返回人脸五官和轮廓的83个关键点
			'return_attributes' => 'gender,age'
		];

		$url = 'https://api-cn.faceplusplus.com/facepp/v3/detect';

		$da = $this->curl($url,$data);//文件上传

		//转化数组
		$arr = json_decode($da,true);
		//如果成功则返回数组,那么我们统计数组中的faces参数
		$num = count($arr['faces']);
		if($num == 0){
			//随便的图片回复
			$contentStr = '你的图片真好看!!!';
		}else{
			//有人物则返回
			$contentStr = '这张图片里有'.$num.'人:'."\n";
			foreach ($arr['faces'] as $k => $v) {
				$contentStr .= '其中第'.($k+1).'人,性别:'.$v['attributes']['gender']['value'].',年龄估计有'.$v['attributes']['age']['value'].'岁'."\n";
			}
			echo $contentStr;
		} 

		/*回复文本消息*/
		$text = new Message\Text();
		$text->content = $contentStr;
		return $text->content;
	}

	/**
	 * curl文件上传函数
	 * @return [type] [description]
	 */
	public function curl($url,$data){
		//1,初始化
		$curl = curl_init();
		//设置参数
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl, CURLOPT_HEADER,0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		//发送请求信息
		$da = curl_exec($curl);
		//关闭请求资源
		curl_close($curl);
		return $da;
	}

	/**
	 * 播放音乐功能实现  输入序号:3
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function music($message){
		//实例化临时素材
		$temporary = $this->app->material_temporary;
		
		//上传music到素材库
		$path = 'http://lxbwechat.tunnel.2bdata.com/music/1.mp3';
		$result = $temporary->uploadVoice($path);
		$mediaId = $result->media_id;
		
		//实例化voice类
		$voice = new Message\Voice();
		$voice->media_id = $mediaId;
		
		//获取素材输出
		$content = $temporary->getStream($mediaId);
		return $content;

	}

	/**
	 * 百度地图api接口 输入序号:2
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public function map($message){

	}
}
