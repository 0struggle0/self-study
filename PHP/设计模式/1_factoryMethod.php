<?php

//所有的产品都有相似的特性
interface Shape{
	function down();
}

//L型
class LBlock implements Shape
{
	function down()
	{
		echo "L型方块在下落<br/>";
	}
}
//_1型
class RightLBlock implements Shape
{
	function down()
	{
		echo "_|型方块在下落<br/>";
	}
}
//O型
class OBlock implements Shape
{
	function down()
	{
		echo "O型方块在下落<br/>";
	}
}

//O型
class ZBlock implements Shape
{
	function down()
	{
		echo "Z型方块在下落<br/>";
	}
}

//抽象工厂
interface AbstractFactory
{
	function createBlock();
}

//L型方块工厂
class LShapeFactory implements AbstractFactory
{
	function createBlock()
	{
		return new LBlock();
	}
}


//O型方块工厂
class OShapeFactory implements AbstractFactory
{
	function createBlock()
	{
		return new OBlock();
	}
}

//Z型方块工厂
class ZShapeFactory implements AbstractFactory
{
	function createBlock()
	{
		return new ZBlock();
	}
}

//改进
// class UnionFactory 
// {
//     public  static function createFactory($className)
//     {
//     	$className .= 'Factory';
//     	$factory = new $className();
//     	return $factory->createBlock();
//     } 
// }

//客户端代码
$lFactory = new LShapeFactory();
$l = $lFactory->createBlock();
$l->down();
// 
// $block =UnionFactory::createFactory('OShape');
// $block->down();