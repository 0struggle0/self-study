<?php

//系统的观察者的接口
//员工
class Employee implements SplObserver
{
	protected $name;
	public function __construct($name)
	{
		$this->name = $name;
	}
	public function update ( SplSubject $subject)
	{
		var_dump($subject);
		echo $this->name . " 停止玩游戏，假装在学习<br>";
	}
}


class Girl implements SplSubject 
{
	protected $observerList = [];
	function attach( SplObserver $observer)
	{
       $this->observerList[] = $observer;
	}
	
	function detach(SplObserver $observer)
	{
		//在数组查找指定的值，有的话返回下标，没有返回false
		$key = array_search($observer, $this->observerList);
		if ($key !== false) {
			unset($this->observerList[$key]);
		}
	}

	public function notify()
	{
		foreach ($this->observerList as $key => $value) {
			$value->update($this);
		}
	}
}

// //客户端代码
$kun = new Employee('李贱坤');
$dajuan  = new Employee('王美丽');
$erjuan = new Employee('二娟');


//被观察者
$girl = new Girl();
$girl->attach($kun);
$girl->attach($erjuan);
$girl->attach($dajuan);

echo "老凯子来哦<br>";
$girl->notify();