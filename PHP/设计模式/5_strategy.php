<?php

//策略
interface Punish
{
	function beat();
}

//不同的惩罚策略
//吊打
class DiaoDa implements Punish
{
	function beat()
	{
		echo "吊起来打<br/>";
	}
}

//关小黑屋
class XiaoHeiWu implements Punish
{
	function beat()
	{
		echo "关小黑屋<br/>";
	}
}

//阉了
class YanNi implements Punish
{
	function beat()
	{
		echo "阉了<br/>";
	}
}


//警察类
class Police
{
	protected $strategy;

	public function setStrategy($strategy)
	{
		$this->strategy = $strategy;
	}

	//惩罚
	public function punishing()
	{
		$this->strategy->beat();
	}
}

//测试代码
$da = new DiaoDa();
$xhw = new XiaoHeiWu();
$yn = new YanNi();

$police = new Police();
$police->setStrategy($yn);
$police->punishing();

$police->setStrategy($xhw);
$police->punishing();