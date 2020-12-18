<?php

interface Moving
{
	function run();//交通工具运行的方式
}

//ofo
class Ofo implements Moving
{
	function run()
	{
		echo '骑Ofo出行<br/>';
	}
}

//皮皮虾
class PPX  implements Moving
{
	function run()
	{
		echo '骑皮皮虾出行<br/>';
	}
}

class Person
{
	protected $name;

	public function __construct($name)
	{
		$this->name =$name;
	}

	function travel($tool)
	{
		$tool->run();
		echo '去三亚<br>';
	}
}


//测试代码
$ofo = new Ofo();

$yuxuan = new Person('任宇旋');
$yuxuan->travel($ofo);