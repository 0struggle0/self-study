<?php
//命名占位符绑定
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	$stmt = $pdo->prepare("update php_banlance set name= :name,money = :money where id=1");
	$name = '脑残粉';

	/**
	 * 第一个参数：是命名占位符字符串：':name'
	 * 第二个参数：绑定的变量，必须是变量
	 * 第三个参数：是变量的类型
	 */
	$stmt->bindParam(':name',$name);
	$money = 0.6;
	$stmt->bindParam(':money',$money,PDO::PARAM_INT);
	$stmt->execute();

	$name = '6个女朋友';
	$money = 1000;
	//命名占位符的简便写法
	$stmt->execute([
			':name'=>$name,
			':money'=>$money
		]);

} catch (PDOException $e) {
	echo $e->getMessage();
}


