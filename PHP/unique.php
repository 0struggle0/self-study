<?php
// 1）使用array_unique方法进行去重(对数组元素进行去重，我们一般会使用array_unique方法，使用这个方法可以把数组中的元素去重)

// $arr = array(1,1,2,3,3,3,4,4,5,6,6,7,8,8,9,9,9);
// $arr = array_unique($arr);
// $arr = array_values($arr);
// print_r($arr);

// // 输出:
// // Array
// // (
// //   [0] => 1
// //   [1] => 2
// //   [2] => 3
// //   [3] => 4
// //   [4] => 5
// //   [5] => 6
// //   [6] => 7
// //   [7] => 8
// //   [8] => 9
// // )

// // 去重后，键值会不按顺序，可以使用array_values把键值重新排序。

// // array_unique()的去重效率：
// $arr = array();
// // 创建100000个随机元素的数组
// for($i=0; $i<100000; $i++){
//   $arr[] = mt_rand(1,99);
// }
 
// // 记录开始时间
// $starttime = getMicrotime();
 
// // 去重
// $arr = array_unique($arr);
 
// // 记录结束时间
// $endtime = getMicrotime();
 
// $arr = array_values($arr);
 
// echo 'unique count:'.count($arr).'<br>';
// echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
// echo 'use memory:'.getUseMemory();
 
// /**
//  * 获取使用内存
//  * @return float
//  */
// function getUseMemory(){
//   $use_memory = round(memory_get_usage(true)/1024,2).'kb';
//   return $use_memory;
// }
 
// /**
//  * 获取microtime
//  * @return float
//  */
// function getMicrotime(){
//   list($usec, $sec) = explode(' ', microtime());
//   return (float)$usec + (float)$sec;
// }

// unique count:99 
// run time:653.39303016663ms 
// use memory:5120kb
    
// 2）php有一个键值互换的方法array_flip，我们可以使用这个方法去重，因为键值互换，原来重复的值会变为相同的键，然后再进行一次键值互换，把键和值换回来则可以完成去重。

$arr = array();
 
// 创建100000个随机元素的数组
for($i=0; $i<100000; $i++){
  $arr[] = mt_rand(1,99);
}
 
// 记录开始时间
$starttime = getMicrotime();
 
// 使用键值互换去重
$arr = array_flip($arr);
$arr = array_flip($arr);
 
// 记录结束时间
$endtime = getMicrotime();
 
$arr = array_values($arr);
 
echo 'unique count:'.count($arr).'<br>';
echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
echo 'use memory:'.getUseMemory();
 
/**
 * 获取使用内存
 * @return float
 */
function getUseMemory(){
  $use_memory = round(memory_get_usage(true)/1024,2).'kb';
  return $use_memory;
}
 
/**
 * 获取microtime
 * @return float
 */
function getMicrotime(){
  list($usec, $sec) = explode(' ', microtime());
  return (float)$usec + (float)$sec;
}

// unique count:99 
// run time:12.840032577515ms 
// use memory:768kb

// 使用array_flip方法去重，运行时间需要约18ms，内存占用约2m
// 因此使用array_flip方法去重比使用array_unique方法运行时间减少98%，内存占用减少4/5;