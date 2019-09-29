<?php

class MyCurl
{
	public static function get($url)
	{
		//1 初始化curl
		$ch = curl_init();

		//2 设置参数
		curl_setopt($ch, CURLOPT_URL, $url);//url
		curl_setopt($ch, CURLOPT_HEADER, false);//不要请求头
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//不直接显示，返回数据
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不启用ssl验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不启用主机验证
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);//超时设置，20秒

		//3发起请求
		$content = curl_exec($ch);

		//4 关闭请求
		curl_close($ch);

		return $content;
	}

	public static function post($url,$data)
	{
		//1 初始化curl
		$ch = curl_init();

		//2 设置参数
		curl_setopt($ch, CURLOPT_URL, $url);//url
		curl_setopt($ch, CURLOPT_HEADER, false);//不要请求头
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//不直接显示，返回数据
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不启用ssl验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不启用主机验证
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);//超时设置，20秒
		curl_setopt($ch, CURLOPT_POST, true);//post请求
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//请求参数

		//3发起请求
		$content = curl_exec($ch);

		//4 关闭请求
		curl_close($ch);

		return $content;
	}
}


