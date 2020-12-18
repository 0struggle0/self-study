<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	//批量增删改可以使用事务
	$pdo->beginTransaction();
	$start = microtime(true);
	for ($i=0; $i <10000 ; $i++) { 
		$pdo->exec("insert into php_banlance(name,money) values('".'tom'.$i."',$i)");
	}
	$pdo->commit();
	$end = microtime(true);
	echo $end - $start;

} catch (PDOException $e) {
	echo $e->getMessage() . '<br/>';
}