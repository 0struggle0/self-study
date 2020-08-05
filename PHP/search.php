<?php

// 1)in_array查找元素效率 (当比较的数组haystack较大时，in_array效率会很低)

// 例子：使用in_array对有10万个元素的数组进行1000次比较

// $arr = array();
 
// 创建10万个元素的数组
// for($i=0; $i<100000; $i++){
//   $arr[] = $i;
// }
 
// // 记录开始时间
// $starttime = getMicrotime();
 
// // 随机创建1000个数字使用in_array比较
// for($j=0; $j<1000; $j++){
//   $str = mt_rand(1,99999);
//   in_array($str, $arr);
// }
 
// // 记录结束时间
// $endtime = getMicrotime();
 
// echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
 
// /**
//  * 获取microtime
//  * @return float
//  */
// function getMicrotime(){
//   list($usec, $sec) = explode(' ', microtime());
//   return (float)$usec + (float)$sec;
// }

// run time:2003.6449432373ms
// 使用in_array判断元素是否存在，在10万个元素的数组中比较1000次，运行时间需要约2秒
    
    
// 2)提高查找元素效率方法(我们可以先使用array_flip进行键值互换，然后使用isset方法来判断元素是否存在，这样可以提高效率)
    
// 例子：使用array_flip先进行键值互换，再使用isset方法判断，在10万个元素的数组中比较1000次
$arr = array();
 
// 创建10万个元素的数组
for($i=0; $i<100000; $i++){
  $arr[] = $i;
}
 
// 键值互换
$arr = array_flip($arr);
 
// 记录开始时间
$starttime = getMicrotime();
 
// 随机创建1000个数字使用isset比较
for($j=0; $j<1000; $j++){
  $str = mt_rand(1,99999);
  isset($arr[$str]);
}
 
// 记录结束时间
$endtime = getMicrotime();
 
echo 'run time:'.(float)(($endtime-$starttime)*1000).'ms<br>';
 
/**
 * 获取microtime
 * @return float
 */
function getMicrotime(){
  list($usec, $sec) = explode(' ', microtime());
  return (float)$usec + (float)$sec;
}

// run time:1.2781620025635ms
// 使用array_flip与isset判断元素是否存在，在10万个元素的数组中比较1000次，运行时间需要约1.2毫秒
// 因此，对于大数组进行比较，使用array_flip与isset方法会比in_array效率高很多。