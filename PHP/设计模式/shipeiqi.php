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

class Adapter 
{
	protected $ts;
	function __construct($socket)
	{
		$this->ts = $socket;
	}

	public function threeSocket()
	{
		echo "三口插座<br>";
		$this->ts->twoSocket();
	}
}

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

$ts = new ChaZuo();
$ts->twoSocket();

$adapter = new Adapter($ts);
$adapter->threeSocket();
