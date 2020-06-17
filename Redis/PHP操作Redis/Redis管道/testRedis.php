<?php
/*
 * @Description: 
 * @Date: 2020-06-02 22:59:31
 * @LastEditTime: 2020-06-02 22:59:31
 */ 

$redis = new Redis();
$redis->connect('localhost',6379);

$t1 = microtime(true);

$pipe=$redis->multi(Redis::PIPELINE);
for($i=0; $i<10000 ; $i++){
    // $pipe->set("key::$i",str_pad($i, 4, '0', 0));
    // $pipe->get("key::$i");
    // $pipe->del("key::$i");

    // $redis->hset('test1', "key::$i", str_pad($i, 4, '0', 0));
    // $pipe->hset('test1', "key::$i", str_pad($i, 4, '0', 0));
    $pipe->hDel('test1', "key::$i");
    // $redis->hDel('test1', "key::$i");
}

$replies=$pipe->exec();

$t2 = microtime(true);
echo '耗时'.round($t2-$t1,3).'秒<br>';
echo 'Now memory_get_usage: ' . memory_get_usage() . '<br />';