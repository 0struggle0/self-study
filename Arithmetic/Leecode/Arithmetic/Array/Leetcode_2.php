<?php

#***************************************************************************************************************************
# 1. 最长公共前缀
// 编写一个函数来查找字符串数组中的最长公共前缀。
// 如果不存在公共前缀，返回空字符串 ""。

// 示例 1:
// 输入: ["flower","flow","flight"]
// 输出: "fl"

// 示例 2:
// 输入: ["dog","racecar","car"]
// 输出: ""

// 解释: 输入不存在公共前缀。

// 说明:
// 所有输入只包含小写字母 a-z 。
#***************************************************************************************************************************

// 方法一
function longestCommonPrefix($strs)
{
    $res = '';
    $count = count($strs);
    $minStr = findMinLenStr($strs, $count); //或者可以直接默认数组中第一个值就是最小的
    $count = count($strs);
    $minlen = strlen($minStr);

    // 用最小值每个字符去剩下的数组中每个值循环判断
    for ($j = 0; $j < $minlen; $j++) { // 循环最下字符串
        for ($k = 0; $k < $count; $k++) { // 循环数组
            if ($minStr[$j] != $strs[$k][$j]) {  // 判断值是否相等
                return $res;
            }
        }

        $res .= $minStr[$j]; // 追加到结果集中
    }

    return $res;
}

function findMinLenStr(&$strs, $length)
{
    $minx = 0;
    $minStr = $strs[$minx]; // 默认第一个值为最小
    $minlen = strlen($minStr); // 最小值长度
    // 找出最小长度的字符串键
    for ($i = 1; $i < $length; $i++) {
        if (strlen($strs[$i]) < $minlen) {
            $minx = $i;
        }
    }

    $minStr = $strs[$minx];
    unset($strs[$minx]); // 删除数组中最小的那个值
    sort($strs);
    return $minStr;
}

// 方法二
// function longestCommonPrefix($strs)
// {
//     if (empty($strs) || !is_array($strs)) {
//         return "";
//     }

//     $count = count($strs);
//     if ($count == 1) {
//         return $strs[0];
//     }

//     // 找出长度最短的字符串
//     $key = 0;
//     $min_str = $strs[0];
//     $min = strlen($min_str);
//     foreach ($strs as $k => $str) {
//         $currStrLen = strlen($str);
//         if ($min >= $currStrLen) {
//             $key = $k;
//             $min = $currStrLen;
//         }
//     }

//     $min_str = $strs[$key];
//     unset($strs[$key]);

//     $left = 1;
//     $right = strlen($min_str);
//     while ($left <= $right) {
//         $mid = floor(($right - $left) / 2) + $left;
//         if (findpre($strs, substr($min_str, 0, $mid))) {
//             $left = $mid + 1;
//         } else {
//             $right = $mid - 1;
//         }
//     }
//     return substr($min_str, 0, min($left, $right));
// }

// function findpre($strs, $pre)
// {
//     foreach ($strs as $str) {
//         if (substr($str, 0, strlen($pre)) != $pre) {
//             return false;
//         }
//     }
//     return true;
// }

// var_dump(longestCommonPrefix(["flower", "flow", "flight"]));


#***************************************************************************************************************************
# 2. 
#***************************************************************************************************************************
