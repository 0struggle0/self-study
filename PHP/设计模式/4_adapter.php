<?php

interface TwoSocketInterface
{
	function twoSocket();
}

class ChaZuo implements TwoSocketInterface
{
	function twoSocket()
	{
		echo "两口插座，可以充电<br/>";
	}
}


//3to2转接口
//适配器
class Adapter 
{
	protected $ts;//包含一个两口的插座
	function __construct($socket)
	{
		$this->ts = $socket;
	}

	//2to3转接方法
	public function threeSocket()
	{
		echo "三口插座<br>";
		$this->ts->twoSocket();
	}
}

//插头
//
interface ThreeChaTou
{
	function threeChaTou();
}

class Computer implements ThreeChaTou
{
	function threeChaTou()
	{
		echo "三项插头<br>";
	}
}

//测试代码
$ts = new ChaZuo();
$ts->twoSocket();

//适配器
$adapter = new Adapter($ts);
$adapter->threeSocket();
