<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	//转账
	//开启事务
	$pdo->beginTransaction();
	$res = $pdo->exec("update php_banlance set money=money-100 where name='小明'");
	if ($res <=0) {
		throw new PDOException("扣款失败", 1);
	}

	$res = $pdo->exec("update php_banlance set money=money+100 where name='野琨'");
	if ($res<=0) {
		throw new PDOException("收款失败", 1);
	}

	//成功
	$pdo->commit();
	echo '转账成功<br>';

} catch (PDOException $e) {
	echo $e->getMessage();

	//回滚  就是做逆向操作
	$pdo->rollback();
}