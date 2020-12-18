<?php
//需要适配的的类
class Server
{
	function getInfo()
	{
		//服务器提供数组
		return [1,2,3,4,5,6];
	}
}


//适配器类
interface IAdapter
{
	function array2String();
}

class Adapter implements IAdapter
{
	protected $server;//包含一个需要适配的对象
	public function __construct($server)
	{
		$this->server = $server;
	}

	//实现接口
	function array2String()
	{
		$data = $this->server->getInfo();
		return join('',$data);
	}
}


//客户端类需要字符串 
$server = new Server();

$adapter = new Adapter($server);

echo $adapter ->array2String();
