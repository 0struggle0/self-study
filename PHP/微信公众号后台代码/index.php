<?php

include "curl.php";

//定义token，在微信开发中心设置的token
define('TOKEN','hello');
define('APPID','wx5458e033171fbcc9');
define('APPSECRET','dc57cddf032c7f0336fca3ab4388a4e4');
define('TOKENFILE','token.txt');
$wx = new WxChat();

//第一次验证echostr不为空
if (!empty($_GET['echostr'])) {
	$wx->valid();
}
 // $wx->getToken();
$wx->responseMsg();
echo $wx->uploadImage('02.jpg');
// $wx->addMenu();


class WxChat
{

	//创建菜单
	public function addMenu()
	{
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getToken();
		//一级菜单
		$menu[button][] = [ 
          "name"=>"今日歌曲",
          "sub_button"=>[
               [
                  "type"=>"click",
                  'name'=>'欧美金曲',
                  'key'=>'song_1'
               ],
               [
                	"type"=>"click",
                   "name"=>"赞一下我们",
                  "key"=>"V1001_GOOD"
               ]
          ]
        ];
        $menu[button][]=[
        	 "type"=>"view",
               "name"=>"搜索",
               "url"=>"http://www.baidu.com/"
        ];
        $menu[button][] = [
            "type"=> "pic_photo_or_album", 
             "name"=> "拍照或者相册发图", 
             "key"=> "rselfmenu_1_1", 
        ];

        $str = json_encode($menu,JSON_UNESCAPED_UNICODE);//转json，第二参数不对中文转义
        echo MyCurl::post($url,$str);
	}
	public function uploadImage($imageName)
	{
		$token = $this->getToken();
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$token}&type=image";
		$image = new CURLFile($imageName);
		$data = ['media'=>$image];
		$str = MyCurl::post($url,$data);
		return $str;
	}
	
	public function getToken($appid =APPID,$appsecret=APPSECRET)
	{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";

		//1首先判断是否有token.txt文件
		if (file_exists(TOKENFILE)) {
			$content = file_get_contents(TOKENFILE);
			$obj = json_decode($content);

			//判断token是否过期
			if (filemtime(TOKENFILE) + $obj->expires_in > time()) {
				return $obj->access_token;
			}
			//删除文件
			unlink(TOKENFILE);
		}
		
		$str = MyCurl::get($url);
		file_put_contents(TOKENFILE, $str);
		$obj = json_decode($str);
		return $obj->access_token;
	}

	//消息的被动回复
	public function responseMsg()
	{
		//接收来自微信服务器的post消息
		if (phpversion()>=7) {
			$postStr = file_get_contents("php://input");
		} else {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
		//服务器调试，请使用写文件的方式进行
		file_put_contents('13.txt', $postStr);

		 $obj = simplexml_load_string($postStr);

		 switch ($obj->MsgType) {
		 	case 'text':
		 		$this->responseText($obj);
		 	    break;
		 	case 'event':

		 	    $this->menuClick($obj);
		 	    break;
		 	default:
		 		# code...
		 		break;
		 }
		 // file_put_contents('2.txt', "\n".$obj->ToUserName."\n".$obj->FromUserName,FILE_APPEND);
		

	}

	//菜单事件处理
	protected function menuClick($obj)
	{
		$str = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[7d3UDerVLP0xmtjO3HxLMz6S19rZZCp2sorWFCmTuiC9s4uDaMkSrogZ9_lVEaAa]]></MediaId></Image></xml>";
		 $to = $obj->FromUserName;//发给
		 $from = $obj->ToUserName;//自己
		 $time = time();
		$str = sprintf($str,$to,$from,$time);
		echo $str;
	}

    function responseImage($obj)
    {
    	$str = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[%s]]></MediaId></Image></xml>";
    	 $to = $obj->FromUserName;//发给
		 $from = $obj->ToUserName;//自己
		 $time = time();
		 $media_id = "-b6Bp9SlB0n5YmV4Xl4nqO93NJbM9SL15F-_ejzuRhhPXeObNnm1Uzx19Pz4lUTd";
		 $str = sprintf($str,$to,$from,$time,$media_id);
		 echo $str;
    }

	protected function responseText($obj)
	{
		$str = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><MsgId>6483994041359866925</MsgId></xml>";
		 $con = $obj->Content;
		 if (mb_stripos($con, '美女') !== false) {
		 	 $this->responseImage($obj);
		 	 die;
		 } else {
		 	 $content = '腿腿说要发红包';
		 }
		 $to = $obj->FromUserName;//发给
		 $from = $obj->ToUserName;//自己
		 $time = time();

		 $str = sprintf($str,$to,$from,$time,$content);
		 // file_put_contents('3.txt', "\n".$str,FILE_APPEND);
		 echo $str;//返回给微信服务器

	}

	public  function valid()
	{
		if ($this->checkSignature()) {
			//将微信服务器传过来的信息原样返回
			echo $_GET['echostr'];
		}
	}

	/**
	 * [checkSignature 验证信息是否完整]
	 * @return [type] [description]
	 */
	protected function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        //获取微信传的参数
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		//将字符串放进数组
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);//排序
		$tmpStr = implode( $tmpArr );//合成字符串
		$tmpStr = sha1( $tmpStr );//签名
		
		//验证签名
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}


