<?php
//前台妹子
// class Girl
// {
// 	protected $kun;
// 	public function __construct()
// 	{
// 		$this->kun = new Employee();
// 	}
// 	public function notify()
// 	{
// 		echo "老凯子来了<br/>";
// 		$this->kun->diaokaizi();
// 	}
// }

// //员工
// class Employee
// {
// 	public function diaokaizi()
// 	{
// 		echo "停止玩游戏，假装在学习<br>";
// 	}
// }


//抽象的观察者
interface AbstractObserver
{
	function update();
}

//员工
class Employee implements AbstractObserver
{
	protected $name;
	public function __construct($name)
	{
		$this->name = $name;
	}
	public function update()
	{
		echo $this->name . " 停止玩游戏，假装在学习<br>";
	}
}



//抽象的被观察者
interface AbstractSubject
{
	function attach(AbstractObserver $observer);//添加一个观察者
	function detach(AbstractObserver $observer);//删除一个观察者
	function notify();//通知观察者
}

class Girl implements AbstractSubject
{
	protected $observerList = [];
	function attach( AbstractObserver $observer)
	{
       $this->observerList[] = $observer;
	}
	
	function detach(AbstractObserver $observer)
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
			$value->update();
		}
	}
}

// //客户端代码
// $kun = new Employee('李贱坤');
// $dajuan  = new Employee('王美丽');
// $erjuan = new Employee('二娟');

// //被观察者
// $girl = new Girl();
// $girl->attach($kun);
// $girl->attach($erjuan);
// $girl->attach($dajuan);

// echo "老凯子来哦<br>";
// $girl->notify();