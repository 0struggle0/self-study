<?php
$redis = new Redis();
$redis->connect('127.0.0.1',6379);
$redis->ping(); //测试Redis有没有启动，如果启动会给你返回pong

// $array = array('title'=>'第一篇','author'=>'zzh','message'=>'圣诞节里看风景拉斯科大姐夫离开对方公司了解反过来说大家分工圣诞快乐附近过来上课的风景更凉快圣诞节福利卡时间段阿斯兰的会计法律速度快解放大斯洛伐克骄傲了速度快解放阿里山的会计法拉克觉得');
// $tmp = json_encode($array);
// $redis->set('test','你好');
// $redis->set("tutorial-name", $tmp); 
// $redis->incr('num2');
// $redis->incrby('num2',3);
// $redis->incrbyfloat('num2',2.6);
// $redis->decr('num2');
// $redis->decrby('num2',2);
// $redis->append('bar','hahah');
// var_dump($redis->strlen('test'));
// var_dump($redis->get('bar'));
// $redis->mset(['zxc'=>6,'xcv'=>8]);
// var_dump($redis->mget(['zxc','xcv']));
// $redis->set('test2','bar');
// var_dump($redis->BITCOUNT('test2')); //计算二进制数据中1的个数
// var_dump($redis->getbit('test2',0));
// var_dump($redis->getbit('test2',1));
// var_dump($redis->getbit('test2',2));
// var_dump($redis->getbit('test2',3));
// var_dump($redis->getbit('test2',4));
// var_dump($redis->getbit('test2',5));
// var_dump($redis->getbit('test2',6));
// var_dump($redis->getbit('test2',7));
// var_dump($redis->getbit('test2',8));
// var_dump($redis->getbit('test2',9));
// var_dump($redis->getbit('test2',10));
// var_dump($redis->getbit('test2',11));
// var_dump($redis->getbit('test2',12));
// $redis->setbit('bar',10,1);  //设置键为bar的值，从左到右第十个二进制位为1  b a r=>01100010 01100001 01110010
// $redis->getbit('bar',5);
// $redis->bitop('or','bar','bbr'); //可以进行and,or,not,xor
// $redis->hset('h:car:3','color','red');
// $redis->hset('h:car:3','name','benchi');
// $redis->hset('h:car:3','price','200');
// var_dump($redis->hset('h:car:3','color','blue')); //插入返回1，更新返回0（其实没有插入更新之分，都是直接覆盖，如果没有该键就先创建再赋值，不过根据返回值可以判断是插入还是更新）
// 
// set会直接覆盖任何数据类型；   如果除set外的其他类型对非本身的数据类型进行操作会报错
// 
// var_dump($redis->hget('h:car:3','color'));
