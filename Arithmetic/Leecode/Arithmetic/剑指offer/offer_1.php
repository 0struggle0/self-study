<?php

/*
 * @Description: 
 * @Date: 2020-08-26 17:13:17
 * @LastEditTime: 2020-08-26 18:12:12
 */

#***************************************************************************************************************************
// 01. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 02. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 03. 数组中重复的数字

// 在一个长度为 n 的数组 nums 里的所有数字都在 0～n-1 的范围内。数组中某些数字是重复的，但不知道有几个数字重复了，也不知道每个数字重复了几次。请找出数组中任意一个重复的数字。
// 找出数组中重复的数字。

// 示例 1：
// 输入：[2, 3, 1, 0, 2, 5, 3]
// 输出：2 或 3 

// 限制：
// 2 <= n <= 100000
#***************************************************************************************************************************

// 方法一：利用内置方法统计数组中数字出现的次数，然后遍历寻找重复的数字输出
// function findRepeatNumber($nums) 
// {
//     if (empty($nums) || !is_array($nums)) {
//         return false;
//     }

//     $memberCount = array_count_values($nums);

//     // 找出单个重复的数字
//     foreach ($memberCount as $number => $numberCount) {
//         if ($numberCount > 1) {
//             return $number;
//         }
//     }

//     // // 找出所有重复的数字
//     // $result = [];
//     // foreach ($memberCount as $number => $numberCount) {
//     //     if ($numberCount > 1) {
//     //         $result[] = $number;
//     //     }
//     // }
//     // return $result;
// }

// 方法二：利用hash，做一个键值映射，把数字作为键，出现的次数作为值，先遍历参数数组生成hash数组，然后遍历hash数组找重复的数字
// function findRepeatNumber($nums) 
// {
//     if (empty($nums) || !is_array($nums)) {
//         return false;
//     }

//     // 找出单个重复的数字
//     $temp = [];
//     foreach ($nums as $number) {
//         if (isset($temp[$number])) {
//             return $number;
//         }
//         $temp[$number] = 1;
//     }

//     // 没有重复的数字时返回false
//     return false;

//     // 找出所有重复的数字
//     // $numberCounts = [];
//     // foreach ($nums as $number) {
//     //     if (isset($temp[$number])) {
//     //         $temp[$number]++;
//     //     } else {
//     //         $temp[$number] = 1;
//     //     }
//     // }

//     // $result = [];
//     // foreach ($numberCounts as $newNumber => $numberCount) {
//     //     if ($numberCount > 1) {
//     //         $result[] = $newNumber;
//     //     }
//     // }

//     // return $result;
// }

// 方法三：《剑指offer》书中的思路
// 先对参数数组升序排序，如果没有重复数字，那么排序后数字i应该在下标为i的位置。
// 所以从头遍历参数数组，遇到下标为i的数字如果不是i的话，（假设为m), 那么我们就拿与下标m的数字交换。
// 在交换过程中，如果发现某一个下标已经与它对应的值相等了，但是还有数字想与之交换，那么终止返回该数字
function findRepeatNumber($nums) 
{
    if (empty($nums) || !is_array($nums)) {
        return false;
    }

    sort($nums);
    foreach ($nums as $index => $number) {
        if ($index == $number) {
            continue;
        } 

        if ($nums[$number] != $number) {
            $temp = $nums[$number];
            $nums[$number] = $number;
            $nums[$index] = $temp;
        } else {
            return $number;
        }
    }
}

// var_dump(findRepeatNumber([2, 3, 1, 0, 2, 5, 3]));