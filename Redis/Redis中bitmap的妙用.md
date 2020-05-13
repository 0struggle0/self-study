# Redis中bitmap的妙用

在Redis中我们经常用到set,get等命令，细心的你有没有发现，还有几个相似的命令叫setbit,getbit，它们是用来干嘛的？

### BitMap是什么

就是通过一个bit位来表示某个元素对应的值或者状态,其中的key就是对应元素本身。我们知道8个bit可以组成一个Byte，所以bitmap本身会极大的节省储存空间。

### Redis中的BitMap

Redis从2.2.0版本开始新增了`setbit`,`getbit`,`bitcount`等几个bitmap相关命令。虽然是新命令，但是并没有新增新的数据类型，因为`setbit`等命令只不过是在`set`上的扩展。

### setbit命令介绍

指令 `SETBIT key offset value`
复杂度 `O(1)`
设置或者清空key的value(字符串)在offset处的bit值(只能只0或者1)。

### 空间占用、以及第一次分配空间需要的时间

在一台2010MacBook Pro上，offset为2^32-1（分配512MB）需要～300ms，offset为2^30-1(分配128MB)需要～80ms，offset为2^28-1（分配32MB）需要～30ms，offset为2^26-1（分配8MB）需要8ms。<来自官方文档>
大概的空间占用计算公式是：`($offset/8/1024/1024)MB`

### 使用场景一：用户签到

很多网站都提供了签到功能(这里不考虑数据落地事宜)，并且需要展示最近一个月的签到情况，如果使用bitmap我们怎么做？一言不合亮代码！

```
<?php
$redis = new Redis();
$redis->connect('127.0.0.1');


//用户uid
$uid = 1;

//记录有uid的key
$cacheKey = sprintf("sign_%d", $uid);

//开始有签到功能的日期
$startDate = '2017-01-01';

//今天的日期
$todayDate = '2017-01-21';

//计算offset
$startTime = strtotime($startDate);
$todayTime = strtotime($todayDate);
$offset = floor(($todayTime - $startTime) / 86400);

echo "今天是第{$offset}天" . PHP_EOL;

//签到
//一年一个用户会占用多少空间呢？大约365/8=45.625个字节，好小，有木有被惊呆？
$redis->setBit($cacheKey, $offset, 1);

//查询签到情况
$bitStatus = $redis->getBit($cacheKey, $offset);
echo 1 == $bitStatus ? '今天已经签到啦' : '还没有签到呢';
echo PHP_EOL;

//计算总签到次数
echo $redis->bitCount($cacheKey) . PHP_EOL;

/**
* 计算某段时间内的签到次数
* 很不幸啊,bitCount虽然提供了start和end参数，但是这个说的是字符串的位置，而不是对应"位"的位置
* 幸运的是我们可以通过get命令将value取出来，自己解析。并且这个value不会太大，上面计算过一年一个用户只需要45个字节
* 给我们的网站定一个小目标，运行30年，那么一共需要1.31KB(就问你屌不屌？)
*/
//这是个错误的计算方式
echo $redis->bitCount($cacheKey, 0, 20) . PHP_EOL;
```

### 使用场景二：统计活跃用户

使用时间作为cacheKey，然后用户ID为offset，如果当日活跃过就设置为1
那么我该如果计算某几天/月/年的活跃用户呢(暂且约定，统计时间内只有有一天在线就称为活跃)，有请下一个redis的命令
命令 `BITOP operation destkey key [key ...]`
说明：对一个或多个保存二进制位的字符串 key 进行位元操作，并将结果保存到 destkey 上。
说明：BITOP 命令支持 AND 、 OR 、 NOT 、 XOR 这四种操作中的任意一种参数

```
//日期对应的活跃用户
 $data = array( 
'2017-01-10' => array(1,2,3,4,5,6,7,8,9,10), 
'2017-01-11' => array(1,2,3,4,5,6,7,8), 
'2017-01-12' => array(1,2,3,4,5,6), 
'2017-01-13' => array(1,2,3,4), 
'2017-01-14' => array(1,2) 
); 

 //批量设置活跃状态 
foreach($data as $date=>$uids) { 
$cacheKey = sprintf("stat_%s", $date); 
foreach($uids as $uid) { 
$redis->setBit($cacheKey, $uid, 1); 
}
 }

  $redis->bitOp('AND', 'stat', 'stat_2017-01-10', 'stat_2017-01-11', 'stat_2017-01-12') . PHP_EOL; 
//总活跃用户：6 
echo "总活跃用户：" . $redis->bitCount('stat') . PHP_EOL;  

$redis->bitOp('AND', 'stat1', 'stat_2017-01-10', 'stat_2017-01-11', 'stat_2017-01-14') . PHP_EOL; 
//总活跃用户：2 
echo "总活跃用户：" . $redis->bitCount('stat1') . PHP_EOL;

  $redis->bitOp('AND', 'stat2', 'stat_2017-01-10', 'stat_2017-01-11') . PHP_EOL; 
//总活跃用户：8 
echo "总活跃用户：" . $redis->bitCount('stat2') . PHP_EOL;
```

假设当前站点有5000W用户，那么一天的数据大约为50000000/8/1024/1024=6MB

### 使用场景三：用户在线状态

前段时间开发一个项目，对方给我提供了一个查询当前用户是否在线的接口。不了解对方是怎么做的，自己考虑了一下，使用bitmap是一个节约空间效率又高的一种方法，只需要一个key，然后用户ID为offset，如果在线就设置为1，不在线就设置为0，和上面的场景一样，5000W用户只需要6MB的空间。

```
//批量设置在线状态
$uids = range(1, 500000); 
foreach($uids as $uid) { 
$redis->setBit('online', $uid, $uid % 2);
 } 
//一个一个获取状态
 $uids = range(1, 500000); 
$startTime = microtime(true); 
foreach($uids as $uid) { 
echo $redis->getBit('online', $uid) . PHP_EOL;
 }
 $endTime = microtime(true); 
//在我的电脑上，获取50W个用户的状态需要25秒 
echo "total:" . ($endTime - $startTime) . "s";

   /** 
* 对于批量的获取，上面是一种效率低的办法，实际可以通过get获取到value，然后自己计算 
* 具体计算方法改天再写吧，之前写的代码找不见了。。。 
*/
```

其实BitMap可以运用的场景很多很多(当然也会受到一些限制)，思维可以继续扩散~欢迎小伙伴给我留言探讨~

续篇：[Redis中BitMap是如何储存的，以及PHP如何处理](https://segmentfault.com/a/1190000008205145)