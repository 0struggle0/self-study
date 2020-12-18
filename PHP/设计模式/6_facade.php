<?php

//典型门面模式是傻瓜相机

//闪光灯
class Light
{
	function on()
	{
		echo "打开闪光灯<br/>";
	}
	function off()
	{
		echo "关闭闪光灯<br/>";
	}
}

//调焦距
class Focus
{
   public function tiaojiao()
   {
   	   echo "调整焦距<br/>";
   }
}



class Camera 
{
	function  start()
	{
		echo "打开相机<br>";
	}
	function close()
	{
		echo "关闭相机<br/>";
	}
}

//门面
class Facade
{
	protected $light;
	protected $camera;
	protected $focus;
	function __construct($light,$camera,$focus)
	{
		$this->light = $light;
		$this->focus = $focus;
		$this->camera = $camera;
	}

	function start()
	{
		$this->light->on();
		$this->focus->tiaojiao();
		$this->camera->start();
	}
	function stop()
	{
		$this->light->off();
		$this->camera->close();
	}
}

//客户端代码
$light = new Light();
$focus = new Focus();
$camera = new Camera();

$facade = new Facade($light,$camera,$focus);
$facade->start();
$facade->stop();