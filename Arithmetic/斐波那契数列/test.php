<?php
/*
 * @Description: 斐波那契数列实现
 * 当n = 0时，返回0；
 * 当n = 1时，返回1；
 * 当n > 1时，返回F(n - 1) + F(n - 2)
 * @Date: 2019-12-26 11:52:13
 * @LastEditTime : 2019-12-26 13:21:50
 */

// 一 循环实现
function test($n)
{
    if ($n < 1) {
        return 0;
    } else if ($n == 1 || $n == 2) {
        return 1;
    }

    $array = [0, 1];
    for ($i = 2; $i < $n; $i++) { 
        $array[$i] = $array[$i - 1] + $array[$i - 2];
    }
    
    unset($array[0]);
    return $array;
}

// 二 递归实现 效率较低
// function test($n)
// {
//     for ($i = 0; $i < $n; $i++) { 
//         $array[] = fbi($i);
//     }
    
//     unset($array[0]);
//     return $array;
// }

// function fbi($n)
// {
//     if ($n < 2) {
//         return $n == 0 ? 0 : 1; 
//     }

//     return fbi($n - 1) + fbi($n - 2);
// }

var_dump(test(40));