<?php

/*
 * @Description: 二分查找
 * 如果在某个排好序的数组中查找指定值的位置，暴力解决的话需要 O(n) 的时间复杂度，但是如果二分的话则可以降低到 O(logn) 的时间复杂度
 * 每次根据 nums[mid] 和 target 之间的大小进行判断，相等则直接返回下标，nums[mid] < target 则 left 右移，nums[mid] > target 则 right 左移
 * 二分查找的思路不难理解，但是边界条件容易出错，比如 循环结束条件中 left 和 right 的关系，更新 left 和 right 位置时要不要加 1 减 1。
 * @Date: 2019-12-26 21:41:53
 * @LastEditTime : 2019-12-26 22:23:10
 */
function searchInsert($nums, $target)
{
    $left = 0;
    $right = count($nums) - 1;
    while ($left <= $right) {
        $mid = intval(($left + $right) / 2);
        if ($nums[$mid] == $target) {
            return $mid;
        } else if ($nums[$mid] < $target) {
            $left = $mid + 1;
        } else {
            $right = $mid - 1;
        }
    }

    return 0;
}

// function searchInsert($nums, $target)
// {
//     $left = 0;
//     $right = count($nums) - 1;
//     while ($left < $right) {
//         $mid = intval(($left + $right) / 2);
//         if ($nums[$mid] == $target) {
//             return $mid;
//         } else if ($nums[$mid] < $target) {
//             $left = $mid + 1;
//         } else {
//             $right = $mid;
//         }
//     }

//     return 0;
// }

var_dump(searchInsert(array(1,3,5,6), 6));