<?php
include "curl.php";
//定义token，在微信开发中心设置的token
define('TOKEN','hao');
define('APPID','wx3158da1fbb5f77d2');
define('APPSECRET','51a567d721c357e79429b008254cf534');
// 517b33e38046885fb9c08ac68d2e4329  普通订阅号的APPSECRET
define('TOKENFILE','test_token.txt');
$wx = new WxChat();
//第一次验证echostr不为空
if (!empty($_GET['echostr'])) {
	$wx->valid();
}
$wx->getToken();
$wx->responseMsg();
$wx->addMenu();
class WxChat
{

	public function getToken($appid=APPID,$appsecret=APPSECRET)
	{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
		//1首先判断是否有test_token.txt文件
		if (file_exists(TOKENFILE)) {
			//判断token是否过期
			$content = file_get_contents(TOKENFILE);
			$obj = json_decode($content);
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
	public function addMenu()
	{
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getToken();
		//一级菜单
		$menu[button][] = [ 
           "name"=>"位置及其他",
           "sub_button"=>[
           		[
                  "type"=>"click",
                  'name'=>'获取地理位置',
                  'key'=>'address'
               ],
               [
                  "type"=>"click",
                  'name'=>'招聘信息',
                  'key'=>'zhaopin'
               ]
           ]
        ];
        $menu[button][]=[
        	   "name"=>"日常生活",
               "sub_button"=>[
	               [
	                  "type"=>"click",
	                  'name'=>'天气预报',
	                  'key'=>'tianqi'
	               ],
	               [
	                  "type"=>"click",
	                  'name'=>'万年历',
	                  'key'=>'rili'
	               ],
	               [
	                  "type"=>"click",
	                  'name'=>'新闻头条',
	                  'key'=>'newtitle'
	               ]
	        ]
        ];
        $menu[button][] = [
            "name"=>"娱乐和物流",
               "sub_button"=>[
	               [
	                  "type"=>"click",
	                  'name'=>'笑话大全',
	                  'key'=>'xiaohua'
	               ],
	               [
	                  "type"=>"click",
	                  'name'=>'星座运势',
	                  'key'=>'xingzuoyunshi'
	               ],
	               [
	                  "type"=>"click",
	                  'name'=>'物流查询',
	                  'key'=>'wuliu'
	               ],
	        ]
        ];
        $str = json_encode($menu,JSON_UNESCAPED_UNICODE);//转json，第二参数不对中文转义
        echo MyCurl::post($url,$str);
	}
	public function xioahua()
	{
		$time = time();
		$url = "http://japi.juhe.cn/joke/content/list.from?key=cb99d221aee540ba1d14b807bfb9dd89&pagesize=10&sort=desc&time={$time}";
		$str = MyCurl::get($url);
		$obj = json_decode($str);
		$arr = $obj->result;
		$con = $arr->data;
		$link = '';
		$num = mt_rand(0,9);
		return $con[$num]->content;
	}
	public function tianqiyubao($place)
	{
		$url = "http://v.juhe.cn/weather/index?cityname={$place}&dtype=&format=&key=9c8d6056619d3c5e9200c73a808495ef";
		$str = MyCurl::get($url);
		$obj = json_decode($str);
		$info = $obj->result->today;
		$info = '日期：' . $obj->result->today->date_y . '     '  . $obj->result->today->week . "\n"  . '查询城市：' . $obj->result->today->city . "\n"  . '温度：' . $obj->result->today->temperature . '' . '天气' . $obj->result->today->weather . '    ' . '出行：'  . $obj->result->today->travel_index;
		return $info;
	}
	public function newtitle()
	{
		$host = "http://toutiao-ali.juheapi.com";
	    $path = "/toutiao/index";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "type=type";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $info = curl_exec($curl);
	    $info = strpbrk($info, '{');;
	    $info = json_decode($info);
	    $info2 = $info->result->data;
	    $result = $info2[0]->author_name . " " . $info2[0]->category . "\n" . $info2[0]->url . "\n" .$info2[0]->title . "\n" . $info2[1]->author_name . " " . $info2[1]->category . "\n" . $info2[1]->url . "\n" . $info2[1]->title ."\n" . $info2[2]->author_name . " " . $info2[2]->category . "\n" . $info2[2]->url . "\n" . $info2[2]->title . "\n";
	    return $result;
	    curl_close($curl);
	}
	public function rili()
	{
		$date = date('Y-m-d',time());
		$host = "http://jisuwnl.market.alicloudapi.com";
	    $path = "/calendar/query";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "date={$date}";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
	    $result = json_decode($content);
	    $result = $result->result->huangli->nongli . "\n" . '宜：' . $result->result->huangli->yi[0] . ' ' . $result->result->huangli->yi[1] . ' ' . $result->result->huangli->yi[2] . ' ' . $result->result->huangli->yi[3] . ' ' . $result->result->huangli->yi[4] . ' ' . $result->result->huangli->yi[5] . "\n" . '忌：'  . $result->result->huangli->ji[0] . ' ' . $result->result->huangli->ji[1] . ' ' . $result->result->huangli->ji[2] . ' ' . $result->result->huangli->ji[3];
	   return $result;
	}
	function xingzuoyunshi($id)
	{
		$date = date('Y-m-d',time());
		$host = "http://jisuastro.market.alicloudapi.com";
	    $path = "/astro/fortune";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "astroid={$id}&date={$date}";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
	    $result = json_decode($content);
	    $result = $result->result;
	    $yunshi = $result->astroname . ':' . "\n" . '今天运势：' . $result->today->presummary . "\n"
	    . '明天运势：' . $result->tomorrow->presummary;
	    return $yunshi;
	}
	public function wuliu($num)
	{
		$host = "http://wuliu.market.alicloudapi.com";
	    $path = "/kdi";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "no={$num}";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
	    $result = json_decode($content);
	    $result = $result->result;
	    $info = '快订单号：' . $result->number . "\n" . '快递公司：' . $result->type . "\n";
	    foreach ($result->list as $key => $value) {
	    	$info = $info . $value->time . "\n" . $value->status . "\n";
	    }
	    return $info;
	}
	public function zhaopin($compName)
	{
		$host = "http://qianzhan4.market.alicloudapi.com";
	    $path = "/EmployAccurate";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "comName={$compName}&page=1";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
	    $result = json_decode($content);

	    $result = $result->result;

	    $info = '公司名称：' .  $result->companyName . "\n" . '公司类型：' . $result->companyNature . "\n" . 
	    '公司规模：' . $result->companySize . "\n" . '公司业务：' . $result->companyIndustry . "\n" . '公司地址：' . $result->addr . "\n" . '招聘职位：' . $result->companyStations[0]->jobTitle  . "\n" . '职位要求：' . $result->companyStations[0]->yearsReq  . "\n" . '学历要求：' . $result->companyStations[0]->eduReq . "\n" . '工作所在地：' . $result->companyStations[0]->city . "\n" . '想要了解更多招聘信息请到该公司官网进行了解,公司官网:' .  $result->webSite . "\n";
	    return $info;
	}
	public function huifu($str)
	{
		$host = "http://jisuznwd.market.alicloudapi.com";
	    $path = "/iqa/query";
	    $method = "GET";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "question={$str}";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
		$result = json_decode($content);
		$result = $result->result;
		$info = $result->content;
		return $info;
	}
	public function address()
	{
		$postStr = file_get_contents("jingwei.txt");
	    $obj2 = simplexml_load_string($postStr,'SimpleXMLElement', LIBXML_NOCDATA);
	    $jingweidu = $obj2->Latitude . '%2C' . $obj2->Longitude;
	 	$host = "http://getlocat.market.alicloudapi.com";
	    $path = "/api/getLocationinfor";
	    $method = "POST";
	    $appcode = "2ff34b844628477092ca5cd56cf489d0";
	    $headers = array();
	    array_push($headers, "Authorization:APPCODE " . $appcode);
	    $querys = "latlng={$jingweidu}&type=2";
	    $bodys = "";
	    $url = $host . $path . "?" . $querys;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curl, CURLOPT_FAILONERROR, false);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_HEADER, true);
	    if (1 == strpos("$".$host, "https://"))
	    {
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    }
	    $content = curl_exec($curl);
	    $content = strpbrk($content, '{');
		$result = json_decode($content);
		$result = $result->result->Address;
		return $result;
	}
	public function responseMsg()
	{
		if (phpversion()>=7) {
			$postStr = file_get_contents("php://input");
		} else {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		}
		file_put_contents('userQingQiu.txt', $postStr);
		$obj = simplexml_load_string($postStr,'SimpleXMLElement', LIBXML_NOCDATA);
		switch ($obj->MsgType) {
			case 'text':
				$result = $this->responseText($obj);
		 		break;
			case 'event':
				file_put_contents('openid.txt', $obj->FromUserName);
		 	    $result = $this->handleEvent($obj);
		 	    break;
			default:
				break;
		}
		echo $result;

	}
	
