<?php

/*
 * @Description: 
 * @Date: 2020-08-26 17:13:17
 * @LastEditTime: 2020-08-27 11:55:49
 */

#***************************************************************************************************************************
// 01. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 02. 
#***************************************************************************************************************************


#***************************************************************************************************************************
// 03. 数组中重复的数字
// 在一个长度为 n 的数组 nums 里的所有数字都在 0～n-1 的范围内。
// 数组中某些数字是重复的，但不知道有几个数字重复了，也不知道每个数字重复了几次。
// 请找出数组中任意一个重复的数字。找出数组中重复的数字。

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

#***************************************************************************************************************************
// 04. 二维数组中的查找
// 在一个 n * m 的二维数组中，每一行都按照从左到右递增的顺序排序，每一列都按照从上到下递增的顺序排序。
// 请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。
// 示例 ：
// 现有矩阵 matrix 如下：
// [
//     [1,   4,  7, 11, 15],
//     [2,   5,  8, 12, 19],
//     [3,   6,  9, 16, 22],
//     [10, 13, 14, 17, 24],
//     [18, 21, 23, 26, 30]
// ]

// 给定 target = 5，返回 true。
// 给定 target = 20，返回 false。

// 限制：
// 0 <= n <= 1000
// 0 <= m <= 1000
#***************************************************************************************************************************

// // 方法一：简单粗暴
// // 复杂度分析:
// // 时间复杂度：O(nm)。二维数组中的每个元素都被遍历，因此时间复杂度为二维数组的大小。
// // 空间复杂度：O(1)。
// function findNumberIn2DArray($matrix, $target) 
// {
//     if (empty($matrix) || !is_array($matrix) || empty($target)) {
//         return false;
//     }

//     foreach ($matrix as $value) {
//         if (in_array($target, $value)) {
//             return true;
//         }
//     }
//     return false;
// }

// 方法二：《剑指offer》书中的思路
// 从右上角开始走
// 如果相等，返回true
// 如果当前位置元素比target大，则col--
// 如果当前位置元素比target小，则row++
// 如果越界了还没找到，说明不存在，返回false
// 复杂度分析:
// 时间复杂度：O(n+m)。访问到的下标的行最多增加 n 次，列最多减少 m 次，因此循环体最多执行 n + m 次。
// 空间复杂度：O(1)。
function findNumberIn2DArray($matrix, $target) 
{
    if (empty($matrix) || !is_array($matrix) || empty($target)) {
        return false;
    }

    $row = 0;
    $col = count($matrix[0]) - 1;
    while (isset($matrix[$row][$col])) {
        if ($target == $matrix[$row][$col]) {
            return true;
        } else if ($target < $matrix[$row][$col]) {
            $col--;
        } else {
            $row++;
        }
    }
    return false;
}

// $matrix = 
//     [
//         [1,   4,  7, 11, 15],
//         [2,   5,  8, 12, 19],
//         [3,   6,  9, 16, 22],
//         [10, 13, 14, 17, 24],
//         [18, 21, 23, 26, 30]
//     ];
    
// $target = 5;
// var_dump(findNumberIn2DArray($matrix, $target));