	public function responseText($obj)
	{
		$str = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><MsgId>6483994041359866925</MsgId></xml>";
		$con = $obj->Content;
		$con = '' . $con;
		$xingzuo = ['白羊座'=>1,'金牛座'=>2,'双子座'=>3,'巨蟹座'=>4,'狮子座'=>5,'处女座'=>6,'天秤座'=>7,'天蝎座'=>8,'射手座'=>9,'摩羯座'=>10,'水瓶座'=>11,'双鱼座'=>12,];
		if (mb_stripos($con,'座') !== false) {
			if (array_key_exists($con,$xingzuo)) {
				$content = $this->xingzuoyunshi($xingzuo[$con]);
			} else {
				$content = '输入不正确,请重新输入';
			}
		} elseif (mb_stripos($con,'快递') !== false) {
			$arr = explode('+', $con);
			// if (!empty($this->wuliu($arr[1]))) {
				$content = $this->wuliu($arr[1]);
			// } else {
			// 	$content = '输入不正确,请重新输入';
			// }	
		} elseif (mb_stripos($con,'天气') !== false) {
			$arr = explode('+', $con);
			// if (!empty($this->wuliu($arr[1]))) {
				$content = $this->tianqiyubao($arr[1]);
			// } else {
			// 	$content = '输入不正确,请重新输入';
			// }	
		} elseif (mb_stripos($con,'招聘信息+') !== false) {
			$arr = explode('+', $con);
			// $tmp = '' . $arr[1];
			// if (!empty($this->zhaopin($tmp))) {
				$content = $this->zhaopin($arr[1]);
				file_put_contents('zhaopin.txt', $content);
			// } else {
			// 	$content = '输入不正确,请重新输入';
			// }	
		} else {
			$content = $this->huifu($con);
		}
		$kaifazhe = $obj->FromUserName;
		$yonghu = $obj->ToUserName;
		$time = time();
		$str = sprintf($str,$kaifazhe,$yonghu,$time,$content);
		return $str;
	}
	public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = $this->userInfo();
                break;
            case 'CLICK':
            	switch ($object->EventKey) {
            		case 'xiaohua':
            			$contentStr = $this->xioahua();
            			break;
            		case 'tianqi':
            			$contentStr = '请输入你想要查询的城市：[如：天气+北京]';
            			break;
            		case 'newtitle':
            			$contentStr = $this->newtitle();
            			break;
            		case 'rili':
            			$contentStr = $this->rili();
            			break;
            		case 'xingzuoyunshi':
            			$contentStr = '请输入你想要查询的星座：[如：白羊座]';
            			break;
            		case 'wuliu':
            			$contentStr = '请输入你想要查询的快递单号：[如：快递+454244690951]';
            			break;
            		case 'zhaopin':
            			$contentStr = '请输入你想要查询的公司全称：[如：招聘信息+深圳市腾讯计算机系统有限公司]';
            			break;
            		case 'address':
            			$contentStr = $this->address();
            			break;
            		default:
            			$contentStr = "Unknow Event: ".$object->Event;
            			break;
            	}
            	break;
            case "LOCATION":
                $jingwei = file_get_contents('userQingQiu.txt');
                file_put_contents('jingwei.txt', $jingwei);
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    public function userInfo()
	{
		$openid = file_get_contents('openid.txt');
		$token = $this->getToken();
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$token}&openid={$openid}&lang=zh_CN ";
		$str = MyCurl::get($url);
		file_put_contents('userinfo.txt', $str);
		$obj = json_decode($str);
		return '终于等到你：' . $obj->nickname;
	}
 	private function transmitText($object, $content, $flag=0){
   		$textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
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
        // defined()检查某个名称的常量是否存在
